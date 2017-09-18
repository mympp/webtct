<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

$auth = Yii::$app->getAuthManager();
$user = Yii::$app->user;

var_dump($user->can('giiManage'));

?>
