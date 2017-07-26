<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use app\widgets\Alert;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

list(, $url) = Yii::$app->assetManager->publish('@mdm/admin/assets');
$this->registerCssFile($url . '/main.css');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php
NavBar::begin([
    'brandLabel' => false,
    'options'    => ['class' => 'navbar-inverse navbar-fixed-top'],
]);

if (!empty($this->params['top-menu']) && isset($this->params['nav-items'])) {
    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav'],
        'items'   => $this->params['nav-items'],
    ]);
}

echo Nav::widget([
    'options' => ['class' => 'nav navbar-nav navbar-right'],
    'items'   => $this->context->module->navbar,
]);
NavBar::end();
?>

<div class="container">
    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>
</div>

<footer class="footer">

</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
