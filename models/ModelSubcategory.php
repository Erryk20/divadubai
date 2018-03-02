<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "model_subcategry".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 *
 */
class ModelSubcategory extends \yii\db\ActiveRecord
{
    public $category;
    public $parent;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'model_subcategry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name'], 'required'],
            [['id', 'category_id'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelSubcategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['parent_id', 'category_id', 'name'], 'unique', 'targetAttribute' => ['parent_id', 'category_id', 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'slug' => 'Slug',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ModelSubcategry::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelSubcategries()
    {
        return $this->hasMany(ModelSubcategry::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ModelCategory::className(), ['id' => 'category_id']);
    }
    
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->slug == ''){
                $this->slug = \app\components\TranslitFilter::translitUrl($this->name);
            }
            return true;
        } else {
            return false;
        }
    }
    
    public static function listAll(){
        $query = "
            SELECT ms.id, pms.name AS parent, ms.`name`
            FROM model_subcategry ms
            LEFT JOIN model_subcategry pms ON pms.id = ms.parent_id
            ORDER BY ms.name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            if($value['parent'] == null){
                $result[$value['id']] = $value['name'];
            }else{
                $result[$value['parent']][$value['id']] = $value['name'];
            }
        }
        return $result;
    }
    
    public static function listAllForCategory($id){
        $query = "
            SELECT ms.id, pms.name AS parent, ms.`name`
            FROM model_subcategry ms
            LEFT JOIN model_subcategry pms ON pms.id = ms.parent_id
            WHERE ms.category_id = :category_id
            ORDER BY ms.name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query, [':category_id'=>$id])->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            if($value['parent'] == null){
                $result[$value['id']] = $value['name'];
            }else{
                $result[$value['parent']][$value['id']] = $value['name'];
            }
        }
        return $result;
    }
    
    public static function listSubcategory(){
        $query = "
            SELECT ms.id, mc.name AS parent, ms.`name`
            FROM model_subcategry ms
            LEFT JOIN model_category mc ON mc.id = ms.category_id
            ORDER BY ms.name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            if($value['parent'] == null){
                $result[$value['id']] = $value['name'];
            }else{
                $result[$value['parent']][$value['id']] = $value['name'];
            }
        }
        return $result;
    }
    
    public static function getList(){
        $query = "
            SELECT id, `name`
            FROM model_subcategry
            WHERE parent_id IS NULL
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    
    public static function getListSubcategoryForCategory($slug, $parent){
        $query = "
            SELECT ms.id, ms.parent_id, IFNULL(pms.`name`, :parent) AS parent, ms.`name`
            FROM model_category mc
            LEFT JOIN model_subcategry ms ON mc.id = ms.category_id 
            LEFT JOIN model_subcategry pms ON pms.id = ms.parent_id
            WHERE mc.slug = :slug
            AND mc.id NOT IN (5)
            AND ms.id IS NOT NULL
            ORDER BY ms.id ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query, [
            ':slug'=>$slug,
            ':parent'=>$parent,
        ])->queryAll();
        
        $result = [];
        $delete = [];
        foreach ($list as $key => $value) {
            if($value['id'] != NUll){
                if($value['parent'] == null){
                    $result[$value['id']] = $value['name'];
                }else{
                    $result[$value['parent']][$value['id']] = $value['name'];
                    $delete[$value['parent_id']] = $value['parent_id'];
                }
            }
        }
        
        foreach ($delete as $key => $value) {
            if($value){
                unset($result['Category'][$value]);
            }
        }
        
        return $result;
    }
    
    
    public static function getListSubcategoryForCategoryID($id, $parent){
        $query = "
            SELECT ms.id, ms.parent_id, IFNULL(pms.`name`, :parent) AS parent, ms.`name`
            FROM model_category mc
            LEFT JOIN model_subcategry ms ON mc.id = ms.category_id 
            LEFT JOIN model_subcategry pms ON pms.id = ms.parent_id
            WHERE mc.id = :id
            AND ms.id IS NOT NULL
            ORDER BY ms.id ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query, [
            ':id'=>$id,
            ':parent'=>$parent,
        ])->queryAll();
        
        
        $result = [];
        $delete = [];
        foreach ($list as $key => $value) {
            if($value['id'] != NUll){
                if($value['parent'] == null){
                    $result[$value['id']] = $value['name'];
                }else{
                    $result[$value['parent']][$value['id']] = $value['name'];
                    
                    $delete[$value['parent_id']] = $value['parent_id'];
                }
            }
        }
        
        foreach ($delete as $key => $value) {
            foreach ($result as $category => $item) {
                unset($result[$category][$value]);
            }
        }
        return $result;
    }
    
    public static function getSlugFromId($id){
        $queryry = "
            SELECT slug
            FROM model_subcategry
            WHERE id = :id
        ";
        
        return \Yii::$app->db->createCommand($queryry, [':id'=>$id])->queryScalar();
    }
    
    public static function getListSubcategoryFromCategory($category_id){
        $query = "
            SELECT ms.id, pms.name AS parent, ms.`name`
            FROM model_category mc
            LEFT JOIN model_subcategry ms ON ms.category_id = mc.id
            LEFT JOIN model_subcategry pms ON pms.id = ms.parent_id
            WHERE mc.parent_id = :category_id
            AND ms.id IS NOT NULL
            ORDER BY ms.name, ms.id ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query, [':category_id'=>$category_id])->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            if($value['parent'] == null){
                $result[$value['id']] = $value['name'];
            }else{
                $result[$value['parent']][$value['id']] = $value['name'];
            }
        }
        return $result;
    }
    
    public static function listSubcategoryGroup($id){
        $query = "
            SELECT ms.id, ms.`name`, mc.`name` AS parent
            FROM model_subcategry ms
            LEFT JOIN model_category mc ON mc.id = ms.category_id
            WHERE mc.id = :category_id OR mc.parent_id = :category_id
            ORDER BY mc.name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query, [':category_id'=>$id])->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            if($value['parent'] == null){
                $result[$value['id']] = $value['name'];
            }else{
                $result[$value['parent']][$value['id']] = $value['name'];
            }
        }
        return $result;
    }
    
    public static function getListSubcategoryFromUser($id){
        $query = "
            SELECT ms.id, ms.category_id
            FROM user_subcategory uc
            LEFT JOIN model_subcategry ms ON ms.id = uc.subcategory_id
            WHERE uc.info_user_id = :id
        ";
        
        $list = \Yii::$app->db->createCommand($query, [':id'=>$id])->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[$value['category_id']][] = $value['id'];
        }
        
        return $result;
    }
    
    public static function getListSubcategoryFofCategoryID($id){
        $query = "
            SELECT mc.id, IFNULL(pmc.name, 'Sub Category') AS 'parent', mc.`name`
            FROM model_subcategry mc
            LEFT JOIN model_subcategry pmc ON pmc.id = mc.parent_id
            WHERE mc.category_id = :id
            ORDER BY mc.name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query, [':id'=>$id])->queryAll();
        
        
        $result = [];
        foreach ($list as $value) {
            $result[$value['parent']][$value['id']] = $value['name'];
        }
        return $result;
    }
    
    public static function getListSubcategoryFromId($listId){
        $strId = implode(',', $listId);
        
        $result = [];
        if($strId != ''){
            $query = "
                SELECT id, category_id
                FROM model_subcategry
                WHERE id IN ({$strId})
            ";

            $list = \Yii::$app->db->createCommand($query)->queryAll();

            foreach ($list as $value) {
                $result[$value['category_id']][] = $value['id'];
            }
        }
        return $result;
    }
    
    
}
