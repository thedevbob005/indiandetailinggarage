<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database settings
        "dbase" => [
            "host" => "localhost",
            "dbname" => "idgdb",
            "user" => "root",
            "pass" => ""
        ],

        // Mail settings (Internal mail server)
        "mail" => [
            "using" => "", // "smtp" or "sendmail". Default is "sendmail" if left blank.
            "email" => "", // full email address
            "name" => "", // full name of the owner of the email address
            "host" => "", // hostname or ip
            "user" => "", // username for smtp
            "pass" => ""  // password for smtp
        ],
    ],
];
