<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "xprotag".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $tid
 */
class Xprotag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xprotag';
    }
	
	public function getPro(){
		return $this->hasMany(Project::className(), ['id'=>'pid']);
	}
	
	public function getTag(){
		return $this->hasMany(Tags::className(), ['id'=>'tid']);
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'tid'], 'integer'],
            [['tid'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', 'Pid'),
            'tid' => Yii::t('app', 'Tid'),
        ];
    }
}
