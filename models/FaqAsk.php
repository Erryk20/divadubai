<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faq_ask".
 *
 * @property int $id
 * @property string $email
 * @property string $question
 * @property string $view 
 */
class FaqAsk extends \yii\db\ActiveRecord
{
    
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq_ask';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'question', 'reCaptcha'], 'required', 'except'=>['admin']],
            [['question', 'view'], 'string'],
            [['email'], 'string', 'max' => 50],
            ['email', 'email'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'question' => 'Question',
            'view' => 'View', 
        ];
    }
}
