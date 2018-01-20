<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建管理员用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute'=>'id',
                'contentOptions'=>['width'=>'10px']],
            'username',
            'nickname',
            //'password',
            'email:email',
            // 'profile:ntext',
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            ['attribute'=>'status',
                'value'=>function($model)
                {
                    return $model->Status;
                },
                'filter'=>\common\models\Adminuser::getAllStatus()],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {reset} {privilege}',
                'buttons' => [
                    'reset' => function ($url, $model, $key) {
                        return  Html::a('<span class="glyphicon glyphicon-lock"></span>',\yii\helpers\Url::toRoute(['adminuser/resetpwd/','id'=>$model->id]), ['title' => '修改密码','data' => [
                            'class' => 'btn btn-danger',
                            'confirm' => "确认要修改密码吗？",
                            'method' => 'post',
                        ],] ) ;
                    },
                    'privilege' => function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-user"></span>',\yii\helpers\Url::toRoute(['adminuser/privilege','id'=>$model->id]),['title'=>'权限设置','data' =>[
                                'confirm'=>"确定要修改权限吗？",
                        ]]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
