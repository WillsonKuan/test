<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            ['attribute'=>'id',
                'contentOptions'=>['width'=>'10px'],],
            //方法一
            ['attribute'=>'content',
                'value'=>'beginningComment',],
            //方法二
            //'content:ntext',
            /*['attribute'=>'content',
                'value'=>function($model){
                    //去除html字符
                    $tmplStr = strip_tags($model->content);
                    //计算临时字符串长度,mb_strlen计算中文字符
                    $count = mb_strlen($tmplStr,'utf-8');
                    //三元表达式，如果超过20字符，取20字符，如果超过增加点点
                    return $count>20?mb_substr($tmplStr,0,20,'utf-8').'...':$tmplStr;
                    //return $tmplStr;

    },],*/
            //'status',
            ['attribute'=>'status',
                'value'=>'status0.name',
                'filter'=>\common\models\Commentstatus::find()
                            ->select('name,id')
                            ->indexBy('id')
                            ->column(),
                'contentOptions' =>function($model){
                    return ($model->status===1)?['class'=>'bg-danger']:['class'=>'bg-success'];
                },],
            //'create_time:datetime',
            ['attribute'=>'create_time',
                'value'=>'beginningTime',],
            //'userid',
            ['attribute'=>'authorName',
                'label'=>'用户',
                'value'=>'user.username',],
            // 'email:email',
            // 'url:url',
            // 'post_id',
            ['attribute'=>'title',
                'label'=>'标题',
                'value'=>'post.title',],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {approve} {forbit}',
            'buttons' => [
            'approve' => function ($url, $model, $key) {
                return  Html::a('<span class="glyphicon glyphicon-ok-circle"></span>',\yii\helpers\Url::toRoute(['comment/approve/','id'=>$model->id]), ['title' => '审核','data' => [
                        'class' => 'btn btn-danger',
                        'confirm' => "确认要通过审核吗？",
                        'method' => 'post',
                ],] ) ;
                },
            'forbit' => function ($url, $model, $key) {
                    return  Html::a('<span class="glyphicon glyphicon-ban-circle"></span>',\yii\helpers\Url::toRoute(['comment/forbit/','id'=>$model->id]), ['title' => '返审','data' => [
                            'class' => 'btn btn-danger',
                            'confirm' => "确认要返回审核吗？",
                            'method' => 'post',
                    ],] ) ;
                },
    ],
            ],


        ],





    ]); ?>
</div>
