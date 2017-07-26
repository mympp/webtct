<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $searchModel mdm\admin\models\searchs\User */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('rbac-admin', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            'email:email',
            [
                'attribute' => 'id',
                'header'    => '角色',
                'format'    => 'raw',
                'value'     => function ( $model ) {
                    $userRoles = Yii::$app->getAuthManager()->getRolesByUser($model->id);

                    if (!empty($userRoles)) {
                        $roleNames = [];
                        foreach ($userRoles as $roleName => $roleItem) {
                            $roleName = Html::encode($roleName);
                            $roleNames[] = Html::a($roleName, ['/admin/role/view', 'id' => $roleName]);
                        }

                        return implode('，', $roleNames);
                    }

                    return '';
                },
                'filter'    => false,
            ],
            'created_at:date',
            [
                'attribute' => 'status',
                'value'     => function ( $model ) {
                    return $model->status == 0 ? '关闭' : '开启';
                },
                'filter'    => [
                    0  => '关闭',
                    10 => '开启',
                ],
            ],
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
                'buttons'  => [
                    'activate' => function ( $url, $model ) {
                        if ($model->status == 10) {
                            return '';
                        }
                        $options = [
                            'title'        => Yii::t('rbac-admin', 'Activate'),
                            'aria-label'   => Yii::t('rbac-admin', 'Activate'),
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method'  => 'post',
                            'data-pjax'    => '0',
                        ];

                        return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, $options);
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
