<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SendEmailMessage extends Model
{
    public $theme;
    public $message;
    public $friend_id;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['theme', 'message'], 'required'],
            [['theme'], 'string', 'max' => 255],
            [['friend_id'], 'integer'],
            [['message'], 'string'],
        ];
    }

  
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser($id)
    {
        if ($this->_user === false) {
            $this->_user = User::findOne($id);
        }

        return $this->_user;
    }
    
    public function send(){
        $query = "
            SELECT
                CONCAT(COALESCE(u.name,''), ' ', COALESCE(u.surname,'')) AS 'FromName',
                CONCAT(COALESCE(t.name,''), ' ', COALESCE(t.surname,'')) AS 'ToName',
                u.email AS 'from',
                t.email AS 'to'
            FROM `user` u
            LEFT JOIN `user` t ON t.id = :friend_id  
            WHERE u.id = :user_id
        ";
        
        $data = \Yii::$app->db->createCommand($query, [
            ':user_id' => (int) \Yii::$app->user->id,
            ':friend_id' => (int) $this->friend_id,
        ])->queryOne();
                
        return $this->sentMail($data['from'], $data['to'], $this->theme, $this->message);
    }
    
    
    public function sentMail($fromemai, $email, $subject, $message) {
        $headers = "MIME-Version: 1.0\r\nFrom: $fromemai\r\nReply-To: $fromemai\r\nContent-Type: text/html; charset=utf-8";
        $message = wordwrap($message, 70);
        $message = str_replace("\n.", "\n..", $message);

        return  mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
    }
}
