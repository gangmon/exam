<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

<!--    --><?//= $form->field($model, 'status')->textInput() ?>
<!--    调用文章状态类find（）方法附加all（）方法就可以把所有的对象数据通过对象的方式拿出来，-->


<!--    然后用arrayHelper::map($psObjs,'id','name');进行转换，转换为键值数组-->
    <?php
//       第一种方法
    //   $psObjs = \common\models\Poststatus::find()->all();
//    $allStatus = \yii\helpers\ArrayHelper::map($psObjs,'id','name');
       // 第二种方法：
//        $psArray = Yii::$app->db->createCommand('select id,name from poststatus')->queryAll();
//        $allStatus = ArrayHelper::map($psArray,'id','name');
       //第三种方法
    $allStatus = (new \yii\db\Query())
    ->select(['name','id'])
    ->from('poststatus')
    ->column();
    //->all();
//    echo "<pre>";
//    print_r($allStatus);
//    exit(0);
//    ?>
    <?= $form ->field($model,'status')->dropDownList($allStatus,['prompt'=>'请选择状态']);?>

<!--    --><?//= $form->field($model,'status')->dropDownList([1=>'草稿',2=>'已发布'],['prompt'=>'请选择状态']);?>

<!---->
<!--    --><?//= $form->field($model, 'create_time')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'update_time')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
