<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>//这句被注释的至关重要

    <p>
        <?= Html::a('创建文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['attribute'=>'id',
              'contentOptions'=>['width'=>'30px'],],
            //'id',
            'title',
            //'author_id',
            [//'attribute'=>'author_id',
            'attribute'=>'authorName',
                'label' => '作者',
            'value'=>'author.nickname'],
            //'content:ntext',
            'tags:ntext',
            //'status',
            [   'attribute'=>'status',
                'value'=>'status0.name',
                'filter'=>\common\models\Poststatus::find()
                ->select(['name','id'])
                ->orderBy('position')
                ->indexBy('id')
                ->column(),
            ],
             //'create_time:datetime',
            ['attribute'=>'create_time',
                'format'=>['date','php:Y-m-d H:i:s']],
            ['attribute'=>'update_time',
                'format'=>['date','php:Y-m-d H:i:s']],
             //'update_time:datetime',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
