<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "main_list".
 *
 * @property int $id
 * @property int $link
 * @property string $name
 * @property string $src
 * @property int $order
 *
 * @property ModelCategory $category
 */
class MainList extends \yii\db\ActiveRecord
{
    public $file;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'main_list';
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
            [['link', 'name'], 'required'],
            [['order'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['link', 'src'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'name' => 'Name',
            'src' => 'Src',
            'order' => 'Order',
        ];
    }
    
    
    public static function getListMainLink(){
        $query ="
            SELECT `link`, `name`, CONCAT('images/main-list/',src) AS 'src'
            FROM main_list
            ORDER BY `order`
        ";
        return Yii::$app->db->createCommand($query)->queryAll();
    }
}
