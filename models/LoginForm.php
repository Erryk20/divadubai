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
class LoginForm extends Model
{
    public $email;
    public $username;
    public $password;
    public $rememberMe = true;
    public $usernameOrEmail;
    public $facebook_id;
    public $name;
    public $surname;
    public $authKey;
    public $profile;



    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'usernameOrEmail'], 'required'],
//            [['email'], 'required', 'on'=>['login-site']],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            [['email'], 'email'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    
//    Remember me
      /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'rememberMe' => Yii::t('app', 'Remember me'),
            'usernameOrEmail' => Yii::t('app', 'Username'),
        ];
        
    }
    
    
    public function scenarios() {
        return [
            'login-site' => ['password', 'usernameOrEmail'], // chess
            'forgot-password' => ['email'],
            'social_login' => ['email'],
        ] + parent::scenarios();
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        

        
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if($this->getUser()){
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            }else{
                return 0;
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            if(preg_match("/@/ui", $this->usernameOrEmail, $matches))
                $this->_user = User::findByEmail($this->usernameOrEmail);
            else
                $this->_user = User::findByUsername($this->usernameOrEmail);
        }
        return $this->_user;
    }
    
    /**
     * @param \nodge\eauth\ServiceBase $service
     * @return User
     * @throws ErrorException
     */
    public static function findByEAuth($service) {
        if (!$service->getIsAuthenticated()) {
            throw new ErrorException(Yii::t('app', 'EAuth user should be authenticated before creating identity.'));
        }
                                      
        $id = $service->getServiceName().'-'.$service->getId();
        
        $attributes = array(
            $service->getServiceName().'_id' => $id,
            'name' => $service->getAttribute('name'),
            'surname' => $service->getAttribute('surname'),
            'email' => $service->getAttribute('email'),
            'usernameOrEmail' => $service->getAttribute('email'),
            'authKey' => md5($id),
            'profile' => $service->getAttributes(),
        );
        
        $attributes['profile']['service'] = $service->getServiceName();
        
        Yii::$app->getSession()->set('user-'.$id, $attributes);
        return new self($attributes);
    }
}
