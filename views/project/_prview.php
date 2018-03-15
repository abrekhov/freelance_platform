<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\modules\freelance\models\Xprotag;
use app\modules\freelance\models\UsefulFunc;
?>
<div class='postname'><?= Html::a(Html::encode($model->name),['project/view-project', 'id'=>$model->id])?></div>
<?= Html::tag('div',HtmlPurifier::process($model->price).' руб.',['class'=>'price']) ?>
<?//= Html::tag('div',UsefulFunc::prettyTime(strtotime($model->timestamp)),['class'=>'timestamp']) ?> 

<?= Html::tag('div',HtmlPurifier::process($model->description),['class'=>'description']) ?>

<?$tags = new ActiveDataProvider(['query'=>Xprotag::find()->joinWith('tag')->where(['pid'=>$model->id])])?>
<?/*=ListView::widget([
		'dataProvider'=>$tags, 
		'options'=>['class'=>'all_tags',],
		'itemView'=>'_tagview',
		'summary'=>'',
		'emptyText'=>'',
		'itemOptions'=>['class'=>'tags'],
	])*/?>

<?/*= Html::tag('div',User::findOne($model->uid)->username, ['class'=>'username'])*/?>   
