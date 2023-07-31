<?php

return [
    'default' => ($_ENV['DB_CONNECTION'] ?? 'mysql'),

    'connections' => [
        'sqlite' => [
            'url' => "sqlite:///" . dirname(__DIR__) . "/var/" . ($_ENV['MYSQL_DATABASE'] ?? 'db') . '.sqlite' ,
        ],
        'mysql' => [
            'dbname' =>  $_ENV['MYSQL_DATABASE'] ?? 'pulsar',
            'user' => $_ENV['MYSQL_USER'] ?? 'user',
            'password' => $_ENV['MYSQL_PASSWORD'] ?? 'secret',
            'host' => $_ENV['MYSQL_HOST'] ?? 'mysql',
            'port' => $_ENV['MYSQL_PORT'] ?? '3306',
            'driver' => 'pdo_mysql',

        ],
    ],
];
