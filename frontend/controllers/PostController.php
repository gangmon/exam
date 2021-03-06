<?php

namespace frontend\controllers;

use common\models\Tag;
use common\models\User;
use Yii;
use common\models\Post;
use common\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Comment;

//use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
     */

    public $added = 0;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $tags=Tag::findTagWeights();
        $recentComments = Comment::findRecentComments();
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'recentComments'=>$recentComments,
            'tags'=>$tags,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixedpo
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function  actionDetail($id){
        //第一步，数据准备
        $model  = $this->findModel($id);

        $tags = Tag::findTagWeights();
        $recentComments = Comment::findRecentComments();


        $userMe = User::findOne(Yii::$app->user->id);
        //print_r(Yii::$app->user->id);
        $commentModel = new Comment();
        //print_r($userMe);
        $commentModel->email = $userMe->email;
        $commentModel->userid = $userMe->id;

        if ($commentModel->load(Yii::$app->request->post())){
            $commentModel->status = 1; //新评论默认状态为 pending
            $commentModel->post_id = $id;
            if($commentModel->save())
            {
                $this->added=1;
            }

        }
        return $this->render('detail',[
            'model'=>$model,
            'tags'=> $tags,
            'recentComments'=>$recentComments,
            'commentModel'=>$commentModel,
            'added'=>$this->added,
        ]);



    }
}
