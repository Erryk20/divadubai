<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "temp_subcategory".
 *
 * @property int $id
 * @property int $info_user_id
 * @property string $subcategory
 * @property int $category_id
 */
class TempSubcategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'temp_subcategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_user_id', 'subcategory', 'category_id'], 'required'],
            [['info_user_id', 'category_id'], 'integer'],
            [['subcategory'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_user_id' => 'Info User ID',
            'subcategory' => 'Subcategory',
            'category_id' => 'Category ID',
        ];
    }
    
    public static function setTempSubcategory(){
        $query = "
            SELECT id, category_id, subcategory
            FROM user_info
            WHERE category_id IS NOT NULL
            AND subcategory IS NOT NULL
            AND subcategory != '[\"\"]'
            -- LIMIT 0,100
            
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        foreach ($list as $key => $value) {
            if(($subcategory = json_decode($value['subcategory'], true)) != null){
                foreach ($subcategory as $item) {
                    if($item != ''){
                        $model = self::findOne([
                           'info_user_id'=>$value['id'],
                           'category_id'=>$value['category_id'],
                           'subcategory'=>trim($item),
                        ]); 
                        if($model == null){
                            $model = new self;
                            $model->info_user_id = $value['id'];
                            $model->category_id = $value['category_id'];
                            $model->subcategory = trim($item);
                            $model->save(false);
                        }
                    }
                }
            }
        }
        die();
    
    }
}
