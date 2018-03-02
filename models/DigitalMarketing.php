<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "digital_marketing".
 *
 * @property int $id
 * @property int $info_user_id
 *
 * @property UserInfo $infoUser
 */
class DigitalMarketing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'digital_marketing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['info_user_id'], 'required'],
            [['info_user_id'], 'integer'],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_user_id' => 'Info User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfoUser()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'info_user_id']);
    }
    
    public static function itemAlias($type, $code = NULL) {
        $_items = [
            'type' => [
                "influencers"=>"Influencers",
            ],
        ];
        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
    
    public static function getMenu($type){
        $list = self::itemAlias('type');
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[] = [
                'url'=>$key,
                'name'=>$value,
                'is_active'=> ($type == $key),
            ];
        }
        return $result;
    }
    
    public static function getList($url, $filter, $limit, $ofsset){
        $list = MenuCategory::getListIDFromMenu('digital-marketing');

        $ethnicity = self::getStringFromArray($filter['ethnicity']);
        $specialization = self::getStringFromArray($filter['specialization']);
        
        $subcategory = '';
        if($filter['subcategory']){
            $subcategory = array_keys($filter['subcategory']);
            $subcategory = implode(',', $subcategory);
        }
        
        $query = "
            SELECT mc.slug AS 'type', mc.short, uc.info_user_id, '/site/diva' AS pre_url, mc.slug AS url, IFNULL(
            (
                SELECT src
                FROM user_media
                WHERE info_user_id = uc.info_user_id
                AND `type` = 'image'
                ORDER BY `order` ASC
                LIMIT 1
            ), 'diva-logo.png') AS 'logo'
            FROM user_category  uc
            LEFT JOIN user_info ui ON ui.id = uc.info_user_id
            LEFT JOIN model_category mc ON mc.id = uc.category_id".

            (($subcategory != '') ? " \n LEFT JOIN user_subcategory us ON us.info_user_id = uc.info_user_id" : null).  
                
            " WHERE IF(:url = '', true, 
                        IF(:url IN ('male', 'female'), 
                            ui.gender = :url, 
                            mc.slug = :url
                        )
                    )
            AND ui.availability != '-1'
            AND (mc.id IN ({$list}) OR mc.parent_id IN ({$list}))
            AND ui.active = '1'
            AND IF(:name = '', true, ui.name LIKE :name)".
            (($subcategory != '') ? " \n AND us.subcategory_id IN ({$subcategory})" : NULL).
            (($ethnicity != '') ? " \n AND IF('{$ethnicity}' = '', true,  ui.ethnicity REGEXP '({$ethnicity})')" : NULL).
            (($specialization != '') ? " \n AND IF('{$specialization}' = '', true,  ui.specialization REGEXP '({$specialization})')" : NULL).
            " GROUP BY ui.id".
            " ORDER BY ui.availability DESC, uc.created_at DESC".
            " LIMIT :ofsset, :limit";
            
            $params = [
                ':limit' => $limit,  
                ':ofsset' => $ofsset,  
                ':url' => $url,  
                ':name' => "%$filter->name%"
            ];
            
        return Yii::$app->db->createCommand($query, $params)->queryAll();
        
        
        
        $query = "
            SELECT dm.type, dm.info_user_id, (
                SELECT src
                FROM user_media
                WHERE info_user_id = dm.info_user_id
                AND `type` = 'image'
                ORDER BY `order` ASC
                LIMIT 1
            ) AS 'logo'
            FROM digital_marketing dm
            LEFT JOIN user_info ui ON ui.id = dm.info_user_id
            WHERE IF(:type = '', true, dm.type = :type)
            having logo IS NOT NULL
        ";
        
        return Yii::$app->db->createCommand($query, [':type' => $type])->queryAll();
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
    
    public static function getUserInfo($id){
        $query = "
            SELECT 
                ui.id, 
                ui.height, 
                ui.chest, 
                ui.waist, 
                ui.hips, 
                ui.shoe, 
                ui.hair, 
                ui.eye, 
                'PA' AS short
            FROM user_info ui
            WHERE ui.id = :id
        ";
        
        return Yii::$app->db->createCommand($query, [':id'=>$id])->queryOne();
    }
    
    public static function getNextLastUser($info_user_id, $type = ''){
        Yii::$app->db->createCommand("
            SET @i := 0;
            SET @key := null;
        ")->execute();
        
        $query = "
            SELECT us.* 
            FROM (
                SELECT pa.type, @i := (@i + 1) AS 'i', IF(pa.info_user_id = :info_user_id, @key :=@i, null) AS 'resut', pa.info_user_id
                FROM digital_marketing pa
                LEFT JOIN user_info ui ON ui.id = pa.info_user_id
                WHERE IF(:type = '', true, pa.type = :type)
            ) as `us`
            WHERE us.i IN (@key-1, @key, @key+1)
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':type' => $type,
            ':info_user_id' => $info_user_id, 
        ])->queryAll(); 
        
        $key = false;
        $result = [
            'url' => NULL,
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
            
            $result['url'] = $value['type'];
        }
        
        return $result;
    }
}
