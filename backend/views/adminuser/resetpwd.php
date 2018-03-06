<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$this->title = '重置密码';
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-resetpwd">

    <h1><?= Html::encode($this->title) ?></h1>

<!--    --><?//= $this->render('_form', [
//        'model' => $model,
//    ]) ?>





    <div class="adminuser-form">

        <?php $form = ActiveForm::begin(); ?>
<!---->
<!--        --><?//= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
<!---->
<!--        --><?//= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength'=>true]) ?>

<!---->
<!--        --><?//= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
<!---->
<!--        --><?//= $form->field($model, 'profile')->textarea(['rows' => 6]) ?>

<!--        --><?//= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?>
<!---->
<!--        --><?//= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
<!---->
<!--        --><?//= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
<!--            --><?//= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <?= Html::submitButton('重置', ['class' =>'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>








</div>
