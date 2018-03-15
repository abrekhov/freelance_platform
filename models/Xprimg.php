<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "xprimg".
 *
 * @property integer $id
 * @property integer $pid
 * @property string $imgpath
 */
class Xprimg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xprimg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['imgpath'], 'string', 'max' => 100],
        ];
    }
	
	public function getPr(){
		return $this->hasOne(Project::className(), ['id'=>'pid']);
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pid' => Yii::t('app', 'Pid'),
            'imgpath' => Yii::t('app', 'Imgpath'),
        ];
    }
}
