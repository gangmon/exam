<?php

//namespace
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['id' => 'changelogo-form'],['options' => ['enctype' => 'multipart/form-data'],]) ?>

<?= $form->field($model, 'file')->fileInput() ?>

<?= Html::submitButton('改变头像', ['class' => 'btn btn-primary', 'name' => 'changelogo-button']) ?>

<?php ActiveForm::end() ?>