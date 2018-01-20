<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['attribute'=>'id',
                'contentOptions'=>['width'=>'10px'],],
            'username',
            'email',
            //'status',
            ['attribute'=>'status',
                'value'=>function($model){
                    return $model->status==\common\models\User::STATUS_ACTIVE?'激活':'禁止';
                },
                'filter'=>\common\models\User::getAllStatus(),],
            // 'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}{enable}',
                'buttons'=>[
                        'enable' => function ($url, $model, $key) {
                            return  $model->status==\common\models\User::STATUS_DELETED?Html::a('<span class="glyphicon glyphicon-ok-circle"></span>',\yii\helpers\Url::toRoute(['user/enable/','id'=>$model->id]), ['title' => '禁用/启用','data' => [
                        'class' => 'btn btn-danger',
                        'confirm' => "确认要启用该用户吗？",
                        'method' => 'post',
                    ],] ):Html::a('<span class="glyphicon glyphicon-ban-circle"></span>',\yii\helpers\Url::toRoute(['user/enable/','id'=>$model->id]), ['title' => '禁用/启用','data' => [
                                'class' => 'btn btn-danger',
                                'confirm' => "确认要禁用该用户吗？",
                                'method' => 'post',
                            ],] ) ;
                },]],
        ],
    ]); ?>
</div>
