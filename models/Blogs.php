<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "blogs".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $src
 * @property string $slug
 * @property int $popular
 * @property int $created_at
 * @property int $updated_at
 */
class Blogs extends \yii\db\ActiveRecord
{
    public $file;
    
    public function behaviors(){
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
    public static function tableName()
    {
        return 'blogs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['src'], 'string', 'max' => 100],
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
            'description' => 'Description',
            'src' => 'Src',
            'slug' => 'Slug',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    
    public static function getListBlogs($limit, $offset = 0){
        $query = "
                SELECT id, title, description, src, slug, created_at
                FROM blogs
                ORDER BY `order` DESC
                LIMIT :offset, :limit
        ";
        
        $list = \Yii::$app->db->createCommand($query, [
            ':limit'=>$limit,
            ':offset'=>$offset,
        ])->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$key] = $value;
            $result[$key]['description'] = mb_strimwidth(strip_tags($value['description']), 0, 200, "...");
        }
        
        return $result;
    }
    
    
    public static function getListBlogsFromPopular($limit = 2){
        $query = "
                SELECT id, title, description, src, slug, created_at, popular
                FROM blogs
                ORDER BY popular DESC
                LIMIT :limit
        ";
        
        $list = \Yii::$app->db->createCommand($query, [
            ':limit'=>$limit,
        ])->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$key] = $value;
            $result[$key]['description'] = mb_strimwidth(strip_tags($value['description']), 0, 200, "...");
        }
        
        return $result;
    }
    
    public static function getListBlogsFromRecent($limit = 4){
        $query = "
                SELECT id, title, slug, created_at
                FROM blogs
                ORDER BY created_at DESC
                LIMIT :limit
        ";
        
        return \Yii::$app->db->createCommand($query, [
            ':limit'=>$limit,
        ])->queryAll();
    }
    
    public static function getCountBlogs(){
        $query = "
                SELECT COUNT(id)
                FROM blogs
                ORDER BY `order` ASC
        ";
        
        return (int)\Yii::$app->db->createCommand($query)->queryScalar();
        
    }
}
