<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '权限设置: ' . $model->nickname;
$this->params['breadcrumbs'][] = ['label' => '管理员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '权限设置';
?>
<div class="adminuser-privilege">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::checkboxList('newPriv',$authAssignArray,$authItemArray); ?>

    <?= Html::submitButton( '保存' , ['class' => 'btn btn-success']) ?>

</div>
