<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "casting_user".
 *
 * @property int $id
 * @property int $casting_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string $viewed
 *
 * @property Casting $casting
 */
class CastingUser extends \yii\db\ActiveRecord
{
    public $reCaptcha;
    public $title;
    public $casting_name;
    public $category;
    public $category_id;
    

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
        return 'casting_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            
            [['casting_id', 'name', 'email', 'reCaptcha'], 'required', 'except'=>['admin']],
            [['casting_id', 'info_user_id'], 'integer'],
            [['viewed'], 'string'],
            [['name', 'email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['message'], 'string', 'max' => 255],
            [['casting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Casting::className(), 'targetAttribute' => ['casting_id' => 'id']],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']],
//            [['reCaptcha'], 
//                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 
//                'secret' => '6LefYDAUAAAAAB3DS1QKXjTT5TyGuogFapF1mG-L', 
//                'uncheckedMessage' => 'Please confirm that you are not a bot.'
//            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'casting_id' => 'Category ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'message' => 'Message',
            'viewed' => 'Viewed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCasting()
    {
        return $this->hasOne(Casting::className(), ['id' => 'casting_id']);
    }
    
    public static function getListCastings(){
        $query ="
            SELECT id, title
            FROM casting
        ";
        
        $request = Yii::$app->db->createCommand($query);
        
        return ArrayHelper::map($request->queryAll(), 'id', 'title');
        
    }
    
    
    public static function gatInfoFromEmail($email){
        $query ="
            SELECT cu.viewed, c.src, c.title, c.gender, c.casting_date, c.time_from, c.time_to, c.job_date, c.location, c.booker_name, c.bookers_number, c.details
            FROM casting_user cu
            LEFT JOIN casting c ON c.id = cu.casting_id
            WHERE cu.email = :email
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':email'=>$email
        ])->queryAll();
    }
    
    public static function getCastingsFromUserId($user){
        $query = "
                SELECT cu.viewed, c.*,
                (
                    SELECT COUNT(id)
                    FROM casting_user
                    WHERE casting_id = cu.casting_id
                ) AS 'count'

                FROM casting_user cu
                LEFT JOIN  `user_info` ui  ON cu.email = ui.email
                LEFT JOIN casting c ON c.id = cu.casting_id
                WHERE ui.`user_id` = :user_id
                OR cu.email = :email
                ORDER BY c.casting_date DESC
            ";
        
        $list = Yii::$app->db->createCommand($query, [
            ':user_id'=>$user['id'],
            ':email'=>$user['email'],
        ])->queryAll();
        
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
    
    public static function getEmailFromID($listID){
        $listID = implode(',', $listID);
        
        $query = "
            SELECT id, `name`, email
            FROM casting_user
            WHERE id IN ({$listID})
            GROUP BY email
        ";
            
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[$value['id']] = [
                        'name' => $value['name'],
                        'email' => $value['email']
                    ];
        }
        
        return $result;
    }


    
}
