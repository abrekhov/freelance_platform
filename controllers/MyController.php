<?php

namespace app\modules\freelance\controllers;
use Yii;
use app\modules\freelance\models\Project;
use app\modules\freelance\models\Upload;
use app\modules\freelance\models\Xprimg;
use app\modules\freelance\models\Xprotag;
use app\modules\freelance\models\Xprofiletag;
use app\modules\freelance\models\Tags;
use app\modules\freelance\models\Category;
use app\modules\freelance\models\Bids;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

class MyController extends \yii\web\Controller
{
    public function actionIndex()
    {
		
        return $this->render('index');
    }
	
	public function actionBids()
    {
        $this->redirect(['/project','SearchProject[buid]'=>Yii::$app->user->id]);
    }

    public function actionProfile()
    {
        $uname=Yii::$app->user->identity->username;
        return $this->redirect(['/profile/'.$uname]);
    }

    public function actionProjects()
    {
		$this->redirect(['/project','SearchProject[uid]'=>Yii::$app->user->id]);
    }

}
