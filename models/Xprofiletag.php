<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "xprofiletag".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $tid
 */
class Xprofiletag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xprofiletag';
    }
	
	public function getProfile(){
		return $this->hasMany(Profile::className(), ['uid'=>'uid']);
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
            [['uid', 'tid'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'uid' => Yii::t('app', 'Uid'),
            'tid' => Yii::t('app', 'Tid'),
        ];
    }
}
