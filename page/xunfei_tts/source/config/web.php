<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id'             => 'basic',
    'basePath'       => dirname(__DIR__),
    'runtimePath'    => dirname(__DIR__) . '/../runtime/',
    'vendorPath'     => dirname(__DIR__) . '/../../../yii2/vendor',
    'bootstrap'      => ['log'],
    'name'           => 'TTS文本转换语音系统',
    'language'       => 'zh-CN',
    'sourceLanguage' => 'en-US',
    'defaultRoute'   => '/tts/index',
    'components'     => [
        'request'      => [
            'cookieValidationKey' => 'VBIJu4HMOJq2qyKxALaZ9hZHC3-2T-ev',
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass' => 'mdm\admin\models\User',
            'loginUrl'      => ['/admin/user/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,

            'transport' => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.163.com',
                'username'   => 'garfield_email@163.com',
                'password'   => 'b90d5e0cf326de5e',
                'port'       => '25',
                'encryption' => 'tls',
            ],
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => require(__DIR__ . '/db.php'),
        'urlManager'   => [
            'enablePrettyUrl' => false,
            'showScriptName'  => true,
            'rules'           => [
                '/site/login'  => '/admin/user/login',
                '/site/signup' => '/admin/user/signup',
                '/site/logout' => '/admin/user/logout',
            ],
        ],
        'authManager'  => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
    'as access'      => [
        'class'        => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/user/login',
            'admin/user/logout',
            'admin/user/request-password-reset',
        ],
    ],
    'aliases'        => [
        '@mdm/admin' => '@app/extensions/mdm/yii2-admin-2',
    ],
    'modules'        => [
        'admin' => [
            'class'  => 'mdm\admin\Module',
            'layout' => 'top-menu',
        ],
    ],
    'params'         => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
