<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '新建管理员用户';
$this->params['breadcrumbs'][] = ['label' => '管理员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
