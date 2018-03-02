<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property string $url
 * @property string $text
 * @property string $description
 *
 * @property BookFields[] $bookFields
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['description'], 'string'],
            [['title', 'text'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 100], 
            [['title'], 'unique'], 
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
            'url' => 'Url',
            'text' => 'Text',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookFields()
    {
        return $this->hasMany(BookFields::className(), ['book_id' => 'id']);
    }
    
    public function beforeValidate() {
       if(parent::beforeValidate()){
            if ($this->url == ''){
                $this->url = \app\components\TranslitFilter::translitUrl($this->title);
            }
            return true;
        }else
            return false;
    }
    
        /**
     * Вертає список категорій
     * @return type
     */
    public static function getBooksId(){
        $query = self::find()
                ->select(['id','title'])
                ->orderBy('title')
                ->asArray();
        return ArrayHelper::map($query->all(), 'id', 'title');
    }
    
    public static function getBooksUrl(){
        $query = self::find()
                ->select(['url','title'])
                ->orderBy('title')
                ->asArray();
        
        $result = [];
        foreach ($query->all() as $value) {
            $result[Url::toRoute(['/site/book', 'action'=>$value['url']])] = $value['title'];
        }
        
        return $result;
    }
}
