<?php

use yii\helpers\Html;
use app\models\User;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
?>
<h1>Переписка с <?=Html::a(Yii::$app->request->get('username'), ['/profile/'.Yii::$app->request->get('username')],['class'=>'userlink'])?></h1>
<?Pjax::begin(['id'=>'chat','timeout'=>false,'scrollTo'=>true]);?>

<?Pjax::begin([
	'id'=>'chat-w',
	'enablePushState'=>false,
	'timeout'=>false,
]);?>
<?=ListView::widget([
	'dataProvider'=>$chat,
	'itemView'=>'_chatView',
	'summary'=>'',
	'emptyText'=>'<p style="margin:auto;text-align:center;">У вас пока нет сообщений.</p>',
	'options'=>['style'=>'height:200px;overflow:auto;'],
	'itemOptions'=>[
		'class'=>'media chmess',
		'style'=>'',
	],
])?>

<?Pjax::end();?>



<?$form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
<?=$form->field($model,'body')->textarea(['rows'=>3,'placeholder'=>'Сообщение...'])->label('')?>
<?=Html::submitButton('Отправить '.Html::tag('i','',['class'=>'glyphicon glyphicon-send']),['class'=>'btn btn-primary pull-right','id'=>'send'])?>
<?=Html::a('Назад',['/mailbox'],['class'=>'btn btn-primary pull-left'])?>
<?$form = ActiveForm::end();?>
<?Pjax::end();?>


<?$script=<<< JS

$(document).ready(function(){
	upScroll();
	$('#send').click(function(){
		$(document).on('pjax:complete',function(){
			upScroll();
		});
	});
});

var myVar = setInterval(function(){ chatUp() }, 15000);
var currh;

function upScroll(){
    $('#w0').scrollTop($('#w0')[0].scrollHeight);
}



function chatUp(){
$.pjax.defaults.timeout = false;
currh = $('#w0').scrollTop();
$.pjax.reload({container:'#chat-w'});

}

$(document).on('pjax:complete',function(){
	$('#w0').scrollTop(currh);
});



JS;
$this->registerJS($script);
?>