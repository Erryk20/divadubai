<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "awards".
 *
 * @property int $id
 * @property string $title
 * @property string $img
 * @property string $url
 */
class Awards extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'awards';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            'sortable' => [
                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['title'], 'string', 'max' => 100],
            [['img'], 'string', 'max' => 55],
            [['url'], 'string', 'max' => 50],
            ['file', 'image', 'extensions' => 'jpg, gif, png'],
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
            'img' => 'Image',
            'url' => 'Url',
        ];
    }
}
