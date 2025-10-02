<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$env = require __DIR__ . '/env.php';

$config = [
    'id' => 'todo-app',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => ['cookieValidationKey' => 'your-secret-key-here'],
        'cache' => ['class' => 'yii\caching\FileCache'],
        'user' => ['identityClass' => 'app\models\User', 'enableAutoLogin' => true],
        'errorHandler' => ['errorAction' => 'site/error'],
        'mailer' => ['class' => 'yii\swiftmailer\Mailer', 'useFileTransport' => true],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                ['class' => 'yii\log\FileTarget', 'levels' => ['error', 'warning']],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],
    'params' => $params,
];

if ($env['APP_DEBUG']) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
