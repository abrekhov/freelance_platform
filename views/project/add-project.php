<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
?>
<h1>Добавление проекта</h1>

<div class='add-project'>

<?$form=ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true])?>
<?= $form->field($model, 'description')->textarea(['rows'=>6])?>
<?= $form->field($model, 'price')->textInput(['placeholder'=>'в рублях','maxlength'=>true,'style'=>'width:100px'])?>
<?= $form->field($xprotag, 'tid')->checkboxList($tags,[
		'item'=>function ($index, $label, $name, $checked, $value){
			$chbox = Html::checkbox($name, $checked, [
			   'value' => $value,
			   'label' => $label,
			   'class' => 'any class',
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
		'separator'=>'<br>'
	],
	['style'=>'width:300px;float:left;margin-right:5px;'])->label('Программирование')?>
<div class="form-group" style='display:block'>
<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?$form=ActiveForm::end();?>
</div>
<?//print_r($tags)?>
