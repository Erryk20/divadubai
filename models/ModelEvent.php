<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "model_event".
 *
 * @property int $id
 * @property string $type
 * @property int $info_user_id
 * @property int $created_at
 * @property int $updated_at
 */
class ModelEvent extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'model_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'info_user_id'], 'required'],
            [['info_user_id', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'info_user_id' => 'Info User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public static function getList($url, $filter, $list, $limit = 40, $ofsset = 0){
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
            ), 'diva-logo.png') AS 'src'
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
        
        
//        $subcategory = self::getStringFromArray($filter['subcategory']);
//        
//        $query = "
//            SELECT me.type, me.info_user_id, '/site/diva' AS pre_url, '' AS url, '' AS short,
//            IFNULL(
//                (
//                    SELECT src
//                    FROM user_media
//                    WHERE info_user_id = me.info_user_id
//                    AND `type` = 'image'
//                    ORDER BY `order` ASC
//                    LIMIT 1
//                ), 'diva-logo.png') AS 'src'
//            FROM model_event me
//            LEFT JOIN user_info ui ON ui.id = me.info_user_id
//            WHERE IF(:type = '', true, me.type = :type)
//            AND IF(:name = '', true, ui.name LIKE :name)".
//            (($subcategory != '') ? " \n AND IF('{$subcategory}' = '', true,  ui.subcategory REGEXP '({$subcategory})')" : NULL).
//            (($type === false) ? " \n GROUP BY pa.info_user_id" : NULL).
//            " LIMIT  :ofsset, :limit  ";
//            
//            $params = [
//                ':type' => $type,  
//                ':name' => "%$filter->name%",
//                ':ofsset' => $ofsset,  
//                ':limit' => $limit,  
//            ];
//            
//        return Yii::$app->db->createCommand($query, $params)->queryAll(); 
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
