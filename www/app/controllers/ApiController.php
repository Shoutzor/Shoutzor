<?php
namespace Shoutzor\Controller;

use Shoutzor\Model\Artist;
use Shoutzor\Model\Album;
use Shoutzor\Model\Media;
use Shoutzor\Model\Request;
use Shoutzor\Model\History;
use Shoutzor\AutoDJ\AutoDJ;
use Shoutzor\AutoDJ\QueueManager;
use Shoutzor\Parser\File as Parser;
use Shoutzor\Liquidsoap\Manager as LiquidsoapManager;

use AcoustID;

use ReflectionMethod;
use Exception;
use DateTime;
use DateInterval;
use DateTimeZone;

class ApiController extends ControllerBase
{

    private $shoutzorRunning = true;

    /* API Result codes */
    const CODE_SUCCESS      = 200;
    const CODE_BAD_REQUEST  = 400;
    const CODE_FORBIDDEN    = 403;
    const CODE_NOT_FOUND    = 404;
    const CODE_CANT_PROCESS = 422;

    /* API Result messages */
    const API_CALL_SUCCESS = [
        'code'      => self::CODE_SUCCESS,
        'message'   => 'API call succeeded'
    ];

    const INVALID_PARAMETER_VALUE = [
        'code'      => self::CODE_BAD_REQUEST,
        'message'   => 'Invalid Parameter Value(s) provided'
    ];

    const INVALID_METHOD = [
        'code'      => self::CODE_BAD_REQUEST,
        'message'   => 'Invalid API method'
    ];

    const NO_METHOD_PROVIDED = [
        'code'      => self::CODE_BAD_REQUEST,
        'message'   => 'No API method provided'
    ];

    const INVALID_SECRET = [
        'code'      => self::CODE_FORBIDDEN,
        'message'   => 'Invalid secret token provided'
    ];

    const METHOD_NOT_AVAILABLE = [
        'code'      => self::CODE_FORBIDDEN,
        'message'   => 'You do not have the permissions to access this method'
    ];

    const ITEM_NOT_FOUND = [
        'code'      => self::CODE_NOT_FOUND,
        'message'   => 'The API method could not find the object related to the provided parameters'
    ];

    const ERROR_IN_REQUEST = [
        'code'      => self::CODE_CANT_PROCESS,
        'message'   => 'An error is preventing this method from executing properly'
    ];

    public function initialize()
    {
      //$this->view->setTemplateAfter('');
    }

    private function formatOutput($data, $result = self::API_CALL_SUCCESS) {
        $this->response->setJsonContent([
            'data' => $data,
            'info' => $result
        ], JSON_UNESCAPED_UNICODE);

        return $this->response;
    }

    /**
     * Make sure the API commands are run by the server only
     * @todo make this a bit more secure rather then a localhost only check..
     * @throws Exception
     */
    protected function ensureLocalhost()
    {
        $whitelist = array(
            '127.0.0.1',
            '::1'
        );

        if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return false;
        }

        return true;
    }

    protected function getPath($path = '')
    {
        $path = $this->normalizePath($path);

        if(substr($path, -1) !== '/') {
            $path .= '/';
        }

        return $path;
    }

    /**
     * Normalizes the given path
     *
     * @param  string $path
     * @return string
     */
    protected function normalizePath($path)
    {
        $path   = str_replace(['\\', '//'], '/', $path);
        $prefix = preg_match('|^(?P<prefix>([a-zA-Z]+:)?//?)|', $path, $matches) ? $matches['prefix'] : '';
        $path   = substr($path, strlen($prefix));
        $parts  = array_filter(explode('/', $path), 'strlen');
        $tokens = [];

        foreach ($parts as $part) {
            if ('..' === $part) {
                array_pop($tokens);
            } elseif ('.' !== $part) {
                array_push($tokens, $part);
            }
        }

        return $prefix . implode('/', $tokens);
    }

    /* API Methods */

    /**
     * @Route("/", name="index", methods={"GET", "POST"})
     */
    public function apiAction()
    {
      $request = new \Phalcon\Http\Request();

      //Check whether the param values should be fetched from GET or POST
      if($request->isPost())
      {

          $params = $request->getPost();
      }
      else
      {
          $params = $request->getQuery();
      }

      //If no method is provided, return false
      if(isset($params['method']) === false || is_null($params['method'])) {
          return $this->formatOutput(false, self::NO_METHOD_PROVIDED);
      }

      $method = $params['method'];

      /**
      * Check if the method exists
      */
      if (method_exists($this, $method))
      {
          $reflection = new ReflectionMethod($this, $method);

          //Valid callable methods are "public", anything else is protected or private
          if ($reflection->isPublic()) {
              return $this->$method($params);

          }
      }

      //The above validation check failed, return the invalid method response
      return $this->formatOutput(false, self::INVALID_METHOD);
    }

    /**
     * Automatically parses music files that have not been parsed yet
     * @method autoparse
     */
    public function autoparse() {
        //Make sure it's the server that requested this method
        if($this->ensureLocalhost() === false) {
            return $this->formatOutput('You have no access to this method', self::METHOD_NOT_AVAILABLE);
        }

        //Get our configuration values
        $config   = $this->config->shoutzor;
        $lastRun  = $config->parserLastRun;

        //Check if the last-run time was more then 1 minute ago to make sure no other parser processes are running
        if($lastRun > strtotime("-1 minute")) {
            return $this->formatOutput('A parser is already running or has been running too recently', self::ERROR_IN_REQUEST);
        }

        //Get a list of items that need to be parsed
        $toParse = Media::find([
          'constraints' => 'status = :status_uploaded OR status = :status_error',
          'limit' => $config->parserMaxItems,
          'bind' => [
            'status_uploaded' => Media::STATUS_UPLOADED,
            'status_error' => Media::STATUS_ERROR
          ]
        ]);

        //Parse each item
        foreach($toParse as $item) {
            //Update the parserLastRun value to the current time
            $this->config->shoutzor->parserLastRun = time();

            //Parse the item
            $this->parse($item);
        }

        //Return true
        return $this->formatOutput(true);
    }

    /**
     * Parses and converts music files
     * @method parse
     * @param Media params the media object to parse
     */
    public function parse($media)
    {
        if($this->ensureLocalhost() === false) {
            return $this->formatOutput('You have no access to this method', self::METHOD_NOT_AVAILABLE);
        }

        //Make sure the requested media object exists
        if(!$media instanceof Media) {
            return $this->formatOutput('No media object with the provided ID exists', self::ITEM_NOT_FOUND);
        }

        if($media->status === Media::STATUS_FINISHED) {
            return $this->formatOutput('This media object has already been parsed', self::ERROR_IN_REQUEST);
        }

        //Set our media file to the processing status
        $media->status = Media::STATUS_PROCESSING;
        $media->save();

        //Initialize our parser class
        $parser = new Parser();

        //Our main storage path
        $path = $parser->getMediaDir();

        //Get the path from the file in the temporary Directory
        $filepath = $parser->getTempMediaDir() . '/' . $media->filename;

        //Make sure our root path exists and is writable
        if((!is_dir($path) && !mkdir($path)) ||  !is_writable($path)) {
            return $this->formatOutput('Directory '.$path.' is not writable, Permission denied', self::ERROR_IN_REQUEST);
        }

        //Make sure our file exists
        if (!file_exists($filepath)) {
            return $this->formatOutput('Media file '.$filepath.' does not exist', self::ERROR_IN_REQUEST);
        }

        //Make sure our file is readable
        if (!is_readable($filepath)) {
            return $this->formatOutput('Cannot read media file '.$filepath.', Permission denied', self::ERROR_IN_REQUEST);
        }

        //Since its just an audio file, parse immediately
        $media->status = $parser->parse($media);

        //If the parse succeeded, save it in the database
        if($media->status == Media::STATUS_FINISHED || $media->status == Media::STATUS_ERROR) {
            $media->save();
        }

        //If the parse failed, the status will be set to the relevant code. Also no need to save the record

        /*
            @TODO
            Perhaps implement some form of converting to mp3 here?
            Or preserve this method for downloading of youtube videos, and converting those to mp3's
        */

        return $this->formatOutput((array) $media);
    }

    /**
     * Handles the file uploads
     * @method upload
     * @param musicfile the file that is beeing uploaded
     */
    public function upload($params)
    {
        //Make sure file uploads are enabled
        if($this->config->shoutzor->uploadEnabled == false) {
            return $this->formatOutput('File uploads have been disabled', self::METHOD_NOT_AVAILABLE);
        }

        //Make sure file uploads are enabled
        if(!$this->session->get('auth') || !$this->session->get('auth')->hasAccess("shoutzor: upload files")) {
            return $this->formatOutput('You have no permission to upload files', self::METHOD_NOT_AVAILABLE);
        }

        //Initialize our parser class
        $parser = new Parser();

        //Our temporary storage path
        $path = $parser->getTempMediaDir();

        //Make sure our temporary directory exists and is writable
        if((!is_dir($path) && !mkdir($path)) || !is_writable($path)) {
            return $this->formatOutput('Directory '.$path.' is not writable, Permission denied', self::ERROR_IN_REQUEST);
        }

        //Get the uploaded file
        $file = $this->request->getUploadedFiles()->get('musicfile');

        //Make sure the uploaded file is uploaded correctly
        if($file === null) {
            return $this->formatOutput('No file has been uploaded with name: musicfile', self::INVALID_PARAMETER_VALUE);
        }

        if($file->isValid() === false) {
            return $this->formatOutput('The uploaded file has not been uploaded correctly', self::INVALID_PARAMETER_VALUE);
        }

        $filename = md5(uniqid("", true)).'.'.$file->getClientOriginalName();

        //Save the file into our temporary directory
        $file->move($path, $filename);

        $media = Media::create([
            'title' => $file->getClientOriginalName(),
            'filename' => $filename,
            'uploader_id' => $this->session->get('auth')->id,
            'created' => new DateTime(),
            'status' => Media::STATUS_UPLOADED,
            'crc' => '',
            'duration' => 0
        ]);

        //Since its just an audio file, parse immediately
        $media->status = $parser->parse($media);

        //If the parse succeeded, save it in the database
        if($media->status == Media::STATUS_FINISHED || $media->status == Media::STATUS_ERROR) {
            $media->save();
        }

        //If the parse failed, the status will be set to the relevant code. Also no need to save the record

        //No problems, return result
        return $this->formatOutput((array) $media);
    }

    /**
     * Handles the file uploads
     * @method request
     * @param id the ID from the media file thats requested
     */
    public function request($params) {
        if($this->shoutzorRunning === false) {
            return $this->formatOutput('Shoutzor is currently not running or restarting, try again in a few seconds', self::METHOD_NOT_AVAILABLE);
        }

        //Make sure file uploads are enabled
        if(!$this->session->get('auth') || !$this->session->get('auth')->hasAccess("shoutzor: add requests")) {
            return $this->formatOutput('You have no permission to request', self::METHOD_NOT_AVAILABLE);
        }

        //Make sure file uploads are enabled
        if($this->config->shoutzor->requestEnabled == 0) {
            return $this->formatOutput('File requests have been disabled', self::METHOD_NOT_AVAILABLE);
        }

        //Validate the parameter value
        if(!is_numeric($params['id'])) {
            return $this->formatOutput('Not a valid numerical value provided for the media object ID', self::INVALID_PARAMETER_VALUE);
        }

        //Check if the requested Music ID exists
        $media = Media::find([
          'constraints' => 'id = :id:',
          'bind' => [
            'id' => $params['id']
          ]
        ]);

        if($media == null || !$media) {
            return $this->formatOutput('No media object with the provided ID exists', self::ITEM_NOT_FOUND);
        }

        //Check if the media file is in queue already
        if (Media::isRequested($media->id)) {
            return $this->formatOutput('This media file is already in the queue!', self::ERROR_IN_REQUEST);
        }

        //Get the config options
        $config = $this->config->shoutzor;

        $canRequestDateTime = (new DateTime())->sub(new DateInterval('PT'.$config->mediaRequestDelay.'M'))->format('Y-m-d H:i:s');

        //Check if the media file has been played too recently
        if (Media::isRecentlyPlayed($media->id, $canRequestDateTime)) {
            return $this->formatOutput('This media file has been requested too recently', self::ERROR_IN_REQUEST);
        }

        $canRequestDateTime = (new DateTime())->sub(new DateInterval('PT'.$config->artistRequestDelay.'M'))->format('Y-m-d H:i:s');
        //Fetch a list of all artist id's
        if (Artist::isRecentlyPlayed($media->id, $canRequestDateTime)) {
            return $this->formatOutput('This artist has been played too recently', self::ERROR_IN_REQUEST);
        }

        $canRequestDateTime = (new DateTime())->sub(new DateInterval('PT'.$config->userRequestDelay.'M'))->format('Y-m-d H:i:s');

        //Check if the user hasnt already recently requested a media file
        $recentRequest = Request::findFirst([
          'constraints' => 'requester_id = :user AND requesttime > :requesttime',
          'bind' => [
            'user' => $this->session->get('auth')->id,
            'requesttime' => $canRequestDateTime
          ]
        ]);

        if ($recentRequest) {
            return $this->formatOutput('You already recently requested a media file, try again in 10 minutes', self::ERROR_IN_REQUEST);
        }

        try {
            $queueManager = new QueueManager();
            $queueManager->addToQueue($media);
        } catch(Exception $e) {
            return $this->formatOutput($e->getMessage(), self::ERROR_IN_REQUEST);
        }

        return $this->formatOutput(true);
    }

    /**
     * Runs a liquidsoap command
     * @method liquidsoapcommand
     * @param type the type of the script to start
     * @param command the command to run
     * @param options extra options to provide with the command
     */
    public function liquidsoapcommand($params) {
        $liquidsoapManager = new LiquidsoapManager();

        if(!$this->session->get('auth') ||  !$this->session->get('auth')->hasAccess('shoutzor: manage shoutzor controls')) {
            return $this->formatOutput('You have no permission to manage shoutzor controls', self::METHOD_NOT_AVAILABLE);
        }

        switch($params['command']) {
            case "start":
                //Get the status of the script before we start it
                $status = $liquidsoapManager->isUp($params['type']);

                //Start our script
                $result = $liquidsoapManager->startScript($params['type']);

                //Make sure we don't import the queue if the script was already running
                if($params['type'] == 'shoutzor' && $status === false) {
                    $autoDJ = new AutoDJ();
                    $autoDJ->importQueue();
                }
                break;

            case "stop":
                $result = $liquidsoapManager->stopScript($params['type']);
                break;

            case "volume":
                $result = $liquidsoapManager->setVolume($params['type'], $params['options']);
                break;

            case "next":
                $result = $liquidsoapManager->nextTrack();
                break;

            case "remaining":
                $result = $liquidsoapManager->remaining();
                break;

            case "uptime":
                $result = $liquidsoapManager->isUp($params['type']);
                break;

            case "help":
                $result = $liquidsoapManager->help($params['type']);
                break;

            default:
                return $this->formatOutput('Invalid command provided', self::INVALID_PARAMETER_VALUE);
                break;
        }

        if($result) {
            return $this->formatOutput($result);
        }

        return $this->formatOutput(false, self::ERROR_IN_REQUEST);
    }

    /**
     * Automatically fixes the shoutzor script
     * This method gets called by shoutzor when blank audio is detected for a prolonged time
     * As the result of some kind of crash (possibly?)
     * @method autofix
     */
    public function autofix($params) {
        if($this->ensureLocalhost() === false) {
            return $this->formatOutput('You have no access to this method', self::METHOD_NOT_AVAILABLE);
        }

        //Prevent the request method from adding the request while we are restarting shoutzor
        $this->shoutzorRunning = false;

        $liquidsoapManager = new LiquidsoapManager();
        $liquidsoapManager->stopScript('shoutzor');

        sleep(5);

        $liquidsoapManager->startScript('shoutzor');

        sleep(1);

        //Get the remaining queue and add them all to shoutzor
        $autoDJ = new AutoDJ();
        $autoDJ->importQueue();

        //Shoutzor is back up and running, requests are now allowed again
        $this->shoutzorRunning = true;

        return $this->formatOutput(true);
    }

    /**
     * Notifies the webapp that the next track is playing
     * This method gets called by shoutzor when the next song is played
     * Use this method to pop the first element from the queue
     * @method nexttrack
     */
    public function nexttrack($params) {
        if($this->ensureLocalhost() === false) {
            return $this->formatOutput('You have no access to this method', self::METHOD_NOT_AVAILABLE);
        }

        $autodj = new AutoDJ();
        $autodj->playNext();

        return $this->formatOutput(true);
    }

    /**
     * Gets the current Queue list in JSON format
     * @method queuelist
     */
    public function queuelist($params) {
        //Get the queued items
        $queued = Media::getQueued();

        $nowplaying = Media::getNowplaying();

        if(is_null($nowplaying)) {
            $starttime = new DateTime('now', new DateTimeZone("UTC"));
        } else {
            $starttime = new DateTime($nowplaying->played_at, new DateTimeZone("UTC"));
            $starttime->add(new DateInterval('PT'.$nowplaying->duration.'S'));
        }

        return $this->formatOutput(['tracks' => array_values($queued), 'starttime' => $starttime->getTimestamp()]);
    }

    /**
     * Gets the current History list in JSON format
     * @method historylist
     */
    public function historylist($params) {
        //Get the history
        $history = Media::getHistory();

        return $this->formatOutput(['tracks' => array_values($history)]);
    }

    /**
     * Gets the track that is currently playing
     * @method nowplaying
     */
    public function nowplaying($params) {
        $history = Media::getNowplaying();

        return $this->formatOutput($history);
    }
}
