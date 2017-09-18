<?php

// 在生产模式下，注释以下两行
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../tcyiisource/vendor/autoload.php');
require(__DIR__ . '/../tcyiisource/modules/admin/vendor/autoload.php');
require(__DIR__ . '/../tcyiisource/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../tcyiisource/config/web.php');

(new yii\web\Application($config))->run();
