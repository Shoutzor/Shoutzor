<?php

return [
    'useFilenameIfUntitled' => 1,
    'uploadDurationLimit'   => 5,
    'parserLastRun'         => 0,
    'parserMaxItems'        => 5,
    'uploadEnabled'         => 1,
    'requestEnabled'        => 1,
    'userRequestDelay'      => 10,
    'mediaRequestDelay'     => 60,
    'artistRequestDelay'    => 30,

    'modules' => [
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
    ]
];
