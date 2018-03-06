<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */
/* @var $form yii\widgets\ActiveForm */


/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */
$model = \common\models\Adminuser::findOne($id);

$this->title = '权限设置:' . $model->username;

$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '权限设置';
?>

<div class="adminuser-update">

<div class="adminuser-privilege-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegesArray); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>