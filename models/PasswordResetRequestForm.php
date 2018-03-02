<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'app\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::find()
            ->select(['u.*', 'ui.name'])
            ->from('user u')
            ->leftJoin('user_info ui', 'ui.user_id  = u.id')
            ->where([
                'u.status' => User::STATUS_ACTIVE,
                'u.email' => $this->email,
            ])->one();
        
        if (!$user) {return false;}
        
        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {return false;}
        }
        
        // текст письма
        $message = Yii::$app->controller->renderPartial('@app/mail/passwordResetToken-html', ['user'=>$user]);
        
        // тема письма
        $subject = 'Password reset for ' . $user->name;

        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers[]  = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Дополнительные заголовки
        $headers[] = "To: {$user->name} <{$this->email}>";
        $headers[] = "From: Password reset for <".Yii::$app->params['supportEmail'].">";
        $headers[] = "Cc: ".Yii::$app->params['supportEmail'];
        $headers[] = "Bcc: ".Yii::$app->params['supportEmail'];

        // Отправляем
        return mail($this->email, $subject, $message, implode("\r\n", $headers));
    }
}
