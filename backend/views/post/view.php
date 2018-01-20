<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $a = ' ';
    echo var_dump(\common\models\Tag::string2array($a));
    ?>
    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'tags:ntext',
            /*'status',*/
            ['attribute'=>'status','value'=>$model->status0->name],
            /*'create_time:datetime',*/
            ['attribute'=>'create_time','value'=>date('Y-m-d h:i:s',$model->create_time)],
            /*'update_time:datetime',*/
            ['attribute'=>'update_time','value'=>date('Y-m-d h:i:s',$model->update_time)],
            /*'author_id',*/
            ['attribute'=>'author_id','value'=>$model->author->nickname],
        ],
        'template' => '<tr><th style="width: 120px">{label}</th><td>{value}</td></tr>',
        'options'=>['class'=>'table table-striped table-bordered detail-view'],
    ]) ?>


</div>
