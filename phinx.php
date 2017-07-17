<?php

$pdo = new PDO(
    'mysql:dbname=simply;host=localhost', 'root', 'toor',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

return [

    'paths' => [
        'migrations' => __DIR__ . '/database/migrations',
        'seeds'      => __DIR__ . '/database/seeds'
    ],

    'environments' => [
        'default_database' => 'development',
        'development' => [
            'name'       => 'simply',
            'connection' => $pdo
        ]

    ]

];