<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "favorite_casting".
 *
 * @property int $id
 * @property int $user_id
 * @property int $casting_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Casting $casting
 * @property User $user
 */
class FavoriteCasting extends \yii\db\ActiveRecord
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
        return 'favorite_casting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'casting_id'], 'required'],
            [['user_id', 'casting_id', 'created_at', 'updated_at'], 'integer'],
            [['casting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Casting::className(), 'targetAttribute' => ['casting_id' => 'id']],
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
            'casting_id' => 'Casting ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCasting()
    {
        return $this->hasOne(Casting::className(), ['id' => 'casting_id']);
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
            FROM favorite_casting f
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
            SELECT f.info_user_id, f.created_at, ui.*, 
            (
                SELECT src
                FROM user_media
                WHERE `type` = 'image'
                AND info_user_id = f.info_user_id
                ORDER BY `order`
                LIMIT 1
            ) AS logo
            FROM favorite_casting f 
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
    
    
    public static function getCastingsFromUserId($user_id){
        $query = "
                SELECT c.*,
                (
                    SELECT COUNT(id)
                    FROM casting_user
                    WHERE casting_id = fc.casting_id
                ) AS 'count'
                FROM favorite_casting fc
                LEFT JOIN casting c ON c.id = fc.casting_id
                WHERE fc.user_id = :user_id
                ORDER BY c.casting_date DESC
            ";
        
        $list = Yii::$app->db->createCommand($query, [
            ':user_id' => $user_id
        ])->queryAll();
        
        $hour = 60*60;
        $dey = 24*60*60;
        $week = 7*24*60*60;
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$key] = $value;
            
            $left = $value['casting_date'] - time();
            $result[$key]['finished'] = 'finished';
            
            if($left < 0){
                $result[$key]['left'] = 'Finished';
            }else{
                $result[$key]['finished'] = '';
                switch ($left > $week){
                    case true : $result[$key]['left'] = round($left/$week)." week left"; break;
                    case false : $result[$key]['left'] = round($left/$dey)." day left"; break;
                }
            }
        }
        return $result;
    }
    
}
