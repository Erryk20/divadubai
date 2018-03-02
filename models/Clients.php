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
class Clients extends \yii\db\ActiveRecord
{
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
            [['url'], 'required'],
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
            'img' => 'Image',
            'url' => 'Url',
        ];
    }
}
