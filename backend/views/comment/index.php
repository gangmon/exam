<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Commentstatus;
use yii\grid\Column;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建评论', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],//把序列号去掉

           // 'id',
            [
                    'attribute'=>'id',
                    'contentOptions'=>['width'=>'30px'],//调整ID的宽度
],
            //'content:ntext',
            [//把内容字段截取前20个字符来展示的第一种方法
                    'attribute'=>'content',
                    'value'=>'beginning',
//                    'value'=>function($model){//用匿名函数把content字符串进行截取
//                        $tmpStr = strip_tags($model->content);//把内容里面的HTML标签去掉
//                        $tmpLen = mb_strlen($tmpStr);//计算长度
//                        return mb_substr($tmpStr,0,20,'utf-8').($tmpLen>20?'...':'');
//                    }//对返回的结果做处理如果超过20个字符则用...
],

            //'userid',
           [
                    'attribute'=>'user.username',
                    'label'=>'作者',
                    'value'=>'user.username',
            ],
            //'status',

            ['attribute'=>'status',
            'value'=>'status0.name',
            'filter'=>\common\models\Commentstatus::find()
                ->select(['name','id'])
                ->orderBy('position')
                ->indexBy('id')
                ->column(),
                'contentOptions'=>
                    function($model){
                        return ($model->status==1)?['class'=>'bg-danger']:[];
                    }
            ],
            //'create_time:datetime',
            [
                    'attribute'=>'create_time',
                     'format'=>['date','php:Y-m-d H:i:s'],
            ],
            // 'email:email',
            // 'url:url',
            // 'post_id',
            'post.title',


            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}{approve}',
                'buttons' => [
                        'approve'=>function($url,$model,$key)
                        {
                            $options=[
                                    'title' => Yii::t('yii','审核'),
                                    'aria-label'=>Yii::t('yii','审核'),
                                'data-confirm'=>Yii::t('yii','你确定通过这条评论吗？'),
                                'data-method' => 'post',
                                'data-pjax'=>'0',

                            ];
                            return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
                        },

                ],
            ],
        ],
    ]); ?>
</div>