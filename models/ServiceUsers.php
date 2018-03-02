<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "service_users".
 *
 * @property int $id
 * @property int $service_cat_id
 * @property int $info_user_id
 * @property int $order
 * 
 * @property UserInfo $infoUser 
 * @property ServiceCategories $serviceCat
 */
class ServiceUsers extends \yii\db\ActiveRecord
{
    
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
        return 'service_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_cat_id', 'info_user_id'], 'required'],
            [['service_cat_id', 'info_user_id', 'order'], 'integer'],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']], 
            [['service_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceCategories::className(), 'targetAttribute' => ['service_cat_id' => 'id']],
        ];
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getInfoUser() 
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'info_user_id']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getServiceCat()
    {
        return $this->hasOne(ServiceCategories::className(), ['id' => 'service_cat_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_cat_id' => 'Service Cat ID',
            'info_user_id' => 'Info User ID',
            'order' => 'Order',
        ];
    }
    
    public static function getNextLast($order_id){
        $query = "
            SELECT dm.url, du.info_user_id,  '/site/diva' AS pre_url, du.info_user_id
            FROM diva d
            LEFT JOIN diva_media dm ON dm.diva_id = d.id
            LEFT JOIN diva_user du ON du.diva_media_id = dm.id

            WHERE d.url = 'productions'
            AND dm.url = 'post-production'
            AND (du.order IN(:order_id-1, :order_id+1))
            ORDER BY du.order ASC
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':order_id' => $order_id,
        ]); 
        
        return ArrayHelper::map($request->queryAll(), 'id', 'src') ;
    }
    
    
    
    public static function getServiceNextLastUser($service, $url, $info_user_id){
        Yii::$app->db->createCommand("
            SET @i := 0;
            SET @key := null;
        ")->execute();
        
        $query = "

            SELECT us.* 
            FROM (
                SELECT s.slug AS 'service', sc.slug, @i := (@i + 1) AS 'i', IF(su.info_user_id = :info_user_id, @key :=@i, null) AS 'resut', su.info_user_id
                FROM services s
                LEFT JOIN service_categories sc ON sc.service_id = s.id
                LEFT JOIN service_users su ON su.service_cat_id = sc.id
                WHERE s.slug = :service
                AND sc.slug = :url
                ORDER BY su.`order` ASC
            ) as `us`
            WHERE us.i IN (@key-1, @key, @key+1)
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':service' => $service, //'films--production'
            ':url' => $url, //'logistics'
            ':info_user_id' => $info_user_id, // 20
        ])->queryAll(); 
        
        $key = false;
        $result = [
            'service' => NULL,
            'slug' => NULL,
            'next_id' => false,
            'prev_id' => false,
        ];
        
        
        foreach ($request as $value) {
            if($key === false && $value['resut'] === null){
                $result['prev_id'] = $value['info_user_id'];
            }elseif($key === false && $value['resut'] != null){
                $key = true;
            }elseif($key === true && $value['resut'] === null){
                $result['next_id'] = $value['info_user_id'];
            }
            
            $result['service'] = $value['service'];
            $result['slug'] = $value['slug'];
        }
        
        return $result;
    }
    
    public static function getList($service, $url, $filter){
        $ethnicity = self::getStringFromArray($filter['ethnicity']);
        $specialization = self::getStringFromArray($filter['specialization']);
       
        $query = "
            SELECT s.slug AS 'service', sc.slug, sc.short, su.info_user_id, IFNULL(
            (
                SELECT src
                FROM user_media
                WHERE info_user_id = su.info_user_id
                AND `type` = 'image'
                ORDER BY `order` ASC
                LIMIT 1
            ), 'diva-logo.png') AS 'logo'
            FROM services s
            LEFT JOIN service_categories sc ON sc.service_id = s.id
            LEFT JOIN service_users su ON su.service_cat_id = sc.id
            LEFT JOIN user_info ui ON ui.id = su.info_user_id
            
            WHERE s.slug = :service
            AND sc.slug = :url".
            (($ethnicity != '') ? " \n AND IF('{$ethnicity}' = '', true,  ui.ethnicity REGEXP '({$ethnicity})')" : NULL).
            (($specialization != '') ? " \n AND IF('{$specialization}' = '', true,  ui.specialization REGEXP '({$specialization})')" : NULL).
            "\n ORDER BY su.`order` ASC
        ";
        
            $params = [
                ':service' => $service,
                ':url' => $url,
            ];
            
        return Yii::$app->db->createCommand($query, $params)->queryAll(); 
    }
    
    
    public static function getStringFromArray($array){
        $result = '';
        if($array){
            $i = 0;
            foreach ($array as $key => $value) {
                $result[$i++] = $key;
            }
            $result = implode('|', $result);
        }
        return $result;
    } 
    
}
