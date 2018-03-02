<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property int $target_id
 * @property string $type
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class Seo extends \yii\db\ActiveRecord
{
    
    public static $list = [
            'title'=>'',
            'keywords'=>'',
            'description'=>'',
        ];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['target_id', 'type'], 'required'],
            [['target_id'], 'integer'],
            [['type', 'description'], 'string'],
            [['title', 'keywords'], 'string', 'max' => 255],
            [['target_id', 'type'], 'unique', 'targetAttribute' => ['target_id', 'type']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'target_id' => 'Target ID',
            'type' => 'Type',
            'title' => 'Title',
            'keywords' => 'Keywords',
            'description' => 'Description',
        ];
    }
    
    public function getTypeArray(){
        $enum = $this->tableSchema->columns['type']->dbType;
        
        preg_match("/^enum\(\'(.*)\'\)$/", $enum, $matches);
        $enum = explode("','", $matches[1]);
        
        $result = [];
        foreach ($enum as $value) {
            $result[$value] = $value;
        }
        return $result;
    }

    public function get_enum_values(){
        $model->tableSchema->columns[$attr]->dbType;
        $type = $this->db->query( "SHOW COLUMNS FROM seo WHERE Field = type" )->row( 0 )->Type;
        
        vd($type);
        
        return $enum;
    }
    
    
    public static function getInfoSeoFromCategoryistID($listID, $type){
        $query = "
            SELECT title, keywords, description 
            FROM `seo` 
            WHERE `type` = :type
            AND `target_id` IN ({$listID})
        ";
        return  $list = \Yii::$app->db->createCommand($query, [':type'=>$type])->queryOne();
    }
    
    public static function getInfoSeo($target_id, $type){
        $query = "
            SELECT title, keywords, description
            FROM seo
            WHERE IF(:target_id NOT IN ('book', 'register'), target_id = :target_id, true)
            AND `type` = :type
        ";
        
        $list = [
            'title'=>'',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $result = \Yii::$app->db->createCommand($query, [
            ':target_id'=>$target_id,
            ':type'=>$type,
        ])->queryOne();
        
        
        return $result ? $result : $list;
    }
    
    
    public static function getInfoFromType($slug){
        $query = "
            SELECT title, keywords, description
            FROM seo
            WHERE `type` = :slug
        ";
        
        $result = \Yii::$app->db->createCommand($query, [
            ':slug'=>$slug,
        ])->queryOne();
        
        return $result ? $result :  self::$list;
    }
    
    public static function getInfoSeoFromCategory($action){
        $query = "
            SELECT s.`target_id`, s.`type`, s.`title`, s.`keywords`, s.`description`
            FROM `seo` s
            LEFT JOIN model_category mc ON mc.id = s.`target_id`
            WHERE s.`type` = 'category'
            AND mc.name = :name
        ";
        
        $list = [
            'title'=>'',
            'keywords'=>'',
            'description'=>'',
        ];
        
        $result = \Yii::$app->db->createCommand($query, [
            ':name'=> ($action != false) ? $action : 'Models'
        ])->queryOne();
        
        return $result ? $result : $list;
        
    }
}
