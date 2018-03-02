<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_history".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property int $target_id
 * @property int $created_at
 * @property int $updated_at
 * 
 * @property User $user 
 */
class UserHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_history';
    }
    
    /**
     * @inheritdoc
     */
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
            [['user_id', 'type', 'target_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'target_id', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'target_id' => 'Target ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
