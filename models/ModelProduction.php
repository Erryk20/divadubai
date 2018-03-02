<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "model_production".
 *
 * @property int $id
 * @property string $type
 * @property int $info_user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UserInfo $infoUser
 */
class ModelProduction extends \yii\db\ActiveRecord
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
        return 'model_production';
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
            'type' => 'Type',
            'info_user_id' => 'Info User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfoUser()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'info_user_id']);
    }
    
    public static function getList($type, $filter, $list,  $limit = 40, $ofsset = 0){
        $ethnicity = self::getStringFromArray($filter['ethnicity']);
        $specialization = self::getStringFromArray($filter['specialization']);
        $subcategory = self::getStringFromArray($filter['subcategory'], '"');
        
        if(($age = ModelSubcategory::getSlugFromId($filter['age'])) != null && $age != 'al'){
            $ageArray = explode('-', $age);

            if(count($ageArray) > 1){
                list($start, $finish) = $ageArray;
                $start = strtotime( "{$start}-01-01" );
                $finish = strtotime( "{$finish}-01-01" );
            }
        }
        
        $query = "
            SELECT IF(:type IN ('malecasts', 'femalecasts', 'familycasts'), sh.short, mc.short) AS short, :type AS url, uc.info_user_id, 
            '/site/diva' AS pre_url,
            IFNULL((
                SELECT src
                FROM user_media
                WHERE info_user_id = uc.info_user_id
                AND `type` = 'image'
                ORDER BY `order` ASC
                LIMIT 1
            ), 'diva-logo.png') AS 'src',
            (
                SELECT GROUP_CONCAT(CONCAT('\"', subcategory_id, '\"') SEPARATOR ',')
                FROM user_subcategory
                WHERE info_user_id = ui.id
            ) AS subcategory
            FROM user_category  uc
            LEFT JOIN user_info ui ON ui.id = uc.info_user_id
            LEFT JOIN model_category mc ON mc.id = uc.category_id
            LEFT JOIN 
            (
                SELECT `slug`, `short` 
                FROM model_category 
                WHERE menu = 'production'
            ) sh ON sh.slug = CONCAT(ui.gender,'casts')".
                
            " WHERE ui.active = '1'
            AND ui.availability != '-1'
            AND IF(:name = '%%', true, ui.name LIKE :name)
            AND IF(:type = '', 
                    true, 
                    IF(
                        :type IN ('malecasts', 'femalecasts', 'familycasts'), 
                        (mc.slug = 'casts' AND ui.gender = REPLACE(:type , 'casts', '')), 
                        mc.slug = :type
                    )
            )".
            "AND (mc.id IN ({$list}) OR mc.parent_id IN ({$list}))".
//            (($list_id != null) ? " \n AND uc.category_id IN ($list_id)" : null ).
                    

            (($ethnicity != '') ? " \n AND IF('{$ethnicity}' = '', true,  ui.ethnicity REGEXP '({$ethnicity})')" : NULL).
            (($specialization != '') ? " \n AND IF('{$specialization}' = '', true,  ui.specialization REGEXP '({$specialization})')" : NULL).
//            (($subcategory != '') ? " \n AND IF('{$subcategory}' = '', true,  us.subcategory_id IN({$subcategory}))" : NULL).
            (($age && $age != 'all') ? " \n AND (ui.birth > {$start} AND ui.birth < {$finish})" : null).
            " \n HAVING IF('{$subcategory}' = '', true, subcategory REGEXP '({$subcategory})')".      
            " LIMIT :ofsset, :limit";
            " ORDER BY ui.availability DESC, uc.created_at DESC";
            
            $params = [
                ':limit' => $limit,  
                ':ofsset' => $ofsset,  
                ':type' => $type,  
                ':name' => "%$filter->name%"
            ];
            
        return Yii::$app->db->createCommand($query, $params)->queryAll(); 
    }
    
    
    public static function getStringFromArray($array, $separator = ''){
        $result = '';
        
        if($array){
            $i = 0;
            foreach ($array as $key => $value) {
                $result[$i++] = $separator.$key.$separator;
            }
            $result = implode('|', $result);
        }
        return $result;
    } 
}
