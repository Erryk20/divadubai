<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $language
 * @property integer $target_id
 * @property integer $user_id
 * @property integer $parent_id
 * @property string $comment
 * @property integer $sum_ratings
 * @property integer $sum_users
 * @property integer $published
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PostComments $parent
 * @property PostComments[] $postComments
 * @property Posts $post
 * @property User $user
 * @property Language $language0
 */
class Comments extends \yii\db\ActiveRecord
{
    public $name;
    public $email;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }
    
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
            [['target_id', 'user_id', 'comment', 'created_at', 'updated_at'], 'required'],
            [['comment', 'name', 'email'], 'required', 'on'=>['site']],
            [['target_id', 'user_id', 'parent_id', 'sum_ratings', 'sum_users', 'published', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            ['email', 'email'],
            [['language'], 'string', 'max' => 5],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['parent_id' => 'id']],
//            [['target_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['target_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language' => 'short_name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'language' => Yii::t('app', 'Language'),
            'target_id' => Yii::t('app', 'Post ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'comment' => Yii::t('app', 'Comment'),
            'sum_ratings' => Yii::t('app', 'Sum Ratings'),
            'sum_users' => Yii::t('app', 'Sum Users'),
            'published' => Yii::t('app', 'Published'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
        ];
    }
    
    public function scenarios() {
        return [
            'site'=>['comment', 'name', 'email'],
            'site-user'=>['comment'],
        ] + parent::scenarios();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Comments::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostComments()
    {
        return $this->hasMany(Comments::className(), ['parent_id' => 'id']);
    }
    
    

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        //add post to user_togle
        UserToggle::setItem($this->user_id, 'comment', $this->id);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getPost()
//    {
//        return $this->hasOne(Posts::className(), ['id' => 'target_id']);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage0()
    {
        return $this->hasOne(Language::className(), ['short_name' => 'language']);
    }
    
    
    
    
    public static function getCountAllMessages($user_id, $type = 'post'){
        $query = "
            SELECT COUNT(p.id) 
            FROM posts p
            LEFT JOIN comments c ON c.target_id = p.id AND c.published = 1 AND c.type = :type
            WHERE p.user_id = :user_id
            AND c.type = :type
            AND c.published = 1
            AND c.id IS NOT NULL
        ";
        
        return (int) Yii::$app->db->createCommand($query, 
                [
                    ':user_id' => $user_id,
                    ':type' => $type,
                ])->queryScalar();
    }
    
    public static function getAllMessages($user_id, $limit, $offset, $type = 'post'){
        $query = "
            SELECT p.id, 
                CONCAT(COALESCE(u.name,''), ' ', COALESCE(u.surname)) AS 'user', 
                CONCAT('images/user-logo/', IFNULL(u.logo, 'default.png')) AS src,
                c.created_at, c.comment, p.url
            FROM posts p
            LEFT JOIN comments c ON c.target_id = p.id AND c.published = 1 AND c.type = :type
            LEFT JOIN `user` u ON u.id = c.user_id
            WHERE p.user_id = :user_id
            AND c.id IS NOT NULL
            AND c.type = :type
            ORDER BY c.created_at DESC
            LIMIT :offset, :limit 
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':user_id' => $user_id,
            ':type' => $type,
            ':limit' => $limit,
            ':offset' => $offset
        ])->queryAll();
    }
    
    public static function getMassageFromPost($id, $type = 'post'){
        $query = "
            SELECT c.target_id, c.`chain`, p.url
            FROM comments c
            LEFT JOIN posts p ON p.id = c.target_id
            WHERE c.id = :id
            AND c.type = :type
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':id' => $id,
            ':type' => $type,
        ])->queryOne();
    }
            
    public static function getArrayMessages($id, $type, $user_id = null){
        $query = "
            SELECT p.id, p.target_id, chain, p.parent_id, p.comment, 
                IF(u.id = :user_id, 0,1) AS 'is_reply',
                (p.sum_ratings/p.sum_users) AS reting, 
                CONCAT(COALESCE(u.name,'') ,' ', COALESCE(u.surname,'')) AS user,
                CONCAT('images/user-logo/', IFNULL(u.logo, 'default.png')) AS src,
                p.created_at, :type AS type
            FROM comments p
            LEFT JOIN user u ON u.id = p.user_id
            WHERE p.published = 1
            AND p.target_id = :id
            AND p.type = :type
        ";
        
        $result_db = Yii::$app->db->createCommand(
            $query, 
            [
                ':id'=>$id, 
                ':user_id'=> $user_id, 
                ':type'=>$type
            ])->queryAll();
        
        foreach ($result_db as $key => $value) {
            if($value['chain'] != null)  {
                $result_db[$key]['chain'] = json_decode($result_db[$key]['chain']);
            }
        }
        
        $sizableArray = [];
        self::buildVertical($result_db, $sizableArray);
        
        $Htmlcomment .= "<ul class='main_list_comment'>\n\t";
            self::createHtml($sizableArray, $Htmlcomment);
        $Htmlcomment .= "</ul>";
        return $Htmlcomment;
    }
    
    public static function createHtml($sizableArray, &$Htmlcomment){
        foreach ($sizableArray as $value){
            $Htmlcomment .= "\n\t<li data-id='{$value['id']}' >\n\t";
                $Htmlcomment .= Yii::$app->controller->renderPartial('@app/views/blocks/comment', ['value'=>$value]);

                if(isset($value['item'])){
                    $Htmlcomment .= "\n\t<ul class='list_comment'>\n\t\t";
                        self::createHtml($value['item'], $Htmlcomment);
                    $Htmlcomment .= "\n\t</ul>";
                }
            $Htmlcomment .= "\n\t</li>";
        }
    }

        
    public static function buildVertical($inputArray, &$resultArray) {
        foreach ($inputArray as $key => $value) {
            if ($value['parent_id'] != NULL) {
                if (isset($resultArray[$value['parent_id']])) {
                    $resultArray[$value['parent_id']]['item'][$value['id']] = $value;
                } else {
                    $keyStart = array_shift($value['chain']);
                    $keyNext = array_shift($value['chain']);

                    self::buildHorizontal($keyNext, $value, $resultArray[$keyStart]['item']);
                }
            } else {
                $resultArray[$value['id']] = $value;
            }
        }
    }

    public static function buildHorizontal($keyNext, &$value, &$resultArray) {
        if ($resultArray == null) {return;}

        if (isset($resultArray[$value['parent_id']])) {
            $resultArray[$value['parent_id']]['item'][$value['id']] = $value;
        } else {
            if (!empty($value['chain'])) {
                $keyNext2 = array_shift($value['chain']);
            }
            self::buildHorizontal($keyNext2, $value, $resultArray[$keyNext]['item']);
        }
    }
}
