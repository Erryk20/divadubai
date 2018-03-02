<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $src
 * @property int $order
 *
 * @property ServiceCategories[] $serviceCategories
 */
class Services extends \yii\db\ActiveRecord
{
    public $file;
    
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
        return 'services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['order'], 'integer'],
            [['name', 'slug', 'src'], 'string', 'max' => 100],
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
            'src' => 'Src',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceCategories()
    {
        return $this->hasMany(ServiceCategories::className(), ['service_id' => 'id']);
    }
    
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->slug == ''){
                $this->slug = \app\components\TranslitFilter::translitUrl($this->name);
            }
            return true;
        }
        return false;
    }
    
    public static function getList(){
        $query ="
            SELECT id, name
            FROM services
        ";
        
        $request = Yii::$app->db->createCommand($query);
        
        return ArrayHelper::map($request->queryAll(), 'id', 'name');
        
    }
    
    
    public static function getListCategory(){
        $query ="
            SELECT s.`name` AS 's_name', s.slug AS 's_slug', s.src, sc.`name` AS 'sc_name' , sc.slug AS 'sc_slug'
            FROM services s
            LEFT JOIN service_categories sc ON sc.service_id = s.id
            ORDER BY s.`order`, s.name
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$value['s_slug']]['name'] = $value['s_name'];
            $result[$value['s_slug']]['src'] = $value['src'];
            $result[$value['s_slug']]['category'][$value['sc_slug']] = $value['sc_name'];
        }
        
        return $result;
        
    }
}
