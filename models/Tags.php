<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property integer $used
 * @property integer $catid
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }
	
	public function getCat(){
		return $this->hasOne(Category::className(),['id'=>'catid']);
	}
	

    /**public
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['used', 'catid'], 'integer'],
            [['name','catid'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'used' => Yii::t('app', 'Used'),
            'catid' => Yii::t('app', 'Catid'),
        ];
    }
}
