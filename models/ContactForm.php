<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $reCaptcha;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'phone', 'message', 'reCaptcha'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
//            [['reCaptcha'], 
//                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 
//                'secret' => '6LefYDAUAAAAAB3DS1QKXjTT5TyGuogFapF1mG-L', 
//                'uncheckedMessage' => 'Please confirm that you are not a bot.'
//            ]
        ];
    }

  
    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject('Message from site divadubai')
                ->setTextBody($this->message)
                ->send();

            return true;
        }
        return false;
    }
    
    public function sentMail(){
        // несколько получателей
        $to = 'erryk500@gmail.com'; // обратите внимание на запятую

        // тема письма
        $subject = 'Birthday Reminders for August';

        // текст письма
        $message = '
        <html>
        <head>
          <title>Birthday Reminders for August</title>
        </head>
        <body>
          <p>Here are the birthdays upcoming in August!</p>
          <table>
            <tr>
              <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
            </tr>
            <tr>
              <td>Johny</td><td>10th</td><td>August</td><td>1970</td>
            </tr>
            <tr>
              <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
            </tr>
          </table>
        </body>
        </html>
        ';

        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers[]  = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Дополнительные заголовки
        $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
        $headers[] = 'From: Birthday Reminder <birthday@example.com>';
        $headers[] = 'Cc: birthdayarchive@example.com';
        $headers[] = 'Bcc: birthdaycheck@example.com';

        // Отправляем
        return mail($to, $subject, $message, implode("\r\n", $headers));
    }
    
    
    public function sentMailYandex() {
        $adminEmail = Yii::$app->params['adminEmail'];

        $mailSMTP = new \app\components\SendMailSmtpClass('sales@partsnb.ru', 'M9mzf7eq', 'ssl://smtp.yandex.ru', 'Partsnb', $smtp_port = 465, $smtp_charset = "utf-8");
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From: $adminEmail\r\nReply-To: {$this->email}\r\n"; // от кого письмо
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
//        $headers .= "To: {$email}"; 
        return $mailSMTP->send($this->email, 'Message from site divadubai', $this->message, $headers); // отправляем письмо
        // $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Заголовки письма');
    }
}
