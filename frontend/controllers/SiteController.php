<?php
namespace frontend\controllers;

//use GuzzleHttp\Psr7\UploadedFile;
use common\models\UploadForm;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
//use yii\web\UploadedFile;
//use GuzzleHttp\Psr7\UploadedFile;
//use common\models\UploadForm;
use yii\web\UploadedFile;
//use Yii;
//use common\models\User;

//use common\models\UploadForm;
//use yii\web\UploadedFile;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionChangelogo(){
      $model = new UploadForm();
        //print_r(Yii::$app->user->identity->logo);die;
      if ($model->load(Yii::$app->request->post())){
          $model->file = UploadedFile::getInstance($model, 'file');


              //$model->file->saveAs('uploads/' . $model->file->baseName.'.'.$model->file->extension);
          $model->file->saveAs('all/image/' . Yii::$app->user->identity->email.'.'.$model->file->extension);
          $userID = Yii::$app->user->identity->id;
          $userLogo = Yii::$app->user->identity->email.'.'.$model->file->extension;
          print_r(Yii::$app->user->identity->id);
          //Yii::$app->db->createCommand()->update('user', ['logo' => Yii::$app->user->identity->email.'.'.$model->file->extension], ['id=$userID'])->execute();
          Yii::$app->db->createCommand("UPDATE user SET logo='$userLogo' WHERE id=$userID")->execute();

          Yii::$app->user->identity->logo = Yii::$app->user->identity->email.'.'.$model->file->extension;
          //print_r(Yii::$app->user->identity->logo);//die;
          //Yii::$app->user = Yii::$app->user->save();
          //Yii::$app->user->identity->logo = $model->file.'.'.$model->file->extension;
          //$this->user->save();
          //Yii::$app->user->identity->__set('logo',Yii::$app->user->identity->email.'.'.$model->file->extension);
          //print_r(Yii::$app->user->identity->logo);die;
          return $this->goHome();

      }
      return $this->render('upload', ['model' => $model]);

    }
    public function actionSignup(){
        //$model1 = new User();
        $model = new SignupForm();
        //print_r($model->logo);
        if ($model->load(Yii::$app->request->post())) {
            //获取文件实例
            //$model1->logo = $model->email.'.'.$model->file->extension;
            $model->file = UploadedFile::getInstance($model,'file');
            //var_dump($model->email);
           // var_dump($model->email.'.'.$model->file->extension);


            $model->logo = $model->email.'.'.$model->file->extension;
            //print_r($model->logo);
           // var_dump($model->logo);
            //var_dump(Yii::$app->user);
           // die;
            $model->file->saveAs('all/image/'.$model->email.'.'.$model->file->extension);
            //$model->file->saveAs('uploads/' . $model->file->baseName.'.'.$model->file->extension);
            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }




        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
