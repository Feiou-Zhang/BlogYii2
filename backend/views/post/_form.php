<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="/static/js/ckeditor/ckeditor.js"></script>
<!--<script src="//cdn.ckeditor.com/4.7.0/full/ckeditor.js"></script>-->
<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <script>
        var config = {
            extraPlugins: 'codesnippet',
            codeSnippet_theme: 'monokai_sublime',
            height: 356
        };

        CKEDITOR.replace( 'post-content', config);
    </script>
    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

   <?= $form->field($model, 'status')->dropDownList(\common\models\Poststatus::find()
       ->select(['name','id'])
       ->orderBy('position')
       ->indexBy('id')
       ->column(),['prompt'=>'Select the Status']) ?>


    <?= $form->field($model, 'author_id')->dropDownList(\common\models\Adminuser::find()
        ->select(['nickname','id'])
        ->indexBy('id')
        ->column(),['prompt'=>'Select the Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
