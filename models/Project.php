<?php

namespace app\modules\freelance\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $price
 * @property string $upurl
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 400],
            [['name','description','price'], 'required'],
        ];
    }
	
	public function getImg(){
		return $this->hasMany(Xprimg::className(), ['pid'=>'id']);
	}
	
	
	public function getBid(){
		return $this->hasMany(Bids::className(), ['pid'=>'id']);
	}
	
	public function getTag(){
		return $this->hasMany(Xprotag::className(), ['pid'=>'id']);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'price' => Yii::t('app', 'Price'),
            'timestamp' => Yii::t('app', 'Add timestamp'),
        ];
    }
	
	public function search($params=''){
		$query = Project::find()->orderBy(['timestamp'=> SORT_DESC]);
		
		$data = new ActiveDataProvider([
			'query'=>$query,
			
		]);
		
		$this->load($params);
		
		if(!$this->validate()){
			return $data;
		}
		else{
			return $data;
		}
	}
	
}
