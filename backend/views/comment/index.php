<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

         //   'id',
           ['attribute'=>'id', 'contentOptions'=>['width'=>'30px'],],
           // 'content:ntext',
            [
                'attribute'=>'content',
                'value'=>'beginning',],
           // 'status',
            [
                'attribute'=>'user.username',
                'label'=>'Author',
                'value'=>'user.username',
            ],
            [
                'attribute'=>'status',
                'value'=>'status0.name',
                'filter'=>\common\models\Commentstatus::find()
                    ->select(['name','id'])
                    ->orderBy('position')
                    ->indexBy('id')
                    ->column(),
                'contentOptions'=>
                    function($model)
                    {
                        return ($model->status==1)?['class'=>'bg-danger']:[];
                    }
            ],

            'create_time:datetime',
            'post.title',
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {approve}',
                'buttons'=>
                    [
                        'approve'=>function($url,$model,$key)
                        {
                            $options=[
                                'title'=>Yii::t('yii', 'Approve'),
                                'aria-label'=>Yii::t('yii','Approve'),
                                'data-confirm'=>Yii::t('yii','Are you sure to approve this comment?'),
                                'data-method'=>'post',
                                'data-pjax'=>'0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
                        },
                    ],
            ],
           // 'userid',
            // 'email:email',
            // 'url:url',
            // 'post_id',
            // 'remind',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
