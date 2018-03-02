<?php

namespace app\models;

use Yii;
use \yii\helpers\ArrayHelper;

/**
 * This is the model class for table "countries".
 *
 * @property int $num_code
 * @property string $alpha_2_code
 * @property string $alpha_3_code
 * @property string $en_short_name
 * @property string $nationality
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['num_code'], 'required'],
            [['num_code'], 'integer'],
            [['alpha_2_code'], 'string', 'max' => 2],
            [['alpha_3_code'], 'string', 'max' => 3],
            [['en_short_name'], 'string', 'max' => 52],
            [['nationality'], 'string', 'max' => 39],
            [['alpha_2_code'], 'unique'],
            [['alpha_3_code'], 'unique'],
            [['num_code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'num_code' => 'Num Code',
            'alpha_2_code' => 'Alpha 2 Code',
            'alpha_3_code' => 'Alpha 3 Code',
            'en_short_name' => 'En Short Name',
            'nationality' => 'Nationality',
        ];
    }
    
    
    public static function getPrependPhones(){
        $query = "
            SELECT prepend_phone AS 'id', CONCAT('+', prepend_phone) AS 'value'
            FROM countries
            WHERE prepend_phone IS NOT NULL
            ORDER BY prepend_phone ASC
        ";
        $query = \Yii::$app->db->createCommand($query);
        
        return ArrayHelper::map($query->queryAll(), 'id', 'value');
    }
    
    
    public static function getNationalities(){
        $query = "
            SELECT nationality AS 'id', nationality AS 'value'
            FROM countries
            ORDER BY nationality ASC
        ";
        $query = \Yii::$app->db->createCommand($query);
        
        return ArrayHelper::map($query->queryAll(), 'id', 'value');
    }
    
    
    
    public static function getCountries(){
        $query = "
            SELECT en_short_name AS 'name'
            FROM countries
            ORDER BY en_short_name ASC
        ";
        $query = \Yii::$app->db->createCommand($query);
        
        return ArrayHelper::map($query->queryAll(), 'name', 'name');
    }
}
