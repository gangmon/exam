<?php
namespace frontend\controllers;
use common\models\UploadForm;
use yii\web\UploadedFile;
use Yii;

class UploadController extends \yii\web\Controller{





//    public function actions()
//    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
//        ];
//    }




    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $model->file->saveAs('uploads/' . $model->file->baseName.'.'.$model->file->extension);
            }
        }

        return $this->renderPartial('upload', ['model' => $model]);
    }

}