<?php

namespace app\modules\freelance\controllers;

use Yii;
use app\modules\freelance\models\Mailbox;
use app\modules\freelance\models\Conversation;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Session;


class MailboxController extends \yii\web\Controller
{
	
	public function behaviors()
    {
        return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'except'=>['index','chat'],
				'rules' => [
					// allow authenticated users
					[
						'allow' => true,
						'roles' => ['@'],
					],
					// everything else is denied
				],
			],
        ];
    }

    public function actionIndex()
    {
		$subquery = Mailbox::find()->select('MAX(id)')->where(['or',['aid'=>Yii::$app->user->id],['rid'=>Yii::$app->user->id]])->groupBy('convid');
		
		$query = Mailbox::find()->where(['in', 'id', $subquery])->orderBy('timestamp DESC');
		$list = new ActiveDataProvider([
			'query'=>$query,
		]);
        return $this->render('index',['list'=>$list]);
    }
	
	
	public function actionChat($username)
    {
		$id = User::findByUsername($username)->id;
		if(!$id){
			throw new NotFoundHttpException('Такого диалога не может существовать');
		}
		
		if(Yii::$app->user->id==$id){
			return $this->redirect(['/mailbox'],301);
		}
		
		Mailbox::updateAll(['read'=>1], ['aid'=>$id,'rid'=>Yii::$app->user->id,'read'=>0]);
		
		$model = new Mailbox();
		
		$query = Mailbox::find()->where(['aid'=>[Yii::$app->user->id,$id],'rid'=>[Yii::$app->user->id,$id]])->orderBy('timestamp ASC');
		
		$chat = new ActiveDataProvider([
			'query'=>$query,
			'pagination'=>['pageSize'=>0], 
			
		]);
		
		if($model->load(Yii::$app->request->post())){
			$model->aid=Yii::$app->user->id;
			$model->rid=$id;
			$model->read=0;
			if($convid = Conversation::find()->where(['uidone'=>[Yii::$app->user->id, $id],'uidtwo'=>[Yii::$app->user->id, $id]])->one()->id){
				$model->convid = $convid;
			}
			else{
				$newconv=new Conversation();
				$newconv->uidone = Yii::$app->user->id;
				$newconv->uidtwo = $id;
				$newconv->save();
				$model->convid = $newconv->id;
			}
			if($model->save()):
				Yii::$app->session->setFlash('messageSended');
			endif;
			
			if(Yii::$app->request->isPjax):
			$model = new Mailbox();
			return $this->render('chat',['chat'=>$chat,'model'=>$model]);
			endif;
		}
		
        return $this->render('chat', ['model'=>$model,'chat'=>$chat]);
    }

}
