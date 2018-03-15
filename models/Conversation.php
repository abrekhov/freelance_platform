<?php

namespace app\modules\freelance\models;

use Yii;

/**
 * This is the model class for table "conversation".
 *
 * @property integer $id
 * @property integer $uidone
 * @property integer $uidtwo
 * @property string $timestamp
 */
class Conversation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'conversation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uidone', 'uidtwo'], 'integer'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uidone' => 'Uidone',
            'uidtwo' => 'Uidtwo',
            'timestamp' => 'Timestamp',
        ];
    }
}
