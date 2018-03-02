<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "share".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property string $published
 */
class Share extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'share';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url', 'img'], 'required'],
            [['published'], 'string'],
            [['name', 'url'], 'string', 'max' => 255],
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
            'img' => Yii::t('app', 'Image'),
            'url' => Yii::t('app', 'Url'),
            'published' => Yii::t('app', 'Published'),
        ];
    }
    
    
      /**
     * Вертає список сторінок для меню
     * @return type
     */
    public static function getList(){
        return  self::find()
            ->where(['published'=>'1'])
            ->asArray()
            ->all();
    }
    
    public static function getAllShare(){
        $query = "
            SELECT url, CONCAT('/images/share/',img) AS 'img', name
            FROM share
            WHERE published = :published
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':published' => "1"
        ])->queryAll();
    }
}
