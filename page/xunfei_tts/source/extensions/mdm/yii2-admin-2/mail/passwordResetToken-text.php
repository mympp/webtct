<?php
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user mdm\admin\models\User */

$resetLink = Url::to(['user/reset-password','token'=>$user->password_reset_token], true);
?>
您好 <?= $user->username ?>,

请按照以下链接重设密码:

<?= $resetLink ?>
