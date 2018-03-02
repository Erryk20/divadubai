<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diva".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $type
 * @property string $block_1 
 * @property string $block_2 
 * @property string $block_3 
 * @property string $block_4 
 * @property string $block_5 
 * @property string $block_6 
 *
 * @property DivaMedia[] $divaMedia
 */
class Diva extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diva';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['block_1', 'block_2', 'block_3', 'block_4', 'block_5', 'block_6'], 'string'], 
            [['title', 'url', 'type'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'url' => 'Url',
            'type' => 'Type',
            'block_1' => 'Block 1', 
            'block_2' => 'Block 2', 
            'block_3' => 'Block 3', 
            'block_4' => 'Block 4', 
            'block_5' => 'Block 5', 
            'block_6' => 'Block 6', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivaMedia()
    {
        return $this->hasMany(DivaMedia::className(), ['diva_id' => 'id']);
    }
    
    public function beforeValidate() {
       if(parent::beforeValidate()){
            if ($this->url == ''){
                $this->url = \app\components\TranslitFilter::translitUrl($this->title);
            }
            return true;
        }else
            return false;
    }
}
