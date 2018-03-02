<?php

namespace app\models;


use Yii;

/**
 * This is the model class for table "contacts".
 *
 * @property integer $id
 * @property string $email
 * @property string $phone
 * @property string $addres
 * @property string $latitude
 * @property string $longitude
 */
class Contacts extends \yii\db\ActiveRecord
{
    public $localisation = '';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contacts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude'], 'number'],
            [['published', 'zoom'], 'integer'],
            [['addres', 'localisation'], 'string', 'max' => 100],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'addres' => Yii::t('app', 'Addres'),
            'latitude' => Yii::t('app', 'Latitude'),
            'published' => Yii::t('app', 'Published'),
            'longitude' => Yii::t('app', 'Longitude'),
            'localisation' => Yii::t('app', 'Localisation'),
            'zoom' => Yii::t('app', 'Zoom'),
        ];
    }
    
     public static function getContent(){
        $query ="
            SELECT c.title, CONCAT(c.latitude, ', ', c.longitude) AS 'coordinate', c.zoom, cont.top
            FROM contacts c
            LEFT JOIN content cont ON cont.target_id = c.id AND cont.`type` = 'contact'
            WHERE c.id = 1
        ";
        
        return Yii::$app->db->createCommand($query)->queryOne();
    }
}
