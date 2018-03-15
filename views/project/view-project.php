<?php


use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\grid\RadioButtonColumn;
use app\models\User;
use yii\helpers\Html;
use yii\web\View;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
?>

<?=Html::a(Yii::t('app', 'Back'),['project/index'],['class'=>'btn btn-default'])?>
<h1 style='text-align:center;margin:25px;'>Проект <br><?=$model->name?> <br>от <?=Html::a(User::findOne($model->uid)->username,['/profile/'.User::findOne($model->uid)->username],['class'=>'userlink'])?></h1>

<div class='view'>

<div class='row text-center'>
<?=Html::tag('div','Описание',['class'=>'control-label col-xs-12'])?>
</div>
<hr>
<div class='row text-center'>
<?=Html::tag('div',$model->description,['class'=>'col-xs-12'])?>
</div>
<hr>
<div class='row text-center'>
<?=Html::tag('div',"Бюджет проекта",['class'=>'col-xs-3'])?>
<?=Html::tag('div',$model->price.'р.',['class'=>'col-xs-3'])?>
<?=Html::tag('div',"Добавлено",['class'=>'col-xs-3'])?>
<?=Html::tag('div',$model->timestamp,['class'=>'col-xs-3'])?>
</div>
<hr>

<div class='row text-center'>
<?=Html::tag('div',Html::tag('i','',['class'=>'glyphicon glyphicon-tags']).'  Теги',['class'=>'col-xs-12'])?>
</div>
<div class='row text-center'>
<div class='col-xs-12 float-center'>
<?foreach($tags as $tag){?>
<?=Html::tag('div',Html::a($tag->tag[0]->name,['project/index','SearchProject[tid][]'=>$tag->tag[0]->id]),['class'=>'tag'])?>
<?}?>
</div>
</div>

<div class='clearfix'></div>

<p style='text-align: center; margin:20px'>
<?if(Yii::$app->user->id==$model->uid&&!$model->completed){?>
<?=Html::a(Yii::t('app', 'Удалить проект'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])?>

<?=Html::a(Yii::t('app', 'Редактировать'), ['update-project', 'id' => $model->id], [
            'class' => 'btn btn-warning',
        ]) ?>

<? echo ($status&&!$model->completed)?Html::a('Проект выполнен исолнителем',['complete','id'=>$model->id], ['class'=>'btn btn-success']):'';
		
}
else if($model->completed){
	echo Html::tag('div', 'Проект выполнен',['class'=>'alert alert-success','style'=>'clear:both;text-align:center;width:50%;margin:auto;']);
}?>
</p>
</div>



<?if($model->uid!=Yii::$app->user->id&&!$status){?>
<h3>Добавить ставку</h3>

<div class='bids' >
<?$form = ActiveForm::begin();?>
<?=$form->field($bids, 'id')->hiddenInput(['style'=>'display:none'])->label(false)?>
<?=$form->field($bids, 'price')->textInput(['placeholder'=>'в рублях','style'=>'width:100px'])->hint('Например, 1000 рублей')?>
<?=$form->field($bids, 'comment')->textarea(['placeholder'=>'Комментарий...','rows'=>6])?>
<?=$form->field($bids, 'deadline')->textInput(['style'=>'width:50px'])->hint('Например, 6 дней')?>
<div class="form-group">
<?= Html::submitButton($bids->isNewRecord ? Yii::t('app', 'Сделать ставку') : Yii::t('app', 'Обновить ставку'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-sm']) ?>
<?= Html::a(Yii::t('app', 'Удалить ставку'),['delete-bid','id'=>$bids->id],['class'=>'btn btn-danger btn-sm'])?>
</div>
<?$form = ActiveForm::end();?>
</div>
<?}?>

<?$form = ActiveForm::begin();?>
<?Pjax::begin(['id'=>'unique','timeout'=>false,'enablePushState'=>false]);?>
<div class='all_bids' id='all_bids'>
<?
$visible = (Yii::$app->user->id==$model->uid&&!$status)? 1:0;
echo $visivble;
?>
<?=GridView::widget([
	'dataProvider'=>$data,
	'summary'=>'',
	'tableOptions'=>['class'=>'table table-bordered' ],
	'emptyText'=>'<p class="pcenter">Пока ставок нет.</p>',
	'columns'=>[
		['attribute'=>'price', 'header'=>Html::tag('i','',['class'=>'glyphicon glyphicon-ruble']),'headerOptions'=>['style'=>'width:10px;white-space:pre-line;text-align:center;'],'contentOptions'=>['style'=>'text-align:center']],
		['attribute'=>'deadline','header'=>Html::tag('i','',['class'=>'glyphicon glyphicon-hourglass']),'headerOptions'=>['style'=>'white-space:pre-line;text-align:center;'],'contentOptions'=>['style'=>'text-align:center']],
		['attribute'=>'comment','header'=>Html::tag('i','',['class'=>'glyphicon glyphicon-comment']),'headerOptions'=>['style'=>'white-space:pre-line;text-align:center;']],
		['attribute'=>'uid','format'=>'raw','header'=>Html::tag('i','',['class'=>'glyphicon glyphicon-user']),'headerOptions'=>['style'=>'white-space:pre-line;text-align:center;'],'contentOptions'=>['style'=>'text-align:center'],'value'=>function($bid){return Html::a(User::findOne($bid->uid)->username,['/mailbox/chat/'.User::findOne($bid->uid)->username],['class'=>'userlink']);}],
		['class' => RadioButtonColumn::className(),
		 'visible'=> $visible,
		 'name'=>'chosen',
         'radioOptions' => function ($bid) {
            return [
                 'value' => $bid->id,
             ];
         }
		],
		['attribute' => 'chosen',
		'visible'=>$bid->chosen,
         'value' => function ($bid) {
            return ($bid->chosen)?'Выбран':'Не выбран';
		 
         }
		],
	],
	//'tableOptions'=>['class'=>'table table-bordered','style'=>'max-width:100%;'],
	
	])?>
</div>


<?if($visible){
$config['class']='btn btn-success btn';
if(!$data->count){
	$config['disabled']='disabled';
}
?>

<p style='text-align: center; margin:20px'>
<?= Html::submitButton(Yii::t('app', 'Выбрать исполнителя'), $config) ?>
</p>
<?}?>
<?Pjax::end();?>
<?$form = ActiveForm::end();?>
<?

$script=<<< JS
function gridUp(){
$.pjax.reload({container:'#unique'});}
var myVar = setInterval(function(){ gridUp() }, 60000);
JS;
$this->registerJS($script);
?>
