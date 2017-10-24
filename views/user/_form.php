<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-7\">{input}</div>\n<div class=\"col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
        'options' => [
            'autocomplete' => 'off',
        ]
    ]); ?>

    <div class="inputs">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'confirmPassword')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'birthdate')->textInput() ?>

        <input type="hidden" id="birthdate" name="User[birthdate]" />

        <?= $form->field($model, 'file')->fileInput() ?>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <?= Html::submitButton('Register', ['class' => 'btn-register btn btn-primary pull-right'/*, 'disabled' => 'disabled'*/]) ?>
        </div>
    </div>

    <small class="help-block">* Mandatory Fields</small>

    <?php ActiveForm::end(); ?>
</div>
