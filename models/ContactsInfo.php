<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contacts_info".
 *
 * @property int $id
 * @property string $title
 * @property string $post
 * @property string $mobile
 * @property string $email
 * @property string $published
 */
class ContactsInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contacts_info';
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
            [['title'], 'required'],
            [['published'], 'string'],
            [['title', 'post'], 'string', 'max' => 50],
//            [['mobile', 'email'], 'string', 'max' => 255],
            [['mobile', 'email'], 'safe']
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
            'post' => 'Post',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'published' => 'Published',
        ];
    }
    
    public function afterFind(){
        
        $this->mobile = json_decode($this->mobile);
        $this->email = json_decode($this->email);

        parent::afterFind();
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

            $this->mobile = (!empty($this->mobile)) ? json_encode($this->mobile) : '[]';
            $this->email = (!empty($this->email)) ? json_encode($this->email) : '[]';
            
            return true;
        }
        return false;
    }

}
