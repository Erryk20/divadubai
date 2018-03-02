<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "casting".
 *
 * @property int $id
 * @property string $title
 * @property string $src
 * @property string $gender
 * @property string $fee
 * @property int $casting_date
 * @property int $time_from
 * @property int $time_to
 * @property int $job_date
 * @property string $location
 * @property string $booker_name
 * @property string $booker's_number
 * @property string $details
 * @property int $order
 */
class Casting extends \yii\db\ActiveRecord
{
    public $file;
    public $category;
    
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
    public static function tableName()
    {
        return 'casting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'casting_date', 'time_from', 'time_to', 'job_date', 'location', 'booker_name', 'bookers_number', 'category_id'], 'required'],
            [['order', 'category_id'], 'integer'],
            [['details', 'casting_date', 'time_to', 'time_from', 'job_date'], 'string'],
            [['title', 'gender', 'location'], 'string', 'max' => 255],
            [['src'], 'string', 'max' => 100],
            [['fee', 'bookers_number'], 'string', 'max' => 20],
            [['booker_name'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelCategory::className(), 'targetAttribute' => ['category_id' => 'id']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID', 
            'title' => 'Title',
            'src' => 'Src',
            'gender' => 'Gender',
            'fee' => 'Fee',
            'casting_date' => 'Casting Date',
            'time_from' => 'Time From',
            'time_to' => 'Time To',
            'job_date' => 'Job Date',
            'location' => 'Location',
            'booker_name' => 'Booker Name',
            'bookers_number' => 'Booker\'s Number',
            'details' => 'Details',
            'order' => 'Order',
        ];
    }
    
    public function afterFind() {
        parent::afterFind();
        
        $this->casting_date = $this->casting_date ? date('m/d/Y',$this->casting_date) : null;
        $this->job_date = $this->job_date ? date('m/d/Y',$this->job_date) : null;
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(MenuCategory::className(), ['id' => 'category_id']);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            
            $this->casting_date = $this->casting_date ? strtotime($this->casting_date) : null;
            $this->job_date = $this->job_date ? strtotime($this->job_date) : null;
            
            return true;
        }
        return false;
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getCastingUsers() {
        return $this->hasMany(CastingUser::className(), ['casting_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriteCastings() {
        return $this->hasMany(FavoriteCasting::className(), ['casting_id' => 'id']);
    }

}
