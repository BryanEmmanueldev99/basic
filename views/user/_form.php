<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin((['options' => ['enctype' => 'multipart/form-data', 'class' => 'bg-white w-75 mx-auto shadow-sm p-4']])); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_pass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'avatar')->fileInput(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
