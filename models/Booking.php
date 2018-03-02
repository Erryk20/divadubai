<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "booking".
 *
 * @property int $id
 * @property string $name
 * @property string $client_name
 * @property int $client_id
 * @property string $requirement
 * @property string $booked_as
 * @property string $usage_for
 * @property string $booker_name
 * @property string $period
 * @property string $contact_number
 * @property string $date_of_shoot
 * @property string $job_number
 * @property string $location
 * @property string $amount
 * @property string $user_name
 * @property string $ac_name
 * @property string $ac_number
 * @property string $bank_name
 * @property string $signature
 * @property string $last_date
 * @property string $act_total
 * @property string $cheque
 * @property int $model_id
 * @property string $type
 * @property string $from_date
 * @property string $to_date
 * @property string $email
 * @property int $status
 */
class Booking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [
//                [
//                    'name', 'client_name', 'requirement', 'booked_as', 
//                    'usage_for', 'booker_name', 'period', 'contact_number', 
//                    'date_of_shoot', 'job_number', 'location', 'amount', 
//                    'bank_name', 'last_date', 'act_total', 
//                    'cheque', 'model_id', 'from_date', 
//                    'to_date', 'email'], 
//                'required'
//            ],
            [['user_name', 'ac_number'], 'required', 'on'=>['site']],
            
            [['id', 'client_id', 'model_id', 'status'], 'integer'],
            [['name', 'client_name', 'requirement', 'booked_as', 'usage_for', 'booker_name', 'period', 'contact_number', 'date_of_shoot', 'job_number', 'location', 'amount', 'user_name', 'ac_name', 'ac_number', 'bank_name', 'signature', 'last_date', 'act_total', 'cheque', 'type', 'from_date', 'to_date', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'booked_as' => 'Booked As',
            'booker_name' => 'Booker Name',
            'name' => 'Talent Name',
            'amount' => 'Amount',
            'act_total' => 'Act Total',
            'cheque' => 'Cheque',
            'bank_name' => 'Bank',
            'last_date' => 'Date',
            'contact_number' => 'Mobile Number',
            'model_id' => 'Model ID',
            'job_number' => 'Job Number',
            'usage_for' => 'Usage',
            'period' => 'Period',
            'client_name' => 'Client Name',
            'from_date' => 'From',
            'to_date' => 'To',
            'date_of_shoot' => 'Date Of Shoot',
            'location' => 'Location',
            'email' => 'Email',
            'requirement' => 'Requirement/Wardrobe',
            'type' => 'Type',
            
            'client_id' => 'Client ID',
            'user_name' => 'User Name',
            'ac_name' => 'Ac Name',
            'ac_number' => 'Ac Number',
            'signature' => 'Signature',
            'status' => 'Status',
        ];
    }
    
    public static function getAvailability($type, $item = false){
        $list = [
            'status' => [
                2 =>'1',
                1 =>'0',
                0 =>'-1',
            ]
        ];
        
        if($item === false){
            return isset($list[$type]) ? $list[$type] : [];
        }else{
            return isset($list[$type][$item]) ? $list[$type][$item] : null;
        }
    }
}


//Yii::$app->db->createCommand()->insert('booking', [
//      'booked_as'     => job_name,
//      'booker_name'   => booker,     
//      'name'          => talent_name,
//      'amount'        => amount,
//      'act_total'     => act,
//      'cheque'        => cheque,
//      'bank_name'     => bank,
//      'last_date'     => date,
//      'contact_number'=> mobile,
//      'model_id'      => model_id,
//      'job_number'    => job_no,
//      'usage_for'     => usage,
//      'period'        => period,
//      'client_name'   => client_name,
//      'from_date'     => from,
//      'to_date'       => to,
//      'date_of_shoot' => dos,
//      'location'      => location,
//      'email'         => email,
//      'requirement'   => ward,
//      'type'          => category_type,
//])->execute();
