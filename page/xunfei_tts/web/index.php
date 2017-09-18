<?php

// 在生产模式下，注释以下两行
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../source/extensions/mdm/yii2-admin-2/vendor/autoload.php');

require(__DIR__ . '/../../../yii2/vendor/autoload.php');
require(__DIR__ . '/../../../yii2/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../source/config/web.php');

(new yii\web\Application($config))->run();
