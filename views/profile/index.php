<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\modules\freelance\models\Xprofiletag;
?>
<?echo ($uinfo['id']==Yii::$app->user->id)?'<h1 style="text-align:center;margin:25px;">Ваш профиль</h1>':'<h1 style="text-align:center;margin:25px;">Профиль пользователя '.$uinfo['username'].'</h1>';?>
<div class='profile'>
<?if(!$preftags&&$uinfo['id']==Yii::$app->user->id){?>
<?if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
<?-Html::tag('div', 'Вы успешно зарегистрировались! Пожалуйста заполните информацию о себе, чтобы Вам было легче ориентироваться среди проектов',['class'=>'alert alert-success'])?>
<?endif;?>
<?Pjax::begin();?>
<div class='row text-center'>
<?=Html::tag('div','Логин',['class'=>'control-label col-xs-6'])?>
<?=Html::tag('div',$uinfo['username'],['class'=>'col-xs-6'])?>
</div>
<hr>
<?$form = ActiveForm::begin(['options'=>['data-pjax'=>true]]);?>
<?=$form->field($profile, 'name')->textInput(['placeholder'=>'Имя'])->label('Имя')?>
<?=$form->field($profile, 'last_name')->textInput(['placeholder'=>'Фамилия'])?>
<?=$form->field($profile, 'skype')->textInput()?>
<?=$form->field($profile, 'about')->textarea(['rows'=>5])?>
<?= $form->field($xprofiletag, 'tid')->checkboxList($tags,[
		'item'=>function ($index, $label, $name, $checked, $value){
			$id=Yii::$app->user->id;
			$checked= Xprofiletag::find()->where(['uid'=>$id,'tid'=>$value])->exists();
			
			$chbox = Html::checkbox($name, $checked, [
			   'value' => $value,
			   'label' => $label,
			   //'class' => 'any class',
			]);
			switch($value){
				case 22:
					$chbox = '<br><label class="control-label">Дизайн/Иллюстрации</label><br>'.$chbox;
					break;
				case 42:
					$chbox = '<br><label class="control-label">Услуги</label><br>'.$chbox;
					break;
				case 57:
					$chbox = '<br><label class="control-label">Продвижение</label><br>'.$chbox;
					break;
				
			}
			return $chbox;
		},
		'separator'=>'<br>',
	],
	['style'=>'width:300px;float:left;margin-right:5px;'])->label('Программирование')?>
<?if(Yii::$app->session->hasFlash('Saved')){?>
<div class="alert alert-success">
Изменения сохранены
</div>
<?}?>
<?=Html::submitButton('Изменить',['class'=>'btn btn-success'])?>
<?$form = ActiveForm::end();?>
<?Pjax::end();?>
<?}




else{?>
<div class='row text-center'>
<?=Html::tag('div','Логин',['class'=>'control-label col-xs-6'])?>
<?=Html::tag('div',$uinfo['username'],['class'=>'col-xs-6'])?>
</div>
<hr>
<div class='row text-center'>
<?=Html::tag('div','Имя',['class'=>'control-label col-xs-6'])?>
<?=Html::tag('div',$profile->name,['class'=>'col-xs-6'])?>
</div>
<hr>
<div class='row text-center'>
<?=Html::tag('div','Фамилия',['class'=>'col-xs-6'])?>
<?=Html::tag('div',$profile->last_name,['class'=>'col-xs-6'])?>
</div>
<hr>
<div class='row text-center'>
<?=Html::tag('div','Skype',['class'=>'col-xs-6'])?>
<?=Html::tag('div',$profile->skype,['class'=>'col-xs-6 '])?>
</div>
<hr>
<div class='row text-center'>
<?=Html::tag('div','О себе',['class'=>'col-xs-12'])?>
</div>
<div class='row text-center'>
<?=Html::tag('div',$profile->about,['class'=>'col-xs-12 well'])?>
</div>

<div class='row text-center'>
<?=Html::tag('div',Html::tag('i','',['class'=>'glyphicon glyphicon-tags']).'  Сферы в тегах',['class'=>'col-xs-12'])?>
</div>

<div class='row text-center'>
<div class='col-xs-12 float-center'>
<?foreach($preftags as $tag){?>
<?=Html::tag('div',Html::a($tag->tag[0]->name,['project/index','SearchProject[tid][]'=>$tag->tag[0]->id]),['class'=>'tag'])?>
<?}?>
</div>
</div>
<div class='clearfix'></div>
<p style='text-align: center; margin:20px'>
<?=($uinfo['id']==Yii::$app->user->id)?Html::a('Редактировать профиль',['/profile'],['class'=>'btn btn-success']):Html::a('Написать пользователю',['/mailbox/chat/'.$uinfo[username]],['class'=>'btn btn-success'])?>
</p>
<?}?>
</div>
</div>
