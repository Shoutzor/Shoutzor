<?php

namespace Shoutzor\Controller;

use Shoutzor\Model\Media;

class UploadController extends ControllerBase
{
  public function initialize()
  {
    $this->view->setTemplateBefore('dashboard');
    $this->view->setTemplateAfter('common');
    $this->addBaseAssets();

    $this->assets->addInlineJs("require(['upload', 'jsrender', 'uploadmanager', 'upload/index']);", false);
  }

  public function indexAction()
  {
    $user = $this->session->get('auth');

    $uploads = Media::find([
      'constraints' => 'uploader_id = :uploader AND status != :finished',
      'order'       => 'created DESC',
      'bind' => [
        'uploader' => $user->id,
        'finished' => Media::STATUS_FINISHED
      ]
    ]);

    $this->view->setVar('uploads', $uploads);
    $this->view->setVar('maxFileSize', $this->formatBytes($this->file_upload_max_size()));
    $this->view->setVar('maxDuration', $this->config->shoutzor->uploadDurationLimit);

  }

  //TODO move to utility class
  private function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
  }

  //TODO move to utility class
  // Returns a file size limit in bytes based on the PHP upload_max_filesize
  // and post_max_size
  private function file_upload_max_size() {
      static $max_size = -1;
      if ($max_size < 0) {
          // Start with post_max_size.
          $max_size = $this->parse_size(ini_get('post_max_size'));
          // If upload_max_size is less, then reduce. Except if upload_max_size is
          // zero, which indicates no limit.
          $upload_max = $this->parse_size(ini_get('upload_max_filesize'));
          if ($upload_max > 0 && $upload_max < $max_size) {
              $max_size = $upload_max;
          }
      }
      return $max_size;
  }

  //TODO move to utility class
  private function parse_size($size) {
      $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
      $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
      if ($unit) {
          // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
          return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
      }
      else {
          return round($size);
      }
  }

}
