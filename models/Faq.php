<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faq".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $published
 */
class Faq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faq';
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
            [['title', 'description'], 'required'],
            [['description', 'published'], 'string'],
            [['title'], 'string', 'max' => 255],
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
            'published' => 'Published',
        ];
    }
    
    public static function listFAQ(){
        $query = "
            SELECT id, title, description
            FROM faq
            WHERE published = :published
            ORDER BY `order` ASC
        ";
        
        $list = Yii::$app->db->createCommand($query, [':published' => 1])->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$key%3][] = $value;
        }
        
       return $result;
    }
}
