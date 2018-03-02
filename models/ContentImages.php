<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_images".
 *
 * @property int $id
 * @property int $content_id
 * @property string $src
 * @property int $title
 * @property string $slug
 *
 * @property Content $content
 */
class ContentImages extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id'], 'required'],
            [['content_id'], 'integer'],
            [['src', 'title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 255],
            [['content_id'], 'exist', 'skipOnError' => true, 'targetClass' => Content::className(), 'targetAttribute' => ['content_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => 'Content ID',
            'src' => 'Src',
            'slug' => 'Link',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(Content::className(), ['id' => 'content_id']);
    }
    
    public static function getImagesFromContent($contentId){
        $query = "
            SELECT CONCAT('/images/content-images/', src) AS 'src', title
            FROM content_images 
            WHERE content_id = :content_id
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':content_id' => $contentId
        ])->queryAll();
        
    }
    
    public static function getListFromContentId($contentId){
        $query = "
            SELECT src, title, slug
            FROM content_images
            WHERE content_id = :content_id
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':content_id' => $contentId
        ])->queryAll();
        
    }
}
