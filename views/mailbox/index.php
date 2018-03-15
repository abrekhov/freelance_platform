<?php

use yii\helpers\Html;
use app\models\User;
use yii\widgets\ListView;
/* @var $this yii\web\View */

?>
<h1>Сообщения</h1>
<div class='mailbox-index'>
<p>
<?=ListView::widget([
	'dataProvider'=>$list, 
	'itemView'=>'_lastMess',
	'emptyText'=>'<p style="text-align:center;">Пока у вас нет сообщений</p>',
	'summary'=>'',
])?>
</p>
</div>