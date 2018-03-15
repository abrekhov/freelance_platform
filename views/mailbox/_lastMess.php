<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\User;
use app\modules\freelance\models\Mailbox;
use app\modules\freelance\models\UsefulFunc;

$chatid=(Yii::$app->user->id!=$model->aid)?$model->aid:$model->rid;

$num = (Mailbox::find()->where(['aid'=>$chatid, 'rid'=>Yii::$app->user->id,'read'=>0])->count())?Html::tag('span',$numofmess,['class'=>'badge','id'=>'num']):'';
?>
<div class="row">
<div class='col-xs-12 text-center'>

<h2>
<?= Html::a(Html::encode(User::findOne($chatid)->username).'<span id="unread">'.$num.'</span>',['/mailbox/chat/'.User::findOne($chatid)->username],['class'=>'userlink'])?>
</h2>

<?= Html::tag('div',$model->body,['class'=>($model->read==0)?'well':''])  ?><br>

<?= Html::tag('div',UsefulFunc::prettyTime($model->created_at),['class'=>'timestamp']) ?><br>
</div>
</div>
<hr>