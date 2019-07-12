<?php

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'configured' => false,
    'database' => [
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'test',
        'charset'     => 'utf8'
    ],
    'shoutzor'  => [
      'useFilenameIfUntitled' => 1,
      'uploadDurationLimit'   => 5,
      'parserLastRun'         => 0,
      'parserMaxItems'        => 5,
      'uploadEnabled'         => 1,
      'requestEnabled'        => 1,
      'userRequestDelay'      => 10,
      'mediaRequestDelay'     => 60,
      'artistRequestDelay'    => 30,
      'mediaDir'              => BASE_PATH . '/media/',
      'imageDir'              => BASE_PATH . '/public/assets/images/downloaded/'
    ],
    'modules' => [
      'acoustid'  => [
        'enabled' => true,
        'appKey'  => 'not-set'
      ],
      'lastfm'  => [
        'enabled' => true,
        'apiKey'  => 'not-set',
        'secret'  => 'not-set'
      ],
      'liquidsoap' => [
        'pidFileDirectory' =>'/usr/local/var/run/liquidsoap/',
        'logDirectoryPath' => '/tmp/shoutzor',
        'socketPath' => '/tmp/shoutzor',
        'socketPermissions' => 511,
        'wrapperLogStdout' => "true",
        'wrapperServerTelnet' => "false",
        'wrapperServerSocket' => "true",
        'shoutzorLogStdout' => "true",
        'shoutzorServerTelnet' => "false",
        'shoutzorServerSocket' => "true",
        'wrapperInputListeningMount' => '/streaminput',
        'wrapperInputListeningPort' => '1337',
        'wrapperInputListeningPassword' => 'hackme',
        'wrapperOutputHost' => 'localhost',
        'wrapperOutputMount' => '/shoutzor',
        'wrapperOutputPort' => '8000',
        'wrapperOutputPassword' => 'hackme',
        'shoutzorUrl' => ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://") . $_SERVER['SERVER_NAME'],
        'encodingBitrate' => 192,
        'encodingQuality' => 2
      ]
    ],
    'application' => [
        'appDir'         => APP_PATH . '/',
        'libDir'         => APP_PATH . '/lib/',
        'controllersDir' => APP_PATH . '/controllers/',
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'pluginsDir'     => APP_PATH . '/plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/cache/volt/',
        'etcDir'         => BASE_PATH . '/etc/',

        // This allows the baseUri to be understand project paths that are not in the root directory
        // of the webpspace.  This will break if the public/index.php entry point is moved or
        // possibly if the web server rewrite rules are changed. This can also be set to a static path.
        'baseUri'        => preg_replace('/public([\/\\\\])index.php$/', '', $_SERVER["PHP_SELF"]),
    ]
]);
