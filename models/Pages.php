<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pages".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'slug'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }
    
    
//    public function beforeSave($insert) {
//        if (parent::beforeSave($insert)) {
//            if ($this->slug == ''){
//                $this->slug = \app\components\TranslitFilter::translitUrl($this->name);
//            }
//            return true;
//        } else {
//            return false;
//        }
//    }
    
    public static function getIsView($id){
        $query = "
            SELECT  is_top, is_blockquote, is_description, 
                    is_block_1, is_block_2, is_block_3
            FROM pages
            WHERE id = :id
        ";
        
        return Yii::$app->db->createCommand($query, [':id'=>$id])->queryOne();
    }
    
    public static function getContent($slug){
        $query = "
            SELECT p.`name`, p.slug, c.*
            FROM pages p
            LEFT JOIN content c ON c.target_id = p.id AND c.`type` = 'page'
            WHERE p.slug = :slug
        ";
        
        return Yii::$app->db->createCommand($query, [':slug'=>$slug])->queryOne();
    }

}
