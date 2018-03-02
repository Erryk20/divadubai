<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "favourite".
 *
 * @property int $id
 * @property int $user_id
 * @property int $info_user_id
 *
 * @property UserInfo $infoUser
 * @property User $user
 */
class Favourite extends \yii\db\ActiveRecord
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
        return 'favourite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'info_user_id'], 'required'],
            [['user_id', 'info_user_id'], 'integer'],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    
    public static function countItemsUser($q, $user_id){
        $query = "
            SELECT COUNT(f.id)
            FROM favourite f
            LEFT JOIN user_info ui ON ui.id = f.info_user_id
            WHERE f.user_id = :user_id
            AND IF(''= :q, true, (ui.name LIKE :q))
        ";
        
        return (int)\Yii::$app->db->createCommand($query, [
            ':user_id' => $user_id,
            ":q" => $q ? "%{$q}%" : '',
        ])->queryScalar();
    }
    
    public static function getListItemsUser($q ='', $user_id, $limit = 20, $offset = 0) {
        $query = "
            SELECT f.info_user_id, f.created_at, ui.*, f.id, 
            (
                SELECT src
                FROM user_media
                WHERE `type` = 'image'
                AND info_user_id = f.info_user_id
                ORDER BY `order`
                LIMIT 1
            ) AS logo
            FROM favourite f 
            LEFT JOIN user_info ui ON ui.id = f.info_user_id
            WHERE f.user_id  = :user_id
            AND IF(''= :q, true, (ui.name LIKE :q))
            LIMIT :offset, :limit
        ";
        
        $result = Yii::$app->db->createCommand($query, [
            ":user_id" => $user_id,
            ":limit" => (int)$limit,
            ":offset" => (int)$offset,
            ":q" => $q ? "%{$q}%" : '',
        ])->queryAll();
        
        $models = [];
        foreach ($result as $key => $value) {
            $models[$key] = $value;
            
            $phone = $models[$key]['phone'];
            $phone2 = $models[$key]['phone2'];
            $models[$key]['phone'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+(\1) \2 \3 \4 \5',
                (string)$phone
            );
            $models[$key]['phone_html'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+\1\2\3\4\5',
                (string)$phone
            );
            
            
            $models[$key]['phone2'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+(\1) \2 \3 \4 \5',
                (string)$models[$key]['phone2']
            );
            $models[$key]['phone2_html'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+\1\2\3\4\5',
                (string)$phone2
            );
        }
        
        return $models;
    }
    
    
    
    public static function getListItems($favourites, $limit = 20, $offset = 0) {
        if($favourites != null){
            $favourites = implode(',', $favourites);
        }
        
        $query = "
            SELECT ui.id AS info_user_id, UNIX_TIMESTAMP() AS created_at, ui.*, ui.id, 
            (
                SELECT src
                FROM user_media
                WHERE `type` = 'image'
                AND info_user_id = ui.id
                ORDER BY `order`
                LIMIT 1
            ) AS logo
            FROM user_info ui
            WHERE ui.id IN ({$favourites})
            LIMIT :offset, :limit
        ";
        
        $result = $favourites ? Yii::$app->db->createCommand($query, [
            ":limit" => (int)$limit,
            ":offset" => (int)$offset,
        ])->queryAll() : [];
        
        $models = [];
        foreach ($result as $key => $value) {
            $models[$key] = $value;
            
            $phone = $models[$key]['phone'];
            $phone2 = $models[$key]['phone2'];
            $models[$key]['phone'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+(\1) \2 \3 \4 \5',
                (string)$phone
            );
            $models[$key]['phone_html'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+\1\2\3\4\5',
                (string)$phone
            );
            
            
            $models[$key]['phone2'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+(\1) \2 \3 \4 \5',
                (string)$models[$key]['phone2']
            );
            $models[$key]['phone2_html'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+\1\2\3\4\5',
                (string)$phone2
            );
        }
        
        return $models;
    }
}
