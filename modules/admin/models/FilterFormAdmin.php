<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use app\models\UserInfo;
use app\models\ModelSubcategory;

/**
 * ContactForm is the model behind the contact form.
 */
class FilterFormAdmin extends Model
{
    public $category_id;
    public $category2_id;
    public $name;
    public $name2;
    public $id;
    public $address;
    public $country;
    public $bio;
    public $facebook;
    public $twitter;
    public $instagram;
    public $youtube;
    public $snapchat;
    public $collar;
    public $chest;
    public $waist;
    public $suit;
    public $pant;
    public $hair_length;
    public $eye;
    public $hair;
    public $id2;
    public $gender;
    public $gender2;
    public $phone;
    public $prepend_phone;
    public $email;
    public $visa_status;
    public $nationality;
    public $city;
    public $ethnicity;
    public $language;
    public $subcategory;
    public $blockKilter;
    public $subcategory_id = [];
    public $specialization = [];
    
    
    public $age;
    public $length;
    
    public $sub;
    
    public $_ethnicity;
    public $_specialization;
    public $_category = [];
    public $_language;
    public $_gender;
    public $_AGE;
    public $action;
    public $fields = [];

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['category_id', 'id', 'id2', 'category2_id'], 'integer'],
            
            [[
                'city', 'ethnicity', 'subcategory_id', 'subcategory', 
                'address', 'country', 'bio', 'facebook', 'twitter', 
                'instagram', 'youtube', 'snapchat', 'collar', 'chest', 
                'waist', 'suit', 'pant', 'hair', 'hair_length', 'eye'
            ], 'safe'],
            
            [['name', 'name2',   'gender', 'gender2', 'phone', 'visa_status', 'email', 'nationality', 'prepend_phone', 'ethnicity', 'specialization', 'age', 'language'], 'string', 'max' => 255],
        ];
    }
    
    public function setForm(){
        $this->fields = \app\models\RegisterFields::getFields($this->category_id);
        
        $this->blockKilter = \app\models\ModelCategory::getBlockFilltersForCategoryID($this->category_id);
        
        if($this->blockKilter){
            $this->_ethnicity       = ($this->blockKilter['ethnicity'] == '1')        ? UserInfo::itemAlias('ethnicity') : [];
            $this->_specialization  = ($this->blockKilter['specialization'] == '1')   ? UserInfo::itemAlias('specialization') : [];
            $this->_gender          = ($this->blockKilter['gender'] == '1')           ? UserInfo::itemAlias('gender') : [];
            $this->_category        = ($this->blockKilter['category'] == '1')         ? ModelSubcategory::getListSubcategoryForCategoryID($this->category_id, 'Category') : [];
            $this->_AGE             = ($this->blockKilter['age'] == '1')              ? ModelSubcategory::getListSubcategoryForCategoryID('age', 'AGE') : [];
        }
        
        $this->length =   (int)$this->_ethnicity 
                        + (int)$this->_specialization 
                        + (int)$this->_gender 
                        + (int)$this->_category 
                        + (int)$this->_AGE;
    }
    
    
    
    
      /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category',
            'subcategory' => 'Category',
            'category2_id' => 'Search',
            'gender' => 'Gender',
            'gender2' => 'Gender',
            'name' => 'Name',
            'name2' => 'Name',
            'specialization' => 'Specialization',
            'id' => 'ID',
            'id2' => 'ID',
        ];
    }
    
    public static function getNameSubcategory($subcategory){
        $array = self::itemSubcategory();
        
        if($subcategory !== '0'){
            foreach ($array as $value) {
                foreach ($value as $kay => $item) {
                    if($kay === $subcategory){
                        return $item;
                    }
                }
            }
        }
        return '(not set)';
    }

        
    public static function saveSubcategory($oldsubcategory, $types, $subcategory){
        $oldsubcategory = ($oldsubcategory != '') ? json_decode($oldsubcategory) : [];
        
        $added = true;
        foreach ($types as $key => $value) {
            $allSubcategory = self::itemSubcategory($value);
            
            if($subcategory !== '0' && isset($allSubcategory[$subcategory])){
                foreach ($oldsubcategory as $i => $item) {
                    if(isset($allSubcategory[$item])){
                        $oldsubcategory[$i] = $subcategory;
                        $added = false; 
                    }
                }
            }else{
                
            }
        }
        
        if($added){
            $oldsubcategory[] = $subcategory;
        }
        
       return $oldsubcategory;
    }
    
    public static function getListUnite($types){
        $result = [];
        foreach ($types as $key => $value) {
            $result[ucfirst($value)] = self::itemSubcategory($value);
        }
        return $result;
    }
}