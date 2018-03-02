<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "model_management".
 *
 * @property int $id
 * @property int $info_user_id
 *
 * @property UserInfo $infoUser
 */
class ModelManagement extends \yii\db\ActiveRecord
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
        return 'model_management';
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
    
    public static function getCountList($gender, $filter){
        
        $ethnicity = self::getStringFromArray($filter['ethnicity']);
        $specialization = self::getStringFromArray($filter['specialization']);
        $subcategory = self::getStringFromArray($filter['subcategory']);
        
        $query = "
            SELECT COUNT(mm.id)
            FROM model_management  mm
            LEFT JOIN user_info ui ON ui.id = mm.info_user_id
            
            WHERE IF(:gender = '', true, ui.gender = :gender)
            AND mm.active = '1'
            AND IF(:name = '', true, ui.name LIKE :name)".
            (($ethnicity != '') ? " \n AND IF('{$ethnicity}' = '', true,  ui.ethnicity REGEXP '({$ethnicity})')" : NULL).
            (($specialization != '') ? " \n AND IF('{$specialization}' = '', true,  ui.specialization REGEXP '({$specialization})')" : NULL).
            (($subcategory != '') ? " \n AND IF('{$subcategory}' = '', true,  ui.subcategory REGEXP '({$subcategory})')" : NULL);
            
            $params = [
                ':gender' => $gender,  
                ':name' => "%$filter->name%"
            ];
            
        return (int)Yii::$app->db->createCommand($query, $params)->queryScalar(); 
    }
    
    
    public static function getList($gender, $filter, $list, $limit = 40, $ofsset = 0){
        
        $ethnicity = self::getStringFromArray($filter['ethnicity']);
        $specialization = self::getStringFromArray($filter['specialization']);
        
        $subcategory = '';
        if($filter['subcategory']){
            $subcategory = array_keys($filter['subcategory']);
            $subcategory = implode(',', $subcategory);
        }
        
        $from =  '';
        $to =  '';
        if(!empty($filter['age'])){
            list($to, $from) = explode('-', $filter['age']);
            $yearNow = (int)date('Y', time());
            
            $from = $yearNow - (int)$from;
            $to = $yearNow - (int)$to;
            
            $from = strtotime("{$from}-01-01");
            $to = strtotime("{$to}-01-01");
        }
        
        $query = "
            SELECT sh.short, ui.gender, uc.info_user_id, 
            FIND_IN_SET(ms.slug,'model1,model2, ,international') AS 'sort',
            IFNULL(
                (
                    SELECT src
                    FROM user_media
                    WHERE info_user_id = uc.info_user_id
                    AND `type` = 'image'
                    ORDER BY `order` ASC
                    LIMIT 1
                ), 
                'diva-logo.png'
            ) AS 'logo'
            FROM user_category  uc
            LEFT JOIN user_info ui ON ui.id = uc.info_user_id
            LEFT JOIN model_category mc ON mc.id = uc.category_id
            LEFT JOIN user_subcategory us ON us.info_user_id = ui.id
            LEFT JOIN model_subcategry ms ON ms.id = us.subcategory_id AND  ms.`name` IN ('international', 'model1', 'model2')
            LEFT JOIN 
            (
                SELECT `slug`, `short` 
                FROM model_category 
                WHERE menu = 'model-management'
            ) sh ON sh.slug = ui.gender
            ".

            (($subcategory != '') ? " \n LEFT JOIN user_subcategory us ON us.info_user_id = uc.info_user_id" : null).  
            " WHERE IF(:gender = '', true, IF(:gender = 'child', ui.gender IN ('girl','boy'), ui.gender = :gender))
            -- AND uc.category_id = '4'
            AND (mc.id IN ({$list}) OR mc.parent_id IN ({$list}))
            AND ui.active = '1'
            AND ui.availability != '-1'
            AND IF(:from = '',true, (ui.birth > :from AND ui.birth < :to))
            
            AND IF(:name = '', true, ui.name LIKE :name)".
                
            (($subcategory != '') ? " \n AND us.subcategory_id IN ({$subcategory})" : NULL).
                    
            (($ethnicity != '') ? " \n AND IF('{$ethnicity}' = '', true,  ui.ethnicity REGEXP '({$ethnicity})')" : NULL).
            (($specialization != '') ? " \n AND IF('{$specialization}' = '', true,  ui.specialization REGEXP '({$specialization})')" : NULL).
//            " GROUP BY us.info_user_id ".       
            " GROUP BY ui.id".
//            " ORDER BY ui.availability DESC, sort DESC, uc.created_at DESC".
            " ORDER BY ui.availability ASC, ui.`name` ASC ".
            " LIMIT :ofsset, :limit";
            
            $params = [
                ':from' => $from,  
                ':to' => $to,  
                
                ':limit' => $limit,  
                ':ofsset' => $ofsset,  
                ':gender' => $gender,  
                ':name' => "%$filter->name%"
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
    
    
    
    public static function getUserInfoFromManagement($id){
        $query = "
            SELECT ui.id, u.email, ui.height, ui.chest, ui.waist, ui.hips, ui.shoe, ui.hair, ui.eye,
            (
                SELECT mc.short
                FROM model_category mc
                WHERE mc.menu = 'model-management' AND slug = ui.gender
            ) AS short
            FROM user_info ui
            LEFT JOIN `user` u ON u.id = ui.user_id
            WHERE ui.id = :id
        ";
        
        return Yii::$app->db->createCommand($query, [':id'=>$id])->queryOne();
    }
    
    public static function getNextLastUser($info_user_id, $gender = ''){
        Yii::$app->db->createCommand("
            SET @i := 0;
            SET @key := null;
        ")->execute();
        
        $query = "

            SELECT us.* 
            FROM (
                SELECT ui.gender, @i := (@i + 1) AS 'i', IF(mm.info_user_id = :info_user_id, @key :=@i, null) AS 'resut', mm.info_user_id
                FROM model_management mm
                LEFT JOIN user_info ui ON ui.id =mm.info_user_id
                WHERE IF(:gender = '', true, ui.gender = :gender)
                AND mm.active = '1'
                ORDER BY mm.created_at DESC
            ) as `us`
            WHERE us.i IN (@key-1, @key, @key+1)
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':gender' => $gender,
            ':info_user_id' => $info_user_id, // 20
        ])->queryAll(); 
        
        $key = false;
        $result = [
            'gender' => NULL,
            'next_id' => false,
            'prev_id' => false,
        ];
        
        
        foreach ($request as $value) {
            if($key === false && $value['resut'] === null){
                $result['next_id'] = $value['info_user_id'];
            }elseif($key === false && $value['resut'] != null){
                $key = true;
            }elseif($key === true && $value['resut'] === null){
                $result['prev_id'] = $value['info_user_id'];
            }
            
            $result['gender'] = $value['gender'];
        }
        
        return $result;
    }
}
