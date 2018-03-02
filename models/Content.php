<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content".
 *
 * @property int $target_id
 * @property string $type
 * @property string $top
 * @property string $blockquote
 * @property string $description
 */
class Content extends \yii\db\ActiveRecord
{
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['target_id', 'type'], 'required'],
            [['target_id'], 'integer'],
                [['type', 'top', 'blockquote', 'description', 'title', 'block_1', 'block_2', 'block_3'], 'string'],
            [['target_id', 'type'], 'unique', 'targetAttribute' => ['target_id', 'type']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'target_id' => 'Target ID',
            'type' => 'Type',
            'top' => 'Top',
            'blockquote' => 'Blockquote',
            'description' => 'Description',
            'title' => 'Title',
            'block_1' => 'Block 1',
            'block_2' => 'Block 2',
            'block_3' => 'Block 3',
        ];
    }
    
    public static function getIdContentFromType($target_id, $type){
        $query ="
            SELECT id
            FROM content
            WHERE target_id = :target_id AND type = :type
        ";
        return (int) Yii::$app->db->createCommand($query, [
            ':target_id'=>$target_id,
            ':type'=>$type,
        ])->queryScalar();
    }
}
