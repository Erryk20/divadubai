<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "menu_category".
 *
 * @property int $id
 * @property int $category_id
 * @property string $menu
 *
 * @property MenuCategory $category
 * @property MenuCategory[] $menuCategories
 */
class MenuCategory extends \yii\db\ActiveRecord
{
    public $categories = [];
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categories', 'menu'], 'required'],
            [['category_id'], 'integer'],
            [['categories'], 'safe'],
            [['menu'], 'string', 'max' => 50],
            [['category_id', 'menu'], 'unique', 'targetAttribute' => ['category_id', 'menu']],
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
            'categories' => 'Categories',
            'menu' => 'Menu',
        ];
    }
    
    public function saveCategory() {
        
        if(is_array($this->categories)){
            $old = self::getListCategoryFromMenu($this->menu);

            // delete
            if(!empty($delete = array_diff($old, $this->categories))){
                self::deleteAll([
                    'menu'=>$this->menu,
                    'category_id'=>$delete,
                    ]);
            }

            // create
            foreach (array_diff($this->categories, $old) as $value) {
                $model = new self;
                $model->menu = $this->menu;
                $model->category_id = $value;

                $model->save(true, ['category_id', 'menu']);
            }
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ModelCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuCategories()
    {
        return $this->hasMany(MenuCategory::className(), ['category_id' => 'id']);
    }
    
    public static function listMenu($lsug = false){
        $list = [
            'model-management' => "Model Management",
            'production' => "Production",
            'promotions-activations' => "Promotions Activations",
            'event' => "Events",
            'digital-marketing' => "Digital Marketing",
            'our-work' => "Our Work",
        ];
        
        if($lsug === false){
            return $list;
        }else{
           return isset($list[$lsug]) ? $list[$lsug] : null;
        }
    }
    
    public static function getListCategoryFromMenu($menu){
        $query = "
            SELECT category_id
            FROM menu_category
            WHERE menu = :menu
        ";
        
        $list = Yii::$app->db->createCommand($query, [':menu'=>$menu])->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[] = $value['category_id'];
        }
        return $result;
    }
    
    
    public static function getListIDFromMenu($menu){
        $query = "
            SELECT GROUP_CONCAT(id SEPARATOR ',') AS category
            FROM model_category
            WHERE menu = :menu
            GROUP BY menu
        ";
        
        return Yii::$app->db->createCommand($query, [':menu'=>$menu])->queryScalar();
    }
    
    
    public static function getMenu($menu, $gender){
        $query = "
            SELECT mc.slug AS 'url', IF(mc.slug = :url, true, false) AS is_active, mc.`name`
            FROM model_category mc
            WHERE menu = :menu
            AND id NOT IN (4, 53, 16, 38, 5, 22, 39, 41)
            ORDER BY mc.order
        ";

        return \Yii::$app->db->createCommand($query, [
            ':menu'=>$menu,
            ':url'=>$gender,
        ])->queryAll();
    }
    
    public static function getListMenu($menu){
        $result = [];
        foreach ($menu as $value) {
            $result[] = $value['name'];
        }
        return $result;
    }
}
