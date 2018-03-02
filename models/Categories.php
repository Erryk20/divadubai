<?php

namespace app\models;

use Yii;
use app\components\TranslitFilter;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $url
 * @property string $img
 * @property string $published
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Categories $parent
 * @property Categories[] $categories
 */
class Categories extends \yii\db\ActiveRecord
{
    public $file;
    public $src;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }
    
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
//            'sortable' => [
//                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
//                'query' => self::find(),
//            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at', 'parent_id'], 'integer'],
            [['img'], 'string', 'max' => 50],
            [['name', 'url'], 'string', 'max' => 255],
            [['url'], 'unique'],
            ['file', 'image', 'minWidth' => 540, 'minHeight' => 253, 'extensions' => 'jpg, gif, png'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'published' => 'Published',
            'parent_id' => 'Parent Category',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getParent() {
        return $this->hasOne(Categories::className(), ['id' => 'parent_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getCategories() {
        return $this->hasMany(Categories::className(), ['parent_id' => 'id']);
    }

    public function beforeValidate() {
       if(parent::beforeValidate()){
            if ($this->url == ''){
                $this->url = TranslitFilter::translitUrl($this->name);
            }
            return true;
        }else
            return false;
    }
    
    
    public static function getCategoriesUrl($id){
        return self::find()
            ->select([
                'id', 
                'parent_id',
                'name', 
                'url',
                'CONCAT(\'/images/categories/\',IFNULL(img, \'logo.png\')) AS \'src\'', 
                'published'
            ])->where(['id'=>$id])
            ->one();
    }
    
    
    public static function getList(){
        $query = "
            SELECT `name`, '/site/parent' AS 'pre_url', url, 
            CONCAT('/images/categories/', IFNULL(img, 'logo.png')) AS 'src'
            FROM categories
            WHERE published = '1'
            AND parent_id IS NULL
        ";
        
        return \Yii::$app->db->createCommand($query)->queryAll();
    }
    
    
    public static function getCategoryFromUrl($url, $table){
        $query = "
            SELECT c.id, c.`name`, c.url, 
                c2.`name` AS 'parent', c2.url AS 'parent_url', cont.*
            FROM categories c
            LEFT JOIN categories c2 ON c.parent_id = c2.id
            LEFT JOIN content cont ON cont.target_id = c.id AND cont.`type` = :table
            WHERE c.url = :url
            AND c.published = '1'
        ";
        
        return \Yii::$app->db->createCommand($query, [
            ':url' => $url,
            ':table' => $table,
        ])->queryOne();
    }
    
    
    
    public static function getChildrenCategoryFromId($category_id){
        $query = "
            SELECT `name`, '/site/children' AS 'pre_url',  url AS 'children', CONCAT('/images/categories/', img) AS 'src'
            FROM categories
            WHERE parent_id = :category_id
            AND published = '1'
        ";
        
        return \Yii::$app->db->createCommand($query, [
            ':category_id' => $category_id,
        ])->queryAll();
    }
    
    /**
     * Вертає список категорій
     * @return type
     */
    public static function getCategoriesId(){
        $query = self::find()
                ->select(['id','name'])
                ->orderBy('name')
                ->where(['IS','parent_id', NULL])
                ->asArray();
        return ArrayHelper::map($query->all(), 'id', 'name');
    }
    
    
    public static function getAllCategoriesId(){
        $query = "
            SELECT c.id, c2.`name` AS 'parent', c.`name`
            FROM categories c
            LEFT JOIN categories c2 ON c2.id = c.parent_id
            WHERE c.published = '1'
            ORDER BY c.id ASC
        ";
        $query = \Yii::$app->db->createCommand($query);
        
        $result = [];
        foreach ($query->queryAll() as $value) {
            if($value['parent'] == NULL){
                $result[$value['name']] = [];
            }else{
                $result[$value['parent']][$value['id']] = $value['name'] ;
            }
        }
        return $result;
    }

    /************************************************************************/
    
    
    /**
     * Returns a list of categories
     * @return type
     */
//    public static function getCategoriesUrl($language = null){
//        $query = self::find()
//                ->from('categories c')
//                ->select(['c.url','cl.name'])
//                ->leftJoin('categories_lan cl', 'cl.category_id = c.id')
//                ->filterWhere(['cl.language' => $language])
//                ->orderBy('cl.name')
//                ->asArray();
//        
//        $result = $query->all();
//        if(!$result){
//            $query = self::find()
//                    ->from('categories c')
//                    ->select(['c.url','cl.name'])
//                    ->leftJoin('categories_lan cl', 'cl.category_id = c.id')
//                    ->filterWhere(['cl.language' => 'en'])
//                    ->orderBy('cl.name')
//                    ->asArray();
//            
//            $result = $query->all();
//        }
//        
//        return \yii\helpers\ArrayHelper::map($result, 'url', 'name');
//    }
}
