<?php
namespace app\models;


use Yii;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $phone
 * @property string $balance
 * @property string $surname
 * @property integer $status
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * 
 * @property Cities $city 
 * @property Countries $country 
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_MODERATION = 5;

    public $_password;
    public $password;
    public $confirm_password;
    public $authKey;
    public $profile;
    public $file;
    public $type;
    public $category_id;
    public $name;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    
     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'safe', 'on'=>['admin']],
            [['auth_key', 'password_hash', 'email'], 'required', 'except'=>['admin']],
            [['status', 'category_id'], 'integer'],
            ['file', 'image', 'minWidth' => 187, 'minHeight' => 217, 'extensions' => 'jpg, gif, png'],
            [['availability'], 'string'],

            
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['role', 'type'], 'string'],
            ['email', 'trim'],
            ['email', 'email'],
            [['email'], 'unique', 'except' => 'forgot-password'],
            [['email'], 'isEmail', 'on'=>['forgot-password']],
            
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This email address has already been taken.')],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'This username has already been taken.')],
            ['password', 'string', 'max'=>20],
            [['password_reset_token'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_MODERATION]],
            ['_password', 'compare', 'compareAttribute' => 'password', 'on'=>['change-psw-auth-key']],
            
            
            ['password', function ($attribute, $params) {
                    if (!$this->validatePassword($this->password)) {
                        $this->addError($attribute, 'Incorrect password.');
                    }else{
                        $this->setPassword($this->_password);
                    }
                }, 'on'=>['reset-password']
            ],  
            [['_password', 'password', 'confirm_password'], 'required', 'on'=>'reset-password'],
            ['confirm_password', 'compare', 'compareAttribute' => '_password', 'on'=>'reset-password'],
            
            
            
            [['password', '_password'], 'required', 'on'=>['change-psw-auth-key']],
            
//            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
//            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }
    
    public function scenarios() {
        return [
            'forgot-password'   => ['email'],
            'admin'             => ['email', 'type', 'category_id', 'city_id', 'country_id', 'phone', 'username', 'surname', 'password', 'email', 'name', 'status', 'role'],
            'registration'      => ['name', 'surname', 'password', 'email', 'username'],
            
//            'reset-password'=>['password_hash', 'password_reset_token'],
            
            'change-psw-auth-key' => ['password', '_password'],
            'signup' => ['password', 'email', 'username'],
            'email-password' => ['password', 'email'],
            
            'reset-password' => ['password', '_password', 'confirm_password'],
            
            'role' => ['role'],
            'status' => ['status'],
            'type' => ['type'],
        ] + parent::scenarios();
    }
    
    public function isPhone($attribute){
        if(!preg_match("/^[\d ]{7,20}$/", $this->$attribute, $result)){
            $this->addError($attribute, 'The phone must be between 7 and 20 characters.');
            return TRUE;
        }  else
            return TRUE;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
             '_password' => Yii::t('app', 'Confirm password'),
            'password' => Yii::t('app', 'Password'),
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'city_id' => Yii::t('app', 'City'),
            'country_id' => Yii::t('app', 'Country'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'phone' => Yii::t('app', 'Phone'),
            'name' => Yii::t('app', 'First Name'),
            'surname' => Yii::t('app', 'Last Name'),
            'status' => Yii::t('app', 'Status'),
            'role' => Yii::t('app', 'Role'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    public static function getAvailability($type = false){
        $list = [
            1 =>'Available',
            0 =>'Not Available',
            -1 =>'Blacklisted',
        ];
        
        if($type === false){
            return $list;
        }else{
            return isset($list[$type]) ? $list[$type] : null;
        }
    }
    
    public function getCountry(){
       return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
    
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        
        if($this->type || $this->category_id){
            $model = UserInfo::findOne($this->id);
            
            if($model === null){
                $model = new UserInfo(['scenario'=>'admin']);
                $model->user_id = $this->id;
            }
            $model->type = $this->type;
            $model->category_id = $this->category_id;
            $model->scenario = 'admin';
            
            $model->save();
        }
    }
    
    public static function itemAlias($type, $code = NULL) {
        $_items = [
            'status' => [
                self::STATUS_MODERATION => Yii::t('app', 'Moderation'),
                self::STATUS_ACTIVE => Yii::t('app', 'Active'),
                self::STATUS_DELETED => Yii::t('app', 'Deleted'),
            ],
            'role' => [
                'user' => 'Standard User',
                'admin' => 'Super User',
                'limited' => 'Limited User',
            ],
        ];
        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
    
    
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id){
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        
        $model = static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
                ]);
//        $model->scenario = 'reset-password';

        return $model;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }


        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
//        vd($username, false);
        
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    
    public static function findByEmail($email) {
        return static::findOne(['email' => $email, 'status' => [self::STATUS_ACTIVE, self::STATUS_MODERATION]]);
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
            'authKey' => md5($id),
            'profile' => $service->getAttributes(),
        );
        
        
        
        $attributes['profile']['service'] = $service->getServiceName();
     
        Yii::$app->getSession()->set('user-'.$id, $attributes);
        return new self($attributes);
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function isEmail() {
        $user = self::findOne(['email' => $this->email]);
        if (!$user) {
            $this->addError('email', 'This email does not exist.');
            return false;
        }
        return true;
    }
    
    
    /**
     * Вертає весь список користувачів
     * @return type
     */
    public static function getUsersIdAll(){
        $query = self::find()
                ->orderBy('username')
                ->where(['not', ['username'=>'']])
                ->asArray();
        
        return \yii\helpers\ArrayHelper::map($query->all(), 'id', 'username');
    }
    
    
        
    /**
     * Вертає весь список користувачів
     * @return type
     */
    public static function getUserForId($id){
        $query = self::find()->select('username')->where(['id' => $id]);
        
        return $query->scalar();
    }
    
    public static function updateUserLastVisit($user_id){
        return Yii::$app->db->createCommand(
            'UPDATE user SET lastvisittime = :time WHERE id = :user_id', 
            [
                ':user_id'=> $user_id,
                ':time'=> time()
            ])->execute();
    }
    
    
    
    public static function getAllUsersForGroup($q, $limit){
        $query = "
            SELECT id, email,
                CONCAT(COALESCE(name,''), ' ', COALESCE(surname,'')) AS 'text', 
                CONCAT('images/user-logo/', logo) AS url
            FROM `user`
            WHERE `name` LIKE :q OR `email` LIKE :q
            LIMIT :limit
        ";
        
        $result = \Yii::$app->db->createCommand($query, [
            ':limit' => (int)$limit,
            ':q' => "$q%",
        ])->queryAll();

        return $result;
    }
    
    public static function getUserName($user_id){
        $query = "
            SELECT 
                TRIM(CONCAT(COALESCE(u.`name`,''), ' ', COALESCE(u.`surname`,''))) AS 'user',
                '/user/personal' AS 'pre_url',
                u.id
            FROM `user` u
            WHERE u.id = :user_id
        ";
        
        return \Yii::$app->db->createCommand($query, [
            ':user_id' => $user_id,
        ])->queryOne();
    }
    
    
    public static function getAllModels($children, $type = '', $limit, $offset = 0){
        $query = "
            SELECT '/site/model' AS 'pre_url', 
                c2.url AS 'parent', 
                c.url AS 'children', 
                user_id, username,
                ui.`name`,
                CONCAT('images/users/',  IFNULL(logo, 'logo.png')) AS 'src'
            FROM `user` u
            LEFT JOIN user_info ui ON ui.user_id = u.id
            LEFT JOIN categories c ON c.id = ui.category_id
            LEFT JOIN categories c2 ON c2.id = c.parent_id
            WHERE u.`role` = 'model'
            AND c.url = :children
            AND IF(:type = '', true, ui.type = :type)
            ORDER BY u.updated_at DESC
            LIMIT :offset, :limit
        ";
        
        return \Yii::$app->db->createCommand($query, [
            ':type' => $type,
            ':limit'=>$limit, 
            ':offset'=>$offset,
            ':children'=>$children,
        ])->queryAll();
    }
    
    
    public static function getUser($user_id){
        $query = "
            SELECT u.username, u.email, u.logo, u.status, u.`role`, u.lastvisittime, ui.`name`, '' AS prepend_phone,  ui.phone
            FROM `user` u
            LEFT JOIN user_info ui ON ui.user_id = u.id
            WHERE u.id = :user_id
        ";
        
        $result = \Yii::$app->db->createCommand($query, [
            ':user_id' => $user_id,
        ])->queryOne();
        

        if(!empty($result['phone'])){
            $phone = explode('/',$result['phone']);
            if(isset($phone[1])){
                $result['prepend_phone'] = $phone[0];
                $result['phone'] = $phone[1];
            }else{
                $result['phone'] = $phone[0];
            }
        }
        return $result;
    }
}
