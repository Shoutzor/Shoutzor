<?php

return [
    'installed' => env('SHOUTZOR_INSTALLED', 'false'),
    'version' => env('SHOUTZOR_VERSION', '1.0'),

    'useFilenameIfUntitled' => 1,
    'uploadDurationLimit' => 5,
    'parserLastRun' => 0,
    'parserMaxItems' => 5,
    'uploadEnabled' => 1,
    'requestEnabled' => 1,
    'userRequestDelay' => 10,
    'mediaRequestDelay' => 60,
    'artistRequestDelay' => 30,

    'modules' => [
        'liquidsoap' => [
            'pidFileDirectory' => '/usr/local/var/run/liquidsoap/',
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
            'encodingBitrate' => 192,
            'encodingQuality' => 2
        ]
    ]
];
