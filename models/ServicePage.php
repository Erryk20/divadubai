<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_page".
 *
 * @property int $id
 * @property int $parent_id 
 * @property string $link
 * @property string $name
 * @property string $src
 * @property int $order
 * 
 *
 * @property ServicePage $parent 
 * @property ServicePage[] $servicePages 
 */
class ServicePage extends \yii\db\ActiveRecord
{
    public $file;
    public $parentName;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link', 'name'], 'required'],
            [['parent_id', 'order'], 'integer'],
            [['link', 'name', 'src'], 'string', 'max' => 100],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServicePage::className(), 'targetAttribute' => ['parent_id' => 'id']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent', 
            'link' => 'Link',
            'name' => 'Name',
            'src' => 'Src',
            'order' => 'Order',
        ];
    }
    
      /**
     * @return \yii\db\ActiveQuery 
     */
    public function getParent() {
        return $this->hasOne(ServicePage::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery 
     */
    public function getServicePages() {
        return $this->hasMany(ServicePage::className(), ['parent_id' => 'id']);
    }
    
    public static function getListParent(){
        $query = "
            SELECT id, `name`
            FROM service_page
            WHERE parent_id IS NULL
            ORDER BY `order`
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[$value['id']] = $value['name'];
        }
        return $result;
    }
    
    
    public static function getListAll(){
        $query = "
            SELECT sp.id, sp.parent_id, psp.`name` AS parent, sp.`link`, sp.`name`, sp.src
            FROM service_page sp
            LEFT JOIN service_page psp ON psp.id = sp.parent_id
            ORDER BY sp.parent_id, sp.`order` ASC
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            if($value['parent'] == null){
                $result[$value['name']]['src'] = $value['src'];
                $result[$value['name']]['link'] = $value['link'];
            }else{
                $result[$value['parent']]['list'][] = [
                    'link' => $value['link'],
                    'name' => $value['name'],
                ];
            }
        }
        return $result;
    }
    
    

}
