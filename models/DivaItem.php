<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diva_item".
 *
 * @property int $id
 * @property int $diva_media_id
 * @property string $type
 * @property string $item
 *
 * @property DivaMedia $divaMedia
 */
class DivaItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diva_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['diva_media_id', 'type', 'item'], 'required'],
            [['diva_media_id'], 'integer'],
            [['type'], 'string', 'max' => 20],
            [['item'], 'string', 'max' => 50],
            [['diva_media_id'], 'exist', 'skipOnError' => true, 'targetClass' => DivaMedia::className(), 'targetAttribute' => ['diva_media_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diva_media_id' => 'Diva Media ID',
            'type' => 'Type',
            'item' => 'Item',
        ];
    }
    
    public static function itemAlias($type, $code = NULL) {
        $_items = [
            'type' => [
                'image' => 'Image',
                'video' => 'Video',
            ],
        ];
        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDivaMedia()
    {
        return $this->hasOne(DivaMedia::className(), ['id' => 'diva_media_id']);
    }
}
