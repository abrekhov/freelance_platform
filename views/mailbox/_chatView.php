<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\models\User;
use app\modules\freelance\models\Mailbox;
use app\modules\freelance\models\UsefulFunc;
?>
<div class='media-<?=(Yii::$app->user->id==$model->aid)?'right':'left'?> text-<?=(Yii::$app->user->id==$model->aid)?'right':'left'?>'>
<div class='media-body' style='padding: 20px 3% 0px 3%'>
<h4 class='media-heading'>
<?= Html::a(Html::encode(User::findOne($model->aid)->username), ['/profile/'.User::findOne($model->aid)->username],['class'=>'userlink'])?>
</h4>
<p>
<?= Html::tag('div',$model->body) ?><br>
<?= UsefulFunc::prettyTime($model->created_at)?><br>
</p>
</div>
</div>
