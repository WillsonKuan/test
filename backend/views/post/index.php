<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //显示id到index页面，并设置内容属性
            ['attribute'=>'id',
                'contentOptions'=>['width'=>'3px']],
            'title',
            //'author_id',
            //显示authorName到页面，注意authorName并不是真正的数据列，只是由author_id连接到Administrator中取出的nick_name值
            ['attribute'=>'authorName',
                'value'=>'author.nickname',
                //'filter'=>\common\models\Adminuser::find()->select('nickname,id')->indexBy('id')->column(),
                ],
            //'content:ntext',
            'tags:ntext',
            //'status',
            //显示状态名到页面，同时status0.name也不是真正数据列，只是Post中getStatus0中得出Poststatus中对于的name
            ['attribute'=>'status',
                'value'=>'status0.name',
                //返回一个PostStatus的id,name对应数组到搜索框中
                'filter'=>\common\models\Poststatus::find()->select('name,id')->indexBy('id')->column(),
            ],
            // 'create_time:datetime',
             //'update_time:datetime',
            //显示update_time到页面
            ['attribute'=>'update_time',
                //设置格式
                'format'=>['date','php: Y-m-d h:i:s'],
                ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
