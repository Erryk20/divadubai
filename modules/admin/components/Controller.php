<?php
namespace app\modules\admin\components;

use Yii;

class Controller extends \yii\web\Controller {
    
    public $user = null;
    
    public function beforeAction($action) {
        return parent::beforeAction($action);
    }
    
    /**
     * @inheritdoc
     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => \yii\filters\AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        // Пропускаєм тільки зареєстрованих користувачів
//                        'roles' => ['@'],
//                        // Пропускаєм тільки користавачів зі статусом адмін
//                        'matchCallback' => function ($rule, $action) {
//                            return Yii::$app->user->identity->role == 2;
//                        }
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => \yii\filters\VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post'],
//                    'bulk-delete' => ['post'],
//                ],
//            ],
//        ];
//    }
    
    public function getUser(){
                
        
        if($this->user == null){
            $user_id = Yii::$app->user->id;
            $this->user = \app\models\User::getUser($user_id);
        }
        return $this->user;
    }


    public function sentMail($email, $subject, $message) {
        $adminEmail = Yii::$app->params['adminEmail'];
        $headers = "MIME-Version: 1.0\r\nFrom: $adminEmail\r\nReply-To: $adminEmail\r\nContent-Type: text/html; charset=utf-8";
        $message = wordwrap($message, 70);
        $message = str_replace("\n.", "\n..", $message);
        
        return  mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
    }
}
