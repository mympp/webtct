<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id'                  => 'basic-console',
    'basePath'            => dirname(__DIR__),
    'runtimePath'         => dirname(__DIR__) . '/../runtime/',
<<<<<<< HEAD
    'vendorPath'          => dirname(__DIR__) . '/../../../yii2/vendor',
=======
    'vendorPath'          => dirname(__DIR__) . '/../../../../tcyiisource/vendor',
>>>>>>> 7a8cbe70be89172640f1d56cf50ed8b50083e074
    'bootstrap'           => ['log'],
    'controllerNamespace' => 'app\commands',
    'components'          => [
        'cache'       => [
            'class' => 'yii\caching\FileCache',
        ],
        'log'         => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'          => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ],
    ],
    'params'              => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
    'aliases'             => [
        '@mdm/admin' => '@app/extensions/mdm/yii2-admin-2',
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
