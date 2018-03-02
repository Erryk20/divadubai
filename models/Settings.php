<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property string $properties
 * @property string $value
 */
class Settings extends \yii\db\ActiveRecord
{
    public $select;
    
    public $pause;
    public $speed;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['properties', 'value'], 'required', 'except'=>['slider']],
            [['properties'], 'string', 'max' => 20],
            [['value'], 'string', 'max' => 50],
            [['properties'], 'unique'], 
            
            [['pause', 'speed'], 'integer', 'on'=>['slider']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'properties' => Yii::t('app', 'Properties'),
            'value' => Yii::t('app', 'Value'),
        ];
    }
    
    public function saveProperties(){
        if(!empty($this->pause) || !empty($this->speed)){

            if(!empty($this->pause)){
                $model = self::findOne(['properties'=>'slider-pause']);
                $model->value = $this->pause;
                $model->save(false);
            }

            if(!empty($this->speed)){
                $model = self::findOne(['properties'=>'slider-speed']);
                $model->value = $this->speed;
                $model->save(false);
            }
        }

        return true;
    }
    
    
    public static function getSliderProperty(){
        $db = Yii::$app->db;
        
        $query = "
            SELECT properties, `value`
            FROM settings
            WHERE properties IN ('slider-pause', 'slider-speed');
        ";
        
        $result = $db->createCommand($query)->queryAll();
        
        $property = [];
        foreach ($result as $value) {
            switch ($value['properties']){
                case 'slider-pause': $property['pause'] = (int) $value['value']; break;
                case 'slider-speed': $property['speed'] = (int) $value['value']; break;
            }
        }
        return $property;
    }
    
    public static function setSliderProperty(){
        $result = self::getSliderProperty();
        
        $model = new self;
        $model->pause = $result['pause'];
        $model->speed = $result['speed'];
        return $model;
    }
}
