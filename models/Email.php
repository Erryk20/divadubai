<?php

namespace app\models;

use Yii;
use yii\base\Model;


/**
 * ContactForm is the model behind the contact form.
 */
class Email extends Model
{
    public $subject;
    public $message;
    public $itemsID;
    public $email;
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['subject', 'message'], 'required'],
            [['itemsID'], 'required', 'message' => 'You did not select the sender'],
            
            [['email'], 'required', 'on'=>['profile-send']],
            ['email', 'trim'],
            ['email', 'email'],
            [['subject'], 'string', 'max' => 255],
            [['message'], 'string'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'subject' => 'Subject',
            'message' => 'Message',
        ];
    }
    
    public function setTheme($theme){
        $model = EmailTheme::findOne(['type'=>$theme]);
        
        $this->message = $model ? $model->content : null;
    }
    
    public function sendMessages($type){
        if($this->validate()){
            $listID = json_decode($this->itemsID);
            
            $listEmail = [];
            switch ($type){
                case 'casting'          : $listEmail = CastingUser::getEmailFromID($listID); break;
                case 'user'             : $listEmail = UserInfo::getEmailFromID($listID); break;
                case 'book_fields_user' : $listEmail = BookFieldsUser::getEmailFromID($listID); break;
            }
            
            
            // Для отправки HTML-письма должен быть установлен заголовок Content-type
            $headers[]  = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            
            // Дополнительные заголовки
            $hostName = Yii::$app->request->hostName;
            $headers[] = "From: $hostName";
            
            if($type == 'user'){
                foreach ($listEmail as $id => $email) {
                    $message = self::setMark($id, $this->message);
                    mail($email, $this->subject, $message, implode("\r\n", $headers));
                }
            }elseif($type == 'book_fields_user'){
                foreach ($listEmail as $id => $value) {
                    $message = self::setMarkCast($value['name'], $this->message);
                    mail($value['email'], $this->subject, $message, implode("\r\n", $headers));
                }
            }elseif($type == 'casting'){
                foreach ($listEmail as $id => $value) {
                    $message = self::setMarkCast($value['name'], $this->message);
                    mail($value['email'], $this->subject, $message, implode("\r\n", $headers));
                }
            }
            
            return true;
        }else{
            return false;
        }
    }
    
    
    public static function setMark($user_id, $content){ 
        
        $domen = Yii::$app->getRequest()->hostInfo;
        $hostName = Yii::$app->request->hostName;
        $link = \kartik\helpers\Html::a($hostName, $domen);
        
        $info = \app\models\PDF::getUserInfo($user_id);
        
        // {domen} {link} {fulllName}
        $content = preg_replace("/{domen}/", $hostName, $content);
        $content = preg_replace("/{link}/", $link, $content);
        $content = preg_replace("/{fulllName}/", $info['fulllName'], $content);
        $content = preg_replace("/{category}/", $info['category'], $content);
        
        return $content;
    }
    
    public static function setMarkCast($name, $content){ 
        $content = preg_replace("/{fulllName}/", $name, $content);
        return $content;
    }
    
    
    public static function sendMailBooking($model){
        $query = "SELECT * FROM `email_theme` WHERE `type` = :type";
        $theme = Yii::$app->db->createCommand($query, [':type' => 'booking_mail'])->queryOne();
    
        $subject = $theme['subject'];
        
//        if(Yii::$app->user->isGuest){
            $from = Yii::$app->params['username'];
            $from2 = Yii::$app->params['supportEmail'];
//        }else{
//            $from = Yii::$app->user->identity->username;
//            $from2 = Yii::$app->user->identity->email;
//        }
        
        $content = self::replaseMark('booking_id', $model['id'], $theme['content']);
        
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = "From: '{$from}'<{$from2}>";
        
        mail($model['email'], $subject, $content, implode("\r\n", $headers));
    }
    
    
    public static function setMailCasting($casting, $model){
        $mailTheme = \app\models\EmailTheme::findOne(['type'=>'casting']);
        
        $title = ModelCategory::find()
                ->where(['id'=>$casting['category_id']])
                ->asArray()
                ->select('name')
                ->scalar();
        
        $from = Yii::$app->params['casting'];
        
        $content = $mailTheme['content'];
        $subject = $mailTheme['subject'];
        if($title != null){
            $subject = self::replaseMark('category', $title, $mailTheme['subject']);
            $content = self::replaseMark('category_id', $casting['category_id'], $content);
        }
        
        $content = self::replaseMark('title', $casting['title'], $content);
        $content = self::replaseMark('fee', $casting['fee'], $content);
        $content = self::replaseMark('name', $model->name, $content);
        $content = self::replaseMark('message', $model->message, $content);
        $content = self::replaseMark('mobile', $model->phone, $content);
        $content = self::replaseMark('email', $from, $content);
        
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = "From:{$from}";
        
        mail($model->email, $subject, $content, implode("\r\n", $headers));
    }

    public static function replaseMark($mark, $set, $content){ 
        $content = preg_replace("/{{$mark}}/", $set, $content);
        return $content;
    }
    
    public function sendEmailToContact(){
        if($this->validate(['subject', 'message', 'email'])){
            
            $to = Yii::$app->params['contact'];
            $from = Yii::$app->params['supportEmail'];
        
            $subject = $this->subject;
            $content = "<p><b>{$this->email}</b></p>".$this->message;

            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "From:{$from}";
        
            return mail($to, $subject, $content, implode("\r\n", $headers));
            
        }else{
            return false;
        }
    }

    public function sendEmail($id){
        if(Yii::$app->user->isGuest || !$this->validate(['subject', 'message'])){
            return false;
        }
        
        $user = UserInfo::findOne($id);
        if($user === null){
            return false;
        }
            
        $from = Yii::$app->params['supportEmail'];
        
        
        $subject = $this['subject'];
        $content = $this['message'];
        
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = "From:{$from}";
        
       return mail($user['email'], $subject, $content, implode("\r\n", $headers));
    }
    
    public function sendEmailProfile($id){
        if(!$this->validate(['email', 'subject', 'message'])){
            return false;
        }
        
        $info = \app\models\PDF::getUserInfo($id);
        if($info === null){
            return false;
        }
        
        $domen = Yii::$app->getRequest()->hostInfo;
        
        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
        $message = $this['message'];
        
        $message .= Yii::$app->controller->renderPartial('@app/views/download/pdf-html', [
            'info' => $info,
            'list' => $list,
            'domen' => $domen,
        ]);
        
        $from = Yii::$app->params['supportEmail'];
        
        $subject = $this['subject'];
        
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';
        $headers[] = "From:{$from}";
        
       return mail($this['email'], $subject, $message, implode("\r\n", $headers));
    }
    
  
}