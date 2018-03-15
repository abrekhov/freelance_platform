<?php

namespace app\modules\freelance\controllers;


use Yii;
use app\modules\freelance\models\Project;
use app\modules\freelance\models\Profile;
use app\modules\freelance\models\Tags;
use app\modules\freelance\models\Xprofiletag;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class ProfileController extends \yii\web\Controller
{
	
	public function behaviors()
	{
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
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
	
	
    public function actionIndex($username=0)
    {
		if(!$username){
			$profile=(Profile::find()->where(['uid'=>Yii::$app->user->id])->one())?Profile::find()->where(['uid'=>Yii::$app->user->id])->one():new Profile();
			
			$xprofiletag = new Xprofiletag();
			
			$tags = Tags::find()->select(['name'])->orderBy('id')->indexBy('id')->column();
			
			if($profile->load(Yii::$app->request->post())){
				$profile->uid=Yii::$app->user->id;
				$profile->save();
				Xprofiletag::deleteAll(['uid'=>Yii::$app->user->id]);
				$xprofiletagarr = Yii::$app->request->post()['Xprofiletag']['tid'];
				foreach($xprofiletagarr as $tid){
					$xprofiletag = new Xprofiletag();
					$xprofiletag->uid=$profile->uid;
					$xprofiletag->tid=$tid;
					$xprofiletag->save(false);
				}
				Yii::$app->session->setFlash('Saved');
			}
			
			$uinfo = User::findOne(Yii::$app->user->id);
			return $this->render('index',['profile'=>$profile,'uinfo'=>$uinfo,'tags'=>$tags,'xprofiletag'=>$xprofiletag]);
		}
		else{
			$profile = $this->findUserByName($username);
			$uinfo = User::findOne($profile->uid);
			$preftags = Xprofiletag::find()->joinWith('tag')->where(['xprofiletag.uid'=>$profile->uid])->all();
			return $this->render('index',['profile'=>$profile,'uinfo'=>$uinfo,'preftags'=>$preftags]);
		}
    }
	
	
	
	
	
	

    public function actionSetup()
    {
        return $this->render('setup');
    }
	
	protected function findUserByName($username)
    {
        if (($model = User::findOne(['username'=>$username])) !== null) {
			$profile = Profile::findOne(['uid'=>$model->id]);
            return $profile;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
