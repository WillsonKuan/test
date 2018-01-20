<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>
    //重写status的值，由Poststatus中获得，并以下拉列表选取
    <?= $form->field($model, 'status')->dropDownList(\common\models\Poststatus::find()->select('name,id')->indexBy('id')->column(),['prompt'=>'请选择']) ?>
    //重写nick_name的值，由Administrator中获得，并以下拉列表选取
    <?= $form->field($model, 'author_id')->dropDownList(\common\models\Adminuser::find()->select('nickname,id')->indexBy('id')->column(),['prompt'=>'请选择']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
