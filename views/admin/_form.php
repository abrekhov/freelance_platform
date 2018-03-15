<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\modules\freelance\models\Tags */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tags-form">
<?Pjax::begin();?>
    <?php $form = ActiveForm::begin(['options'=>['data-pjax'=>true]]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'used')->textInput() ?>

    <?= $form->field($model, 'catid')->dropDownList($catitems) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php $form = ActiveForm::end(); ?>
<?Pjax::end();?>
</div>


