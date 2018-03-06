<?php
use yii\helpers\Html;
use Yii;
$this->title = '修改用户资料: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('key')): ?>
        <div class="alert alert-success">
            Thank you for contacting us.We will respond to you as soon as possible.
        </div>
        <p>
            Note that if you turn on the Yii debuger,you should be able
            to view the mail message on the mail panel of the debuger.
            <?php if (Yii::$app->mailer->userFileTransport): ?>
                Because the application is in development mode,the email is not sent but a
                file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath)?></code>
                please configure the <code>useFileTransport</code> propert of the <code>make</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>
    <?php else: ?>
        <p>
            if you have business inquires or other questions,please fill out following ...
            Thank you.
        </p>
    <?php endif; ?>





    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
