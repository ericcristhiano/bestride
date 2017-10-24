<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Ride */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ride-form">
    
    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-7\">{input}</div>\n<div class=\"col-sm-3\">{error}</div>",
            'labelOptions' => ['class' => 'col-sm-2 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'origin')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'destination')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'available_seats')->textInput() ?>
    
    <?= $form->field($model, 'price')->textInput() ?>
    
    <?= $form->field($model, 'date')->textInput() ?>
    
    <input type="hidden" id="date" name="Ride[date]" />

    <?= $form->field($model, 'more_information')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-7">
            <?= Html::submitButton('Register', ['class' => 'btn btn-primary pull-right']) ?>
        </div>
    </div>
    
    <small class="help-block">* Mandatory Fields</small>
    
    <?php ActiveForm::end(); ?>
</div>

