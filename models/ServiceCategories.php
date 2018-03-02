<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_categories".
 *
 * @property int $id
 * @property int $service_id
 * @property string $name
 * @property string $short 
 * @property string $slug
 *
 * @property Services $service
 */
class ServiceCategories extends \yii\db\ActiveRecord
{
    public $service_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_id', 'name', 'short'], 'required'],
            [['service_id'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['short'], 'string', 'max' => 5],
            [['service_id', 'name'], 'unique', 'targetAttribute' => ['service_id', 'name']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'name' => 'Name',
            'short' => 'Short Name', 
            'slug' => 'Slug',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::className(), ['id' => 'service_id']);
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
    
    public static function getList($dalete = true){
        $query = "
            SELECT sc.id, sc.`name`, s.`name` AS 'cat_name'
            FROM service_categories sc
            LEFT JOIN services s ON s.id = sc.service_id
            ORDER BY s.`order` ASC
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$value['cat_name']][$value['id']] = $value['name'];
        }
        return $dalete ? ['0'=>'Delete']+$result : $result;
    }
    
    public static function getIfoTop($service, $url){
        $query = "
            SELECT s.`name` AS 'cat_name', s.slug AS 'cat_url', sc.`name`, sc.slug
            FROM service_categories sc
            LEFT JOIN services s ON s.id = sc.service_id
            WHERE sc.slug = :url
            AND s.slug = :service
        ";
        
        return \Yii::$app->db->createCommand($query, [
            ':service'=> $service,
            ':url' => $url,
        ])->queryOne();
    }
    
    public static function getMenu($service, $url){
        $query = "
           SELECT sc.id, sc.slug, sc.`name`, s.slug AS 'service', IF(sc.slug = :url, 1, 0) AS is_active
            FROM service_categories sc
            LEFT JOIN services s ON s.id = sc.service_id
            WHERE s.slug = :service
        ";
        
        return \Yii::$app->db->createCommand($query, [
            ':service'=> $service,
            ':url' => $url,
        ])->queryAll();
    }
}
