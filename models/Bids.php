<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "bids".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $price
 * @property integer $deadline
 * @property string $comment
 * @property integer $uid
 * @property string $dateup
 */
class Bids extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bids';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'price', 'deadline', 'uid','chosen'], 'integer'],
            [['pid', 'price', 'deadline'], 'required'],
            [['dateup'], 'safe'],
            [['comment'], 'string', 'max' => 500],
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
            'price' => Yii::t('app', 'Стоимость'),
            'deadline' => Yii::t('app', 'Выполню через, дн.'),
            'comment' => Yii::t('app', 'Коментарий'),
            'uid' => Yii::t('app', 'Пользователь'),
            'dateup' => Yii::t('app', 'Дата добавления'),
            'chosen' => Yii::t('app', 'Выбранные'),
        ];
    }
}
