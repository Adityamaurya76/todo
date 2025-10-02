<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$env = require __DIR__ . '/env.php';

$config = [
    'id' => 'todo-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'cache' => ['class' => 'yii\caching\FileCache'],
        'log' => [
            'targets' => [
                ['class' => 'yii\log\FileTarget', 'levels' => ['error', 'warning']],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];

return $config;