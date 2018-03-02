<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "model_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string $type 
 *
 * @property ModelCategory[] $modelCategories
 * @property ModelSubcategry[] $modelSubcategries
 */
class ModelCategory extends \yii\db\ActiveRecord
{
    public $parent;
    
    public function behaviors()
    {
        return [
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
        return 'model_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['type', 'ethnicity', 'category', 'specialization', 'age', 'gender', 'short', 'language'], 'string'],
            [['menu'], 'string', 'max' => 50],
            [['name', 'slug'], 'string', 'max' => 100],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelCategory::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['parent_id', 'name'], 'unique', 'targetAttribute' => ['parent_id', 'name']], 
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
            'ethnicity' => 'Ethnicity',
            'category' => 'Category',
            'specialization' => 'Specialization',
            'name' => 'Name',
            'slug' => 'Slug',
            'type' => 'Type', 
            'language' => 'Language', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getParent()
//    {
//        return $this->hasOne(ModelCategory::className(), ['id' => 'parent_id']);
//    }

    
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
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelCategories()
    {
        return $this->hasMany(ModelCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModelSubcategries()
    {
        return $this->hasMany(ModelSubcategry::className(), ['category_id' => 'id']);
    }
    
    public static function getList(){
        $query = "
            SELECT id, `name`
            FROM model_category
            WHERE parent_id IS NULL
            ORDER BY name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    
    public static function getListAllCategory(){
        $query = "
            SELECT id, `name`
            FROM model_category
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    
    public static function getListCategoryEvent($id){
        $query = "
            SELECT id, `name`
            FROM model_category
            WHERE parent_id = :id
        ";
        
        $list = \Yii::$app->db->createCommand($query, [':id' => $id])->queryAll();
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    public static function getListCategoryGroup($list_id){
        $list = is_array($list_id) ? implode(',', $list_id) : $list_id;
        
        $query = "
            SELECT id
            FROM model_category
            WHERE id IN ({$list})
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[] = $value['id'];
        }
        return $result;
    }
    
    
    public static function liatAll(){
        $query = "
            SELECT mc.id, pmc.name AS parent, mc.`name`
            FROM model_category mc
            LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
            ORDER BY mc.parent_id ASC
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
    
    public function getListNameFromUser($types){
        $request = \app\models\ModelCategory::find()
                    ->asArray()
                    ->select(['id','name'])
                    ->where(['id'=>$types]);
        
        return self::editHtmlCategory($request->all());
    }
    
    
    public static function editHtmlCategory($list){
        $result = [];
        foreach ($list as $key => $value) {
            $result[$value['id']] = "<div class='cat-block'>{$value['name']}</div>";
        }
        return $result;
    }
    
    public static function getListIdCategoriesForCategory($id){
        $query = "
            SELECT id
            FROM model_category
            WHERE parent_id = :id OR id = :id
        ";
        
        $list = Yii::$app->db->createCommand($query, [':id'=>$id])->queryAll();
        
        $result= [];
        foreach ($list as $value) {
            $result[] = $value['id'];
        }
        return $result;
    }
    
    public static function listSubcategoryInCategory($id){
        $id = is_array($id) ? implode(',', $id) : $id;
        
        $query = "
            SELECT ms.*, pms.name AS parent
            FROM model_category mc
            LEFT JOIN model_subcategry ms ON ms.category_id = mc.id
            LEFT JOIN model_subcategry pms ON pms.id = ms.parent_id
            WHERE mc.parent_id IN ({$id}) OR mc.id IN ({$id})
            AND ms.id IS NOT NULL
            AND pms.id IS NOT NULL
            ORDER BY ms.id, ms.name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
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
            unset($result[$value]);
        }
        
        return $result;
    }
    
    public static function liatCategoryGroup($id){
        $query = "
            SELECT mc.id, pmc.name AS parent, mc.`name`
            FROM model_category mc
            LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
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
    
    public static function getBlockFilltersForCategory($slug){
        $query = "
            SELECT id, slug, ethnicity, category, specialization, age, gender, language
            FROM model_category
            WHERE slug = :slug
        ";
        return \Yii::$app->db->createCommand($query, [':slug'=>$slug])->queryOne();
    }
    
    public static function getBlockFilltersForCategoryID($id){
        $query = "
            SELECT id, slug, ethnicity, category, specialization, age, gender
            FROM model_category
            WHERE id = :id
        ";
        return \Yii::$app->db->createCommand($query, [':id'=>$id])->queryOne();
    }
    
    public static function getListCategoryFromParent($slug, $url){
        $query = "
            SELECT mc.slug, IF(mc.slug = :url, true, false) AS is_active, mc.`name`
            FROM model_category mc
            LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
            WHERE pmc.slug = :slug
        ";
        return \Yii::$app->db->createCommand($query, [
            ':slug'=>$slug,
            ':url'=>$url,
        ])->queryAll();
    }
    
    public static function getListCategoryFromSite(){
        $query = "
            SELECT mc.id, mc.`name`
            FROM model_category mc
            -- LEFT JOIN register_fields rf ON rf.category_id = mc.id
            WHERE mc.`type` = 'site'
            -- AND rf.id IS NULL
            ORDER BY mc.`name`
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    public static function getListCategory(){
        $query = "
            SELECT mc.id, mc.`name`
            FROM model_category mc
            WHERE (mc.parent_id IS NULL OR mc.type = 'site')
            ORDER BY mc.`name`
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    public static function getListSubcategory(){
        $query = "
            SELECT id, `name`
            FROM model_subcategry
            ORDER BY `name`
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    
    
    public static function breadCrumbs($category = '', $action = ''){
        $query = "
            SELECT 'production' AS pre_url, pmc.`name` AS 'parentName', pmc.slug AS 'parentSlug', mc.`name`, mc.slug
            FROM model_category mc
            LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
            WHERE mc.slug = :action
            AND IF(:action = :category, true, pmc.slug = :category)
        ";
        
        
        $request = \Yii::$app->db->createCommand($query, [
            ':action' => $action,
            ':category' => $category,
        ])->queryOne();
        
        if($request === false){
            $request = [
                'pre_url' => NULL,
                'parentName' => NULL,
                'parentSlug' => NULL,
                'name' => NULL,
                'slug' => NULL
            ];
        }
        return $request;
    }
    
    
    public static function listCategories(){
        $query = "
            SELECT mc.id, pmc.`name` AS parentName, mc.`name`
            FROM model_category mc
            LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
            ORDER BY mc.parent_id, mc.order ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            if($value['parentName'] === null){
                $result[$value['id']] = $value['name'];
            }else{
                $result[$value['parentName']][$value['id']] = $value['name'];
            }
        }
        return $result;
    }
    
    public static function listChildCategories(){
        $query = "
            SELECT mc.id, pmc.`name` AS parentName, mc.`name`
            FROM model_category mc
            LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
            -- WHERE (mc.parent_id IS NOT NULL OR mc.id IN (4))
            ORDER BY pmc.name, mc.name ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        
        $result = [];
        foreach ($list as $value) {
            if($value['parentName'] === null){
                $result[$value['id']] = $value['name'];
            }else{
                $result[$value['parentName']][$value['id']] = $value['name'];
            }
        }
        
        return $result;
    }
    
    
    public static function listCategoriesForAdmin(){
        $query = "
            SELECT id, `name`
            FROM model_category
            WHERE parent_id IS NULL
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    public static function listCategoriesForCasting(){
        $query = "
            SELECT id, `name`
            FROM model_category
            WHERE id IN (45,7,16,5)
        ";
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        return ArrayHelper::map($list, 'id', 'name');
    }
    
    public static function getIdFromCategorySlug($slug){
        $query = "
            SELECT id
            FROM model_category
            WHERE `type` = 'site'
            AND (
                CASE 
                    WHEN :slug = 'models'           THEN slug = 'models'
                    WHEN :slug = 'productions'      THEN slug = 'productions'
                    WHEN :slug = 'photographers'    THEN slug = 'photographers'
                    WHEN :slug = 'influencer'       THEN slug = 'influencers'
                    WHEN :slug = 'cast'             THEN slug = 'casts'
                    WHEN :slug = 'entertainers'     THEN slug = 'entertainer'
                    WHEN :slug = 'events'           THEN slug = 'eventsupport'
                    WHEN :slug = 'location'         THEN slug = 'locations'
                    WHEN :slug = 'promoter'         THEN slug = 'promoters'
                    WHEN :slug = 'stylist'          THEN slug = 'stylists'
                    WHEN :slug = 'directors'                THEN slug = 'director'
                    ELSE :slug = slug
                END
            )
        ";
        return (int)Yii::$app->db->createCommand($query, [':slug'=> $slug])->queryScalar();
    }
    
    
    
}
