<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_media".
 *
 * @property int $id
 * @property int $target_id
 * @property string $type
 * @property string $image
 * @property string $video
 * @property string $source
 */
class ContentMedia extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type'], 'required'],
            [['id'], 'integer'],
            [['source'], 'string'],
            [['type'], 'string', 'max' => 50],
            [['image'], 'string', 'max' => 100],
            [['video'], 'string', 'max' => 20],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'target_id' => 'Target ID',
            'type' => 'Type',
            'image' => 'Image',
            'video' => 'Video',
            'source' => 'Source',
        ];
    }
}
