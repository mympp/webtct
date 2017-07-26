<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = Yii::t('rbac-admin', 'Assignments');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    $usernameField,
    [
        'attribute' => $usernameField,
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
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class'    => 'yii\grid\ActionColumn',
    'template' => '{view}',
];
?>
<div class="assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => $columns,
    ]);
    ?>
    <?php Pjax::end(); ?>

</div>
