<?php


namespace app\modules\freelance\controllers;
use Yii;
use app\modules\freelance\models\Project;
use app\modules\freelance\models\Upload;
use app\modules\freelance\models\Xprimg;
use app\modules\freelance\models\Xprotag;
use app\modules\freelance\models\Xprofiletag;
use app\modules\freelance\models\SearchProject;
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



class ProjectController extends \yii\web\Controller
{
	
	
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ],
            ],
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'except'=>['index','view-project'],
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
	
	///////////ADD
    public function actionAddProject()
    {
		$model = new Project();
		//$upload = new Upload();
		//$cross = new Xprimg();
		$xprotag = new Xprotag();
		$tags = Tags::find()->select(['tags.name'])->orderBy('tags.id')->indexBy('id')->column();
		
		
		if($model->load(Yii::$app->request->post())){
			/*if($upload->upFile = UploadedFile::getInstance($upload, 'upFile')){
				$upload->upload();
				$cross->imgpath=$upload->upFile->name;
			}*/
			
			$model->uid = Yii::$app->user->id;
			$model->save();
			
			$xprotagarr = Yii::$app->request->post()['Xprotag']['tid'];
			foreach($xprotagarr as $tid){
				$xprotag = new Xprotag();
				$xprotag->pid=$model->id;
				$xprotag->tid=$tid;
				$xprotag->save(false);
				
			}
			
			
			/*$cross->pid=$model->id;
			$cross->save();*/
			
			return $this->redirect(['view-project', 'id'=>$model->id]);
		}
		
        return $this->render('add-project',['model'=>$model,'tags'=>$tags,'xprotag'=>$xprotag,]);
    }
	
	////////UPDATE
	public function actionUpdateProject($id)
    {		
		$model = Project::findOne($id);
		
		if(Yii::$app->user->id!=$model->uid){
			throw new NotFoundHttpException('Такой страницы нет :(');
		}
		
		//$upload = new Upload();
		//$cross = Xprimg::find()->where(['pid'=>$id])->one();
		$xprotag = new Xprotag();
		$xprotagch = Xprotag::find()->joinWith('tag')->where(['xprotag.pid'=>$id])->all();
		$tags = Tags::find()->select(['name'])->orderBy('id')->indexBy('id')->column();
		if($model->load(Yii::$app->request->post())){
			/*if($upload->upFile = UploadedFile::getInstance($upload, 'upFile')){
			$upload->upload();}*/
			
			$model->uid = Yii::$app->user->id;
			$model->save();
			Xprotag::deleteAll(['pid'=>$id]);
			$xprotagarr = Yii::$app->request->post()['Xprotag']['tid'];
			foreach($xprotagarr as $tid){
				$xprotag = new Xprotag();
				$xprotag->pid=$model->id;
				$xprotag->tid=$tid;
				$xprotag->save(false);
				
			}
			
			/*$cross->pid=$model->id;
			$cross->imgpath=$upload->upFile->name;
			$cross->save();*/
			return $this->redirect(['view-project', 'id'=>$model->id]);
		}
		
		
		$model= Project::find()->where(['project.id'=>$id])->joinWith('tag')->one();
        return $this->render('update-project',['model'=>$model, 'tags'=>$tags,'xprotag'=>$xprotag,'xprotagch'=>$xprotagch]);
    }

	
	
	////////////////INDEX
    public function actionIndex()
    {
		$model = new Project();
		$searchpro = new SearchProject();
		$query = $model->find()->joinWith('tag')->orderBy(['timestamp'=> SORT_DESC]);
		
		$data = new ActiveDataProvider([
			'query'=>$query,
			'pagination'=>[
				'pageSize'=>20,
			]
		]);
		
		$tags = Tags::find()->select(['name'])->orderBy('id')->indexBy('id')->column();
		
		if(!Yii::$app->request->queryParams){
			$tarr = Xprofiletag::find()->select('tid')->where(['uid'=>Yii::$app->user->id])->asArray()->all();
			$tarr = ArrayHelper::getColumn($tarr, 'tid');
			//print_r($tarr);
			$query->andFilterWhere(['xprotag.tid'=>$tarr]);
			return $this->render('index',['model'=>$model, 'data'=>$data,'searchpro'=>$searchpro,'tags'=>$tags]);
		}
		
		$data = $searchpro->search(Yii::$app->request->queryParams);
		
		
		$qtag = Yii::$app->request->queryParams['tag'];
		//print_r($tarr);
		$query->filterWhere(['xprotag.tid'=>$qtag]);
		return $this->render('index',['model'=>$model, 'data'=>$data,'searchpro'=>$searchpro,'tags'=>$tags]);
		
		
    }

	
	
	
	////////////VIEW
    public function actionViewProject($id)
    {
		
		if($chosenid=Yii::$app->request->post()['chosen']){
			$chosebid = Bids::find()->where(['pid'=>$id, 'id'=>$chosenid])->one();
			$chosebid->chosen =1;
			$chosebid->save();
		}
		$status = (Bids::find()->where(['pid'=>$id,'chosen'=>1])->one())?1:0;
		
		$model = Project::find()->where(['project.id'=>$id])->one();
		
		$tags = Xprotag::find()->joinWith('tag')->where(['xprotag.pid'=>$model->id])->all();
		
		
		$query = (Bids::find()->where(['pid'=>$model->id,'chosen'=>1])->one())?Bids::find()->where(['pid'=>$model->id,'chosen'=>1]):Bids::find()->where(['pid'=>$model->id]);
		$data = new ActiveDataProvider(['query'=> $query]);
		
		if(Bids::find()->where(['uid'=>Yii::$app->user->id,'pid'=>$id])->one()){
			$bids = Bids::find()->where(['uid'=>Yii::$app->user->id,'pid'=>$id])->one();
			
			
			if($bids->load(Yii::$app->request->post())){
				if(Yii::$app->user->isGuest){
					return $this->redirect(['/site/login']);
				}
				
				$bids->uid = Yii::$app->user->id;
				$bids->pid = $model->id;
				$bids->save();
				return $this->render('view-project',['model'=>$model, 'bids'=>$bids, 'data'=>$data,'status'=>$status,'tags'=>$tags]);
			}
			return $this->render('view-project',['model'=>$model, 'bids'=>$bids, 'data'=>$data,'status'=>$status,'tags'=>$tags]);
		}
		
		$bids = new Bids();
		
		if($bids->load(Yii::$app->request->post())){
			if(Yii::$app->user->isGuest){
				return $this->redirect(['/site/login']);
			}
			$bids->uid = Yii::$app->user->id;
			$bids->pid = $model->id;
			$bids->save();
			return $this->render('view-project',['model'=>$model, 'bids'=>$bids, 'data'=>$data,'status'=>$status,'tags'=>$tags]);
		}
		
		return $this->render('view-project',['model'=>$model, 'bids'=>$bids, 'data'=>$data,'status'=>$status,'tags'=>$tags]);
		
    }
	
	
	////////////////COMPLETE
	
	public function actionComplete($id)
    {
		
        $project = $this->findModel($id);
		if($project->uid==Yii::$app->user->id){
			$project->completed = 1;
			$project->save();
			return $this->redirect(Yii::$app->request->referrer);
		}
		
		
        
    }
	
	
	/////////////////DELETE
	
	
	public function actionDelete($id)
    {
		
        $this->findModel($id)->delete();
		Xprotag::deleteAll(['pid'=>$id]);
		Bids::deleteAll(['pid'=>$id]);

        return $this->redirect(['index']);
    }
	
	
	
	///////DELETE BID
	
	public function actionDeleteBid($id)
    {
		if(Bids::findOne($id)===null||Bids::findOne($id)->uid!=Yii::$app->user->id){
			throw new NotFoundHttpException('The requested page does not exist.');
		}
		$pid = Bids::findOne($id)->pid;
		Bids::deleteAll(['id'=>$id]);
		
        return $this->redirect(['view-project', 'id'=>$pid]);
    }
	
	
	
	//////////FINDMODEL
	
	protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Этой страницы вообще не существует.');
        }
    }

}
