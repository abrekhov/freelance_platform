<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
?>
<div class='lead' style='text-align:center'><?='Проекты'?></div>

<div class='project-index'>
<p style='text-align:center'>
<?=Html::a(Yii::t('app', 'Добавить проект'),[($my)?'project/add-project':'add-project'], ['class'=>'btn btn-success btn-lg'/*btn-add-pr orange'*/] )?>
</p>
<?=ListView::widget(['dataProvider'=>$data, 'itemOptions'=>['class'=>'post'], 'itemView'=>'_prview','emptyText'=>'<p style="text-align:center; margin:auto;">Таких проектов нет.</p>','summary'=>'', 'layout' => "{summary}\n{items}\n<div align='center'>{pager}</div>"])?>

<?//=$this->registerCssFile("@web/css/extra.css",['depends'=>[\yii\bootstrap\BootstrapAsset::className()]])?>
</div>
<div class="project-search" style='text-align:center'>
<?=Html::tag('h3', 'Поиск')?>
<?php $form = ActiveForm::begin([
	'action' => ['index'],
	'method' => 'get',
	
]); ?>
<div class='form-flex' style='display: flex;'>
<?= $form->field($searchpro, 'name')->label('Ключевые слова')?>

<?= $form->field($searchpro, 'priceover')->textInput(['class'=>'form-control priceover','placeholder'=>'в руб.','style'=>'max-width:100px;margin:auto;'])->label('От')?>
<?= $form->field($searchpro, 'priceunder')->textInput(['class'=>'form-control priceunder','placeholder'=>'в руб.','style'=>'max-width:100px;margin:auto;'])->label('До')?>
</div>
<?= $form->field($searchpro, 'tid[]')->listBox($tags,['multiple'=>true])->label('Теги')?>

<div class="form-group" style='margin:auto'>
	<?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-danger']) ?>
	<?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
	<?= Html::a('Проекты в моей сфере',['index'],['class'=>'btn btn-success'])?>
</div>

<?php ActiveForm::end(); ?>

</div>
<style>
.field-searchproject-name {
	flex-grow: 10;
}

.field-searchproject-priceover {
	flex-grow: 1;
}
.form-group a.btn-success {
    display: block;
    max-width: 176px;
    margin: 0 auto 0 auto;
	float: left;
	
}
.btn-danger {
    background-color: #FF9900;
    border-color: #FF9900;
}
.form-group .btn-danger, .form-group .btn-default {
	float: right;
}
.btn {
	margin: 0 0 0 10px;
}
.price,.timestamp, .postname {
    margin: 0 15px 0 0;
}

.pagination > .active > a {
	background-color: #FF9900;
    border-color: #FF9900;
}
.pagination > .active > a:hover {
	background-color: #FF9900;
    border-color: #FF9900;
}

.pagination > li > a {
	color: #404040;
}

</style>