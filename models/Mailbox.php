<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "mailbox".
 *
 * @property integer $id
 * @property string $body
 * @property integer $aid
 * @property integer $rid
 * @property integer $read
 * @property string $timestamp
 */
class Mailbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailbox';
    }
	
	public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['body'], 'string'],
            [['body'], 'required'],
            [['aid', 'rid', 'read'], 'integer'],
            [['timestamp','created_at','updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'body' => Yii::t('app', 'Body'),
            'aid' => Yii::t('app', 'Aid'),
            'rid' => Yii::t('app', 'Rid'),
            'read' => Yii::t('app', 'Read'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }
}
