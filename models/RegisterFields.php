<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "register_fields".
 *
 * @property int $id
 * @property int $category_id
 * @property string $checked
 *
 * @property ModelCategory $category
 */
class RegisterFields extends \yii\db\ActiveRecord
{
    public $categoryName;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'register_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id'], 'integer'],
            [['fields'], 'safe'],
            [['category_id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'fields' => 'Fields',
        ];
    }
    
     public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->fields = is_array($this->fields) ? json_encode($this->fields) : $this->fields;
            return true;
        }
        return false;
    }
    
    public function afterFind() {
        parent::afterFind();
        $this->fields  =  ($this->fields != null) ? json_decode($this->fields, true) : [];
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ModelCategory::className(), ['id' => 'category_id']);
    }
    
    public static function getFields($category_id){
        $query = "
            SELECT fields
            FROM register_fields
            WHERE category_id = :category_id
        ";
        
        $list = \Yii::$app->db->createCommand($query, [':category_id'=>$category_id])->queryOne();
        
        $result = $list ? json_decode($list['fields'], true) : [];
        
        return array_merge($result, ['user_id']);
    }
    
//    public static function getList(){
//        $query = "
//            SELECT id, `name`
//            FROM model_category
//            WHERE parent_id IS NULL
//            ORDER BY name ASC
//        ";
//        
//        $list = \Yii::$app->db->createCommand($query)->queryAll();
//        
//        return ArrayHelper::map($list, 'id', 'name');
//    }
}
