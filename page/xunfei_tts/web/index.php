<?php

// 在生产模式下，注释以下两行
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../source/extensions/mdm/yii2-admin-2/vendor/autoload.php');

<<<<<<< HEAD
require(__DIR__ . '/../../../yii2/vendor/autoload.php');
require(__DIR__ . '/../../../yii2/vendor/yiisoft/yii2/Yii.php');
=======
require(__DIR__ . '/../../../../tcyiisource/vendor/autoload.php');
require(__DIR__ . '/../../../../tcyiisource/vendor/yiisoft/yii2/Yii.php');
>>>>>>> 7a8cbe70be89172640f1d56cf50ed8b50083e074

$config = require(__DIR__ . '/../source/config/web.php');

(new yii\web\Application($config))->run();
