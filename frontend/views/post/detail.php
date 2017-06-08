<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use frontend\components\TagsCloudWidget;
use frontend\components\RctReplyWidget;

use yii\helpers\HtmlPurifier;
use common\models\Comment;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<link href="/static/css/monokai_sublime.css" rel="stylesheet">
<script src="/static/js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<div class="container">

	<div class="row">
	
		<div class="col-md-9">
		
			<ol class="breadcrumb">
			<li><a href="<?= Yii::$app->homeUrl;?>">Home</a></li>
			<li><a href="<?= Url::to(['post/index']);?>">Blog Lists</a></li>
			<li class="active"><?= $model->title?></li>
			</ol>
			
			<div class="post">
				<div class="title">
					<h2 style = "color: #aa5cc7"><?= Html::encode($model->title);?></h2>
						<div class="author">
						<span class="glyphicon glyphicon-time" aria-hidden="true">&nbsp;</span><em><?= date('Y-m-d H:i:s',$model->create_time)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?></em>
						<span class="glyphicon glyphicon-user" aria-hidden="true">&nbsp;</span><em><?= Html::encode($model->author->nickname);?></em>
						</div>				
				</div>
		
			
			<br>
			
			<div class="content">
			<?= HTMLPurifier::process($model->content)?>
			</div>
			
			<br>
			
			<div class="nav">
				<span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
				<?= implode(', ',$model->tagLinks);?>
				<br>
				<?= Html::a("Comment({$model->commentCount})",$model->url.'#comments');?>
				Last Modified&nbsp;&nbsp;<?= date('Y-m-d H:i:s',$model->update_time);?>
			</div>
		</div>
		
		<div id="comments">
		
			<?php if($added) {?>
			<br>
			<div class="alert alert-warning alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  
			  <h4>Thanks for your comment!</h4>
			  
			  <p><?= nl2br($commentModel->content);?></p>
			  	<span class="glyphicon glyphicon-time" aria-hidden="true"></span><em><?= date('Y-m-d H:i:s',$model->create_time)."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?></em>
				<span class="glyphicon glyphicon-user" aria-hidden="true"></span><em><?= Html::encode($model->author->nickname);?></em>
			</div>			
			<?php }?>
			
			<?php if($model->commentCount>=1) :?>
			
			<h5><?= $model->commentCount.' comment';?></h5>


			<?= $this->render('_comment',array(
					'post'=>$model,
					'comments'=>$model->activeComments,
			));?>
			<?php endif;?>
			
			<h5>Submit Your Comment</h5>
			<?php 
			$commentModel =new Comment();
			echo $this->render('_guestform',array(
					'id'=>$model->id,
					'commentModel'=>$commentModel, 
			));?>
			
			</div>
					
		</div>

		
		<div class="col-md-3">
			<div class="searchbox">
				<ul class="list-group">
				  <li class="list-group-item">
				  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Search Post
				  </li>
				  <li class="list-group-item">				  
					  <form class="form-inline" action="index.php?r=post/index" id="w0" method="get">
						  <div class="form-group">
						    <input type="text" class="form-control" name="PostSearch[title]" id="w0input" placeholder="By Title">
						  </div>
						  <button type="submit" class="btn btn-default">Search</button>
					</form>
				  
				  </li>
				</ul>			
			</div>
			
			<div class="tagcloudbox">
				<ul class="list-group">
				  <li class="list-group-item">
				  <span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Tag
				  </li>
				  <li class="list-group-item">
				  <?= TagsCloudWidget::widget(['tags'=>$tags])?>
				   </li>
				</ul>			
			</div>
			
			
			<div class="commentbox">
				<ul class="list-group">
				  <li class="list-group-item">
				  <span class="glyphicon glyphicon-comment" aria-hidden="true"></span> New Response
				  </li>
				  <li class="list-group-item">
				  <?= RctReplyWidget::widget(['recentComments'=>$recentComments])?>
				  </li>
				</ul>			
			</div>
			
		
		</div>
		
		
	</div>

</div>
