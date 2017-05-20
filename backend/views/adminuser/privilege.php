<?php
/**
 * Created by PhpStorm.
 * User: feiouzhang
 * Date: 5/19/17
 * Time: 10:04 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Adminuser;

/* @var $this yii\web\View */
/* @var $model common\models\Adminuser */

$model = Adminuser::findOne($id);

$this->title = 'Setup Privilege: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = 'Setup Privilege';
?>

<div class="adminuser-update">

    <h1><?= Html::encode($this->title) ?></h1>


    <div class="adminuser-privilege-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegesArray);?>

        <div class="form-group">
            <?= Html::submitButton('Setting') ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>



</div>