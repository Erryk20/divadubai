<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_fields".
 *
 * @property int $id
 * @property int $book_id
 * @property string $label
 * @property string $type
 * @property string $require
 * @property int $order
 *
 * @property Book $book
 */
class BookFields extends \yii\db\ActiveRecord
{
    public $title;
    public $url;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_fields';
    }
    
    public function behaviors()
    {
        return [
            'sortable' => [
                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reCaptcha'], 'required', 'on'=>['site']],
            [['book_id', 'label', 'type'], 'required', 'except'=>['site']],
            
            [['book_id', 'order'], 'integer'],
            [['require'], 'string'], 
            [['label'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 10],
            [['book_id', 'label'], 'unique', 'targetAttribute' => ['book_id', 'label']], 
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
//            [['reCaptcha'], 
//                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 
//                'secret' => '6LefYDAUAAAAAB3DS1QKXjTT5TyGuogFapF1mG-L', 
//                'uncheckedMessage' => 'Please confirm that you are not a bot.'
//            ]
        ];
    }
    
    public function scenarios() {
        return [
            'admin' => ['book_id', 'type', 'label'],
        ] + parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'label' => 'Label',
            'type' => 'Type',
            'require' => 'Require',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
    
    
    public static function getBooksFieldAction($action) {
        $query = "
            SELECT bf.id, bf.label, bf.`type`, bf.`require`, '' AS 'value'
            FROM book_fields bf
            LEFT JOIN book b ON b.id = bf.book_id
            WHERE b.url = :action
            ORDER BY bf.`order` ASC
        ";

        $result = \Yii::$app->db->createCommand($query, [
            ':action' => $action,
        ])->queryAll();
        
        $request = Yii::$app->request->post();
        if(!empty($request)){
            foreach ($result as $key => $value) {
                $result[$key]['value'] =  $request[$value['id']];
            }
        }
        return $result;
    }
    
    public static function itemAlias($type, $code = NULL) {
        $_items = [
            'type' => [
                'text' => 'Text',
                'email' => 'Email',
                'tel' => 'Tel',
            ],
        ];
        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
    
//    public function setPost($fields){
//        $request = Yii::$app->request->post();
//        
//        foreach ($fields as $key => $value) {
//            $fields[$key]['value'] = $request[$key+1];
//        }
//        
//        return $fields;
//    }

}
