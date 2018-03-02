<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "slider".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $img
 * @property integer $published
 * @property integer $created_at
 * @property integer $updated_at
 */
class Slider extends \yii\db\ActiveRecord
{
    public $select_img;
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
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
            [['title', 'description'], 'required'],
            [['published'], 'string'],
            [['created_at', 'updated_at', 'order'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['img', 'file'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'img' => 'Img',
            'published' => 'Published',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if($this->file){
                $this->img = preg_replace('/\/images\/slider\//', '', $this->file);
            }
            
//            echo "<pre>";
//            print_r($this);
//            echo "</pre>";
//            die();
            return true;
        }
        return false;
    }
    
    
    public static function getList(){
        $query = self::find()
                ->select(['id',"CONCAT('images/slider/', img) AS src", 'order'])
                ->where(['published'=>1])
                ->orderBy('order ASC')
                ->asArray();
        
        return ArrayHelper::map($query->all(), 'id', 'src');
    }
    
    
    
    public static function getAllList(){
        $query = "
            SELECT s.title, s.description, CONCAT('/images/slider/', s.img) AS 'src'
            FROM slider s
            WHERE s.published = '1'
            ORDER BY s.`order` ASC
        ";
        return  \Yii::$app->db->createCommand($query)->queryAll();
    }
    
//    public function setSrc(){
//        if($this->file){
//            
//            $src = preg_replace('/images\/slider\//', "", $this->file);
//            $this->src = $src;
//        }
//    }
}