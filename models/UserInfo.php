<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "user_info".
 *
 * @property int $user_id
 * @property int $category_id
 * @property string $type
 * @property string $name 
 * @property string $last_name 
 * @property string $gender 
 * @property int $birth 
 * @property string $phone 
 * @property string $phone2 
 * @property int $address 
 * @property string $nationality 
 * @property string $country 
 * @property string $city 
 * @property string $ethnicity 
 * @property string $height 
 * @property int $weight 
 * @property int $collar 
 * @property int $chest 
 * @property int $waist 
 * @property int $hips 
 * @property int $shoe 
 * @property string $suit 
 * @property string $pant 
 * @property string $hair 
 * @property string $hair_length 
 * @property string $eye 
 * @property string $language 
 * @property string $visa_status 
 * @property string $specialization 
 * @property string $remark
 * @property string $bio
 * @property string $facebook
 * @property string $twitter
 * @property string $instagram
 * @property string $youtube
 * @property string $snapchat
 * @property string $review
 * @property string $status
 * @property int $created_at
  @property int $updated_at
 * 
 * @property User $user 
 * @property Categories $category 
 */
class UserInfo extends \yii\db\ActiveRecord
{
    public $category2_id;
    public $name2;
    public $id2;
    public $gender2;
    public $subcategory_id;
    public $checked = [];
    
    public $prepend_phone;
    public $prepend_phone2;
    public $language_other;
    public $publicationType;
    public $subcategory_key;
    public $categories_key;
    public $divaTitle;
    public $servCatName;
    public $categories;
    public $categorySlug;
    public $categories_id;
    public $du_id;
//    public $email;
//    public $availability;
    public $age;
    public $logo;
    public $pre_url;
    public $add_management;
//    public $active = 0;
    public $ages;
    public $admin = false;
    public $isAdmin = false;


    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
//            'sortable' => [
//                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
//                'query' => self::find(),
//            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
//         date
        
        return [
            [['name', 'last_name', 'gender', 'birth', 'prepend_phone', 'phone', 'address', 'nationality', 'country', 'city', 'ethnicity', 'hair', 'eye', 'bio'], 'required', 'except'=>['admin']],
            
            [['user_id'], 'required', 'except'=>['admin']], //registration 10.112017
            
            [['id', 'user_id', 'category_id', 'weight', 'collar', 'chest', 'waist', 'hips', 'shoe', 'prepend_phone', 'prepend_phone2'], 'integer'],
            [['birth', 'address'], 'string'],
            [['gender', 'hair', 'eye'], 'string', 'except'=>['registration']],
            [['phone', 'phone2'], 'integer'],
            [['availability'], 'string'],
//            [['phone', 'phone2'], 'string', 'max'=>10],
            
            [['bio', 'facebook', 'twitter', 'instagram', 'youtube', 'snapchat', 'remark'], 'string', 'max' => 255],
            ['email', 'email'],
            [['name', 'last_name', 'nationality', 'country', 'categorySlug'], 'string', 'max' => 50],
//            [['type'], 'string', 'max' => 13],
//            [['city'], 'string', 'max' => 30],
//            [['ethnicity', 'language'], 'string', 'max' => 20],
            [['height'], 'string', 'max' => 3],
            [['pant', 'suit'], 'string', 'max' => 6],
            [['hair_length'], 'string', 'max' => 6],
            [['visa_status'], 'string', 'max' => 10],
            
            [['booker_name'], 'string', 'max' => 70],
            [['date'], 'string', 'max' => 20],
            
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ModelCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['specialization', 'city','ethnicity', 'language', 'string', 'type'], 'safe'],
            
//            ['gender', 'in', 'range' => array_keys(self::itemAlias('gender')), 'allowArray' => true],
//            ['hair', 'in', 'range' => array_keys(self::itemAlias('hair')), 'allowArray' => true],
//            ['eye', 'in', 'range' => array_keys(self::itemAlias('eye')), 'allowArray' => true]
        ];
    }
    
    public function scenarios($fields = false) {
        return [
            'gender' => ['gender'],
//            'registration' => ['gender'],
        ] + parent::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id'   => 'User ID',
            'category_id' => 'Category',
            'categorySlug' => 'CategorySlug',
            'name'      => 'First Name', 
            'last_name' => 'Last Name', 
            'gender'    => 'Gender', 
            'birth'     => 'Date of Birth', 
            'age'     => 'Age', 
            'phone'     => 'Mobile No.', 
            'phone2'    => 'Whatsapp No.', 
            'address'   => 'Address', 
            'nationality' => 'Nationality', 
            'country'   => 'Country of Residence', 
            'city'      => 'City', 
            'ethnicity' => 'Ethnicity', 
            'height'    => 'Height', 
            'weight'    => 'Weight', 
            'collar'    => 'Collar', 
            'chest'     => 'Bust/Chest', 
            'waist'     => 'Waist', 
            'hips'      => 'Hips', 
            'shoe'      => 'Shoe Size', 
            'suit'      => 'Dress/Suit Size', 
            'pant'      => 'Pant size', 
            'hair'      => 'Hair color', 
            'hair_length' => 'Hair length', 
            'eye'       => 'Eye color', 
            'language'  => 'Language', 
            'visa_status' => 'VISA status', 
            
            'booker_name' => 'Booker Name', 
            'date' => 'Date',
            
            'specialization' => 'Specialization',
            'type'      => 'Main category',
            'active'    => 'Active',
//            'subcategory_key' => 'Subcategory',
            'subcategory' => 'Subcategory',
            'categories_key' => 'Categories',
            'DivaTitle' => 'Publication Type',
            'email'     => 'Email',
            'full_name' => 'Full Name',
            'location_name' => 'Location Name',
            'username'  => 'Username',
            'password'  => 'Password',
            'bio'       => 'BIO',
            'facebook'  => 'Facebook',
            'twitter'   => 'Twitter',
            'instagram' => 'Instagram',
            'youtube'   => 'Youtube',
            'snapchat'  => 'Snapchat',
            'polaroid'  => 'Polaroid',
            'catwalk'   => 'Catwalk',
        ];
    }
    
    
    public static function separator($model){
        if(!$model->isNewRecord){
            
            $oldType = $model->oldAttributes['type'];
            
            $arrayOldType = ($oldType != NULL) ? json_decode($oldType) : [];
            
            if(is_array($model->type)){
                $arrayNewType = $model->type;
            }else{
                $arrayNewType = ($model->type != NULL) ? json_decode($model->type) : [];
            }
            
            // Delete model
            foreach (array_diff($arrayOldType, $arrayNewType) as $type) {
                self::deleteCategoryFromModel($model, $type);
            }

            // Create model
            foreach (array_diff($arrayNewType, $arrayOldType) as $type) {
                self::createCategoryFromModel($model, $type);
            }
        }
    }
    
    public static function createCategoryFromModel($model, $type){
        if (in_array($type, ['Locations', 'Photographers', 'Director', 'Stylist', 'Cast', 'Post Production'])) {
            
            $newModel = ModelProduction::findOne([
                'info_user_id' => $model->id,
                'type' => $type,
            ]);
            if ($newModel == null) {
                $newModel = new ModelProduction();
                $newModel->info_user_id = $model->id;
                $newModel->type = $type;
                $newModel->active = ($model->scenario != 'registration') ? '1' : '0';
                $newModel->save();
            }
            
        } elseif (in_array($type, ['Models'])) {
            $newModel = ModelManagement::findOne(['info_user_id' => $model->id]);
            
            if ($newModel == null) {
                $newModel = new ModelManagement();
                $newModel->info_user_id = $model->id;
                $newModel->active = ($model->scenario != 'registration') ? '1' : '0';
                $newModel->save();
            }
            
        } elseif (in_array($type, ['Events', 'Entertainers'])) {
            $newModel = ModelEvent::findOne([
                'info_user_id' => $model->id,
                'type' => $type
            ]);
            
            if ($newModel == null) {
                $newModel = new ModelEvent();
                $newModel->info_user_id = $model->id;
                $newModel->type = $type;
                $newModel->active = ($model->scenario != 'registration') ? '1' : '0';
                $newModel->save();
            }
        } elseif (in_array($type, ['Promoters Activations', 'Host', 'Hostesses'])) {
            
            if($type == 'Promoters Activations'){
                $type = $model->gender;
            }
            
            $newModel = PromotionsActivations::findOne([
                'info_user_id' => $model->id,
                'type' => $type,
            ]);
            
            if ($newModel == null) {
                $newModel = new PromotionsActivations();
                $newModel->info_user_id = $model->id;
                $newModel->type = $type;
                $newModel->active = ($model->scenario != 'registration') ? '1' : '0';
                $newModel->save();
            }
        }
    }


    public static function deleteCategoryFromModel($model, $type){
        $subcategory = empty($model->subcategory) ? [] : json_decode($model->subcategory);
        
        $arraySubcategory = array_keys(FilterForm::itemSubcategory($type));
        
        foreach ($subcategory as $key => $value) {
            if(in_array($value, $arraySubcategory)){
                unset($subcategory[$key]);
            }
        }
        
        if(in_array($type, ['Locations', 'Photographers', 'Director', 'Stylist', 'Cast', 'Post Production'])){

            (($oldModel = ModelProduction::findOne(['info_user_id'=>$model->id, 'type'=>$type])) != null) ? $oldModel->delete() : null;

        }elseif(in_array($type, ['Models'])) {

            (($oldModel = ModelManagement::findOne(['info_user_id'=>$model->id])) != null) ? $oldModel->delete() : null;

        }elseif(in_array($type, ['Events', 'Entertainers'])) {

            (($oldModel = ModelEvent::findOne(['info_user_id'=>$model->id, 'type'=>$type])) != null) ? $oldModel->delete() : null;

        }elseif(in_array($type, ['Promoters Activations', 'Host', 'Hostesses'])) {

            (($oldModel = PromotionsActivations::findOne(['info_user_id'=>$model->id, 'type'=>$type])) != null) ? $oldModel->delete() : null;
        }
            
    }


    public static function getListItemsUser($q ='', $user_id, $limit = 20, $offset = 0) {
        $query = "
            SELECT u.email, ui.birth, dm.title AS 'type',
            IFNULL(
                (
                    SELECT src
                    FROM user_media
                    WHERE info_user_id = ui.id
                    AND `type` IN ('image', 'polaroid')
                    ORDER BY `order`
                    LIMIT 1
                ), 
                'diva-logo.png'
            ) AS 'logo',
            '/site/diva' AS 'pre_url', d.url AS 'category', dm.slug AS 'action',
            ui.id, ui.phone, ui.phone2, ui.name, ui.nationality
            FROM user_info ui
            LEFT JOIN `user` u ON u.id = ui.user_id
            LEFT JOIN diva_user du ON du.info_user_id = ui.id
            LEFT JOIN diva_media dm ON dm.id = du.diva_media_id
            LEFT JOIN diva d ON d.id = dm.diva_id
            WHERE ui.user_id = :user_id
            AND IF(''= :q, true, (ui.name LIKE :q))
            ORDER BY ui.created_at DESC
            LIMIT :offset, :limit
        ";
        
        $result = Yii::$app->db->createCommand($query, [
            ":user_id" => $user_id,
            ":limit" => (int)$limit,
            ":offset" => (int)$offset,
            ":q" => $q ? "%{$q}%" : '',
        ])->queryAll();
        
        $models = [];
        foreach ($result as $key => $value) {
            $models[$key] = $value;
            
            $phone = $models[$key]['phone'];
            $phone2 = $models[$key]['phone2'];
            $models[$key]['phone'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+(\1) \2 \3 \4 \5',
                (string)$phone
            );
            $models[$key]['phone_html'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+\1\2\3\4\5',
                (string)$phone
            );
            
            
            $models[$key]['phone2'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+(\1) \2 \3 \4 \5',
                (string)$models[$key]['phone2']
            );
            $models[$key]['phone2_html'] = preg_replace(
                '/^(\d+)\/(\d{3})?(\d{3})?(\d{2})?(\d{2})?/',
                '+\1\2\3\4\5',
                (string)$phone2
            );
        }
        
        return $models;
    }
    
    public static function countItemsUser($q, $user_id){
        $query = "
            SELECT COUNT(ui.id)
            FROM user_info ui

            WHERE ui.user_id = :user_id
            AND IF(''= :q, true, (ui.name LIKE :q))
        ";
        
        return (int)\Yii::$app->db->createCommand($query, [
            ':user_id' => $user_id,
            ":q" => $q ? "%{$q}%" : '',
        ])->queryScalar();
    }
    
    
    public static function itemAdminAliasType($code = false){
        
        $items = [
            'Post Production'=>'Post Production',
            'Host'=> 'Host', 
            'Hostesses'=>'Hostesses'
        ] + self::itemAlias('type');
        
        if($code === false){
            return $items;
        }elseif($code != null && isset($items[$code])){
            return $items[$code];
        }
        
        return null;
    }
    
    
    
    public static function itemAlias($type, $code = NULL) {
        $_items = [
            'status' => [
                '0' => "Modernize",
                '1' => "Registration",
                '-1' => "Deleted",
            ],
            'review' => [
                0 => "Under Review",
                1 => "Approved",
                3 => "Rejected",
            ],
            'type' => [
                'Models' => "Models",
                'Promoters Activations'=>'Promoters/Activations',
                'Stylist'=>'Stylist',
                'Events'=>'Events',
                'Cast' => "Cast",
                'Entertainers'=>"Entertrainers",
                'Photographers'=>'Photographers',
                'Locations'=>'Locations',
                'Influencers'=>'Influencers',
                'Director'=>'Director',
            ],
            'gender' => [
                'male' => 'Male',
                'female' => 'Female',
                'boy' => 'Boy',
                'girl' => 'Girl',
                'family' => 'Family',
            ],
            'ethnicity' => [
                'african' => 'African',
                'arabic' => 'Arabic',
                'european' => 'European',
                'indian' => 'Indian',
                'mediterranean' => 'Mediterranean',
                'oriental' => 'Oriental',
            ],
            'language' => [
                'arabic' => 'Arabic',
                'english' => 'English',
                'farsi' => 'Farsi',
                'french' => 'French',
                'german' => 'German',
                'hindi' => 'Hindi',
                'italian' => 'Italian',
                'malayalam' => 'Malayalam',
                'marathi' => 'Marathi',
                'russian' => 'Russian',
                'spanish' => 'Spanish',
                'tagalog' => 'Tagalog',
            ],
            'city' => [
                'abu-dhabi' => 'Abu Dhabi',
                'ajman' => 'Ajman',
                'dubai' => 'Dubai',
                'ras-al-Khaimah' => 'Ras Al Khaimah',
                'sharjah' => 'Sharjah',
                'others' => 'Others',
            ],
            'specialization' => [
                'actor' => 'Actor',
                'fashion-shows' => 'Fashion Shows',
                'hands-feet' => 'Hands / Feet',
                'host' => 'Host',
                'mc' => 'MC',
                'ecom' => 'Ecom',
            ],
            'visa_status' => [
                'tourist'=>'Tourist',
                'visit'=>'Visit',
                'father'=>'Father',
                'mother'=>'Mother',
                'husband'=>'Husband',
                'wife'=>'Wife',
                'residence'=>'Residence',
                'student'=>'Student',
                "none"=>'None'
            ],
            'height' => [
                '50'=>50,   '51'=>51,   '52'=>52,   '53'=>53,   '54'=>54, '55'=>55,
                '56'=>56,   '57'=>57,   '58'=>58,   '59'=>59,   '60'=>60, '61'=>61,
                '62'=>62,   '63'=>63,   '64'=>64,   '65'=>65,   '66'=>66, '67'=>67,
                '68'=>68,   '69'=>69,   '70'=>70,   '71'=>71,   '72'=>72, '73'=>73,
                '74'=>74,   '75'=>75,   '76'=>76,   '77'=>77,   '78'=>78, '79'=>79,
                '80'=>80,   '81'=>81,   '82'=>82,   '83'=>83,   '84'=>84, '85'=>85,
                '86'=>86,   '87'=>87,   '88'=>88,   '89'=>89,   '90'=>90, '91'=>91,
                '92'=>92,   '93'=>93,   '94'=>94,   '95'=>95,   '96'=>96, '97'=>97,
                '98'=>98,   '99'=>99,   '100'=>100, '101'=>101, '102'=>102,
                '103'=>103, '104'=>104, '105'=>105, '106'=>106, '107'=>107,
                '108'=>108, '109'=>109, '110'=>110, '111'=>111, '112'=>112,
                '113'=>113, '114'=>114, '115'=>115, '116'=>116, '117'=>117,
                '118'=>118, '119'=>119, '120'=>120, '121'=>121, '122'=>122,
                '123'=>123, '124'=>124, '125'=>125, '126'=>126, '127'=>127,
                '128'=>128, '129'=>129, '130'=>130, '131'=>131, '132'=>132,
                '133'=>133, '134'=>134, '135'=>135, '136'=>136, '137'=>137,
                '138'=>138, '139'=>139, '140'=>140, '141'=>141, '142'=>142,
                '143'=>143, '144'=>144, '145'=>145, '146'=>146, '147'=>147,
                '148'=>148, '149'=>149, '150'=>150, '151'=>151, '152'=>152, 
                '153'=>153, '154'=>154, '155'=>155, '156'=>156, '157'=>157,
                '158'=>158, '159'=>159, '160'=>160, '161'=>161, '162'=>162,
                '163'=>163, '164'=>164, '165'=>165, '166'=>166, '167'=>167,
                '168'=>168, '169'=>169, '170'=>170, '171'=>171, '172'=>172,
                '173'=>173, '174'=>174, '175'=>175, '176'=>176, '177'=>177,
                '178'=>178, '179'=>179, '180'=>180, '181'=>181, '182'=>182,
                '183'=>183, '184'=>184, '185'=>185, '186'=>186, '187'=>187,
                '188'=>188, '189'=>189, '190'=>190, '191'=>191, '192'=>192,
                '193'=>193, '194'=>194, '195'=>195, '196'=>196, '197'=>197,
                '198'=>198, '199'=>199, '200'=>200
            ],
            'weight' => [
                '1'=>1,     '2'=>2,     '3'=>3,     '4'=>4,     '5'=>5,     '6'=>6, 
                '7'=>7,     '8'=>8,     '9'=>9,     '10'=>10,   '11'=>11,   '12'=>12,   
                '13'=>13,   '14'=>14,   '15'=>15,   '16'=>16,   '17'=>17,   '18'=>18,
                '19'=>19,   '20'=>20,   '21'=>21,   '22'=>22,   '23'=>23,   '24'=>24,
                '25'=>25,   '26'=>26,   '27'=>27,   '28'=>28,   '29'=>29,   '30'=>30,
                '31'=>31,   '32'=>32,   '33'=>33,   '34'=>34,   '35'=>35,   '36'=>36,
                '37'=>37,   '38'=>38,   '39'=>39,   '40'=>40,   '41'=>41,   '42'=>42,
                '43'=>43,   '44'=>44,   '45'=>45,   '46'=>46,   '47'=>47,   '48'=>48,
                '49'=>49,   '50'=>50,   '51'=>51,   '52'=>52,   '53'=>53,   '54'=>54,
                '55'=>55,   '56'=>56,   '57'=>57,   '58'=>58,   '59'=>59,   '60'=>60,
                '61'=>61,   '62'=>62,   '63'=>63,   '64'=>64,   '65'=>65,   '66'=>66,
                '67'=>67,   '68'=>68,   '69'=>69,   '70'=>70,   '71'=>71,   '72'=>72,
                '73'=>73,   '74'=>74,   '75'=>75,   '76'=>76,   '77'=>77,   '78'=>78,
                '79'=>79,   '80'=>80,   '81'=>81,   '82'=>82,   '83'=>83,   '84'=>84,
                '85'=>85,   '86'=>86,   '87'=>87,   '88'=>88,   '89'=>89,   '90'=>90,
                '91'=>91,   '92'=>92,   '93'=>93,   '94'=>94,   '95'=>95,   '96'=>96,
                '97'=>97,   '98'=>98,   '99'=>99,   '100'=>100, '101'=>101,
                '102'=>102, '103'=>103, '104'=>104, '105'=>105, '106'=>106,
                '107'=>107, '108'=>108, '109'=>109, '110'=>110, '111'=>111,
                '112'=>112, '113'=>113, '114'=>114, '115'=>115, '116'=>116,
                '117'=>117, '118'=>118, '119'=>119, '120'=>120, '121'=>121,
                '122'=>122, '123'=>123, '124'=>124, '125'=>125, '126'=>126,
                '127'=>127, '128'=>128, '129'=>129, '130'=>130, '131'=>131,
                '132'=>132, '133'=>133, '134'=>134, '135'=>135, '136'=>136,
                '137'=>137, '138'=>138, '139'=>139, '140'=>140, '141'=>141,
                '142'=>142, '143'=>143, '144'=>144, '145'=>145, '146'=>146,
                '147'=>147, '148'=>148, '149'=>149, '150'=>150
            ], 
            'collar'=>[
                '20'=>20, '21'=>21, '22'=>22, '23'=>23, '24'=>24, '25'=>25,
                '26'=>26, '27'=>27, '28'=>28, '29'=>29, '30'=>30, '31'=>31,
                '32'=>32, '33'=>33, '34'=>34, '35'=>35, '36'=>36, '37'=>37,
                '38'=>38, '39'=>39, '40'=>40, '41'=>41, '42'=>42, '43'=>43,
                '44'=>44, '45'=>45, '46'=>46, '47'=>47, '48'=>48, '49'=>49,
                '50'=>50,
            ],
            'chest'=>[
                '40'=>40,   '41'=>41,   '42'=>42,   '43'=>43,   '44'=>44,   '45'=>45,
                '46'=>46,   '47'=>47,   '48'=>48,   '49'=>49,   '50'=>50,   '51'=>51,
                '52'=>52,   '53'=>53,   '54'=>54,   '55'=>55,   '56'=>56,   '57'=>57,
                '58'=>58,   '59'=>59,   '60'=>60,   '61'=>61,   '62'=>62,   '63'=>63,
                '64'=>64,   '65'=>65,   '66'=>66,   '67'=>67,   '68'=>68,   '69'=>69,
                '70'=>70,   '71'=>71,   '72'=>72,   '73'=>73,   '74'=>74,   '75'=>75,
                '76'=>76,   '77'=>77,   '78'=>78,   '79'=>79,   '80'=>80,   '81'=>81,
                '82'=>82,   '83'=>83,   '84'=>84,   '85'=>85,   '86'=>86,   '87'=>87,
                '88'=>88,   '89'=>89,   '90'=>90,   '91'=>91,   '92'=>92,   '93'=>93,
                '94'=>94,   '95'=>95,   '96'=>96,   '97'=>97,   '98'=>98,   '99'=>99,
                '100'=>100, '101'=>101, '102'=>102, '103'=>103, '104'=>104,
                '105'=>105, '106'=>106, '107'=>107, '108'=>108, '109'=>109,
                '110'=>110, '111'=>111, '112'=>112, '113'=>113, '114'=>114,
                '115'=>115, '116'=>116, '117'=>117, '118'=>118, '119'=>119,
                '120'=>120, '121'=>121, '122'=>122, '123'=>123, '124'=>124,
                '125'=>125, '126'=>126, '127'=>127, '128'=>128, '129'=>129,
                '130'=>130, '131'=>131, '132'=>132, '133'=>133, '134'=>134,
                '135'=>135, '136'=>136, '137'=>137, '138'=>138, '139'=>139,
                '140'=>140, '141'=>141, '142'=>142, '143'=>143, '144'=>144,
                '145'=>145, '146'=>146, '147'=>147, '148'=>148, '149'=>149,
                '150'=>150,
            ],
            
            'shoe'=>[
                '1'=>1,     '2'=>2, '3'=>3, '4'=>4, '5'=>5, '6'=>6, '7'=>7, '8'=>8, 
                '9'=>9,   '10'=>10, '11'=>11, '12'=>12, '13'=>13, '14'=>14,
                '15'=>15, '16'=>16, '17'=>17, '18'=>18, '19'=>19, '20'=>20,
                '21'=>21, '22'=>22, '23'=>23, '24'=>24, '25'=>25, '26'=>26,
                '27'=>27, '28'=>28, '29'=>29, '30'=>30, '31'=>31, '32'=>32,
                '33'=>33, '34'=>34, '35'=>35, '36'=>36, '37'=>37, '38'=>38,
                '39'=>39, '40'=>40, '41'=>41, '42'=>42, '43'=>43, '44'=>44,
                '45'=>45, '46'=>46, '47'=>47, '48'=>48, '49'=>49, '50'=>50,
                '51'=>51, '52'=>52, '53'=>53, '54'=>54, '55'=>55, '56'=>56,
                '57'=>57, '58'=>58, '59'=>59, '60'=>60
            ],
            'suit'=>[
                '2'=>2, '4'=>4, '6'=>6, '8'=>8, '10'=>10, '12'=>12, '14'=>14,
                '16'=>16, '18'=>18, '20'=>20, '22'=>22, '24'=>24, '26'=>26, 
                '28'=>28, '30'=>30, '32'=>32, '34'=>34, '36'=>36, '38'=>38,
                '40'=>40, '42'=>42, '44'=>44, '46'=>46, '48'=>48, '50'=>50,
                '52'=>52, '54'=>54, '56'=>56, '58'=>58, '60'=>60, "XS"=>'XS',
                "S"=>'S', "M"=>'M', "L"=>'L', "XL"=>'XL', "XXL"=>'XXL'
            ],
            'hair'=> [
                'black' => 'Black', 'blonde' => 'Blonde', 
                'brown' => 'Brown', 'gray' => 'Grey', 
                'red' => 'Red'
            ],
            'hair_length'=> [
                'Short'=>'Short',
                'Medium'=>'Medium',
                'Long'=>'Long'
            ],
            'eye'=>[
                'black'=> 'Black', 'blue'=> 'Blue',
                'brown'=> 'Brown', 'gray'=> 'Grey',
                'green'=> 'Green',
            ],
            'age'=>[
                '0-200' =>'All Ages',
                '20-30' =>'20 To 30(Adult)',
                '30-45' =>'30 To 45(Mid)',
                '45-200' =>'45+(Old)',
            ],
            'age-children'=>[
                '0-4'=> 'Babies (0-4)',
                '5-9'=> 'Kids (5-9)',
                '10-12'=> 'Children (10-12)',
                '13-18'=> 'Teen (13-18)',
            ],
            'height-gorup' => [
                '50-60'     => '50-60',     '61-70'     => '61-70',
                '71-80'     => '71-80',     '81-90'     => '81-90',
                '91-100'    => '91-100',    '101-110'   => '101-110',
                '111-120'   => '111-120',   '121-130'   => '121-130',
                '131-140'   => '131-140',   '141-150'   => '141-150',
                '151-160'   => '151-160',   '161-170'   => '161-170',
                '171-180'   => '171-180',   '181-190'   => '181-190',
                '191-200'   => '191-200',
            ],
            'shoe-group'=>[
                '1-10'      => '1-10',      '11-20'     => '11-20',
                '21-30'     => '21-30',     '31-40'     => '31-40',
                '41-50'     => '41-50',     '51-60'
            ],
            'hips-gorup'=>[
                '40-50'     => '40-50',     '51-60'     => '51-60',
                '61-70'     => '61-70',     '71-80'     => '71-80',
                '81-90'     => '81-90',     '91-100'    => '91-100',
                '101-110'   => '101-110',   '111-120'   => '111-120',
                '121-130'   => '121-130',   '131-140'   => '131-140',
                '141-150'   => '141-150',
            ],
            'waist-gorup' => [
                '1-10'      => '1-10',      '11-20'     => '11-20',
                '21-30'     => '21-30',     '31-40'     => '31-40',
                '41-50'     => '41-50',     '51-60'     => '51-60',
                '61-70'     => '61-70',     '71-80'     => '71-80',
                '81-90'     => '81-90',     '91-100'    => '91-100',
                '101-110'   => '101-110',   '111-120'   => '111-120',
                '121-130'   => '121-130',   '131-140'   => '131-140',
                '141-150'   => '141-150',
            ],
            
            
        ];
        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
    
    /**
     * 
     * @param type $category_id
     * @return type
     * male
     * female
     * boy
     * girl
     * family
     */
    public static function itemGenderFromCategory($category_id = null){
        $gender = self::itemAlias('gender');
        if(in_array($category_id, ['4', '12', '19'])){
            unset($gender['family']);
        }elseif($category_id === '53'){
            unset($gender['boy']);
            unset($gender['girl']);
        }elseif(in_array ($category_id, ['5', '15', '17'])){
            unset($gender['boy']);
            unset($gender['girl']);
            unset($gender['family']);
        }
        return $gender;
    }




    public function afterFind() {
        parent::afterFind();
        
        if(!empty($this->phone)){
            $phone = explode('/',$this->phone);
            if(isset($phone[1])){
                $this->prepend_phone = $phone[0];
                $this->phone = $phone[1];
            }else{
                $this->phone = $phone[0];
            }
        }
        
        if(!empty($this->phone2)){
            $phone = explode('/',$this->phone2);
            if(isset($phone[1])){
                $this->prepend_phone2 = $phone[0];
                $this->phone2 = $phone[1];
            }else{
                $this->phone2 = $phone[0];
            }
        }
        
        $this->age = $this->birth;
        $this->birth = $this->birth ? date('m/d/Y',$this->birth) : null;
        
        $this->specialization = json_decode($this->specialization);
        $this->city         = json_decode($this->city);
        $this->ethnicity    = json_decode($this->ethnicity);
        $this->language     = json_decode($this->language);
        
        $this->hair         = json_decode($this->hair);
        $this->eye          = json_decode($this->eye);
        
        $this->type         = empty($this->type) ? null : json_decode($this->type);
        
//        $this->categories_id   = $this->categories ? array_keys(json_decode($this->categories, true)) : [];
//        $this->categories_id   = $this->categories ? array_keys(json_decode($this->categories, true)) : [];
//        $this->categories_id = json_encode($this->categories_id);
        
        $this->subcategory_key  =  ($this->subcategory != null)  ? array_keys(json_decode($this->subcategory, true)) : null;
        
        $this->categories_key  =  ($this->categories != null)  ? array_keys(json_decode($this->categories, true)) : null;
        
        $this->categories   = $this->categories ? json_decode($this->categories, true) : [];
        $this->categories_id   = $this->categories_id ? json_decode($this->categories_id, true) : [];
        $this->subcategory  =  ($this->subcategory != null)  ? json_decode($this->subcategory, true) : null;
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->phone = "{$this->prepend_phone}/{$this->phone}";
            $this->phone2 = "{$this->prepend_phone2}/{$this->phone2}";
            
            $this->birth = $this->birth ? strtotime($this->birth) : null;
            
            $this->specialization = empty($this->specialization) ? '[]' : json_encode($this->specialization);
            $this->city = empty($this->city) ? '[]' : json_encode($this->city);
            $this->ethnicity = empty($this->ethnicity) ? '[]' : json_encode($this->ethnicity);
            $this->language = empty($this->language) ? '[]' : json_encode($this->language);
            
            $this->hair = empty($this->hair) ? '[]' : json_encode($this->hair);
            $this->eye = empty($this->eye) ? '[]' : json_encode($this->eye);
            
            if($this->isNewRecord){
                $this->type = [$this->type];
            }else{
                if($this->scenario == 'registration'){
                    if((int)$this->category_id != $this->oldAttributes['category_id']){
                        UserCategory::deleteAll([
                            'category_id'=> $this->oldAttributes['category_id'],
                            'info_user_id'=> $this->id
                        ]);
                    }
                }
//                self::separator($this);
            }
            
            $this->type = is_array($this->type) ? json_encode($this->type, true) : $this->type;
            
            $this->subcategory = is_array($this->subcategory) ? json_encode($this->subcategory) : $this->subcategory;
            
            return true;
        }
        return false;
    }
    
    

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        if($this->scenario == 'registration'){
            $userCategory = UserCategory::findOne([
                'category_id'=> $this->category_id,
                'info_user_id'=> $this->id
            ]);
            
            if($userCategory == null){
                $userCategory = new UserCategory();
                $userCategory->category_id = $this->category_id;
                $userCategory->info_user_id = $this->id;
                $userCategory->save();
            }
//            self::createCategoryFromModel($this, $type[0]);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
    
   
            
    public static function getModelInfo($category, $action, $info_user_id){
        $query = "
            SELECT ui.`name`, ui.email, ui.id,  ui.height, ui.chest, ui.waist, ui.hips, ui.shoe, ui.hair, ui.eye,
            (
                SELECT CONCAT('{', '\"slug\":\"', mc.slug, '\",\"name\":\"', mc.`name`, '\",', '\"short\":\"', mc.short, '\"','}') AS 'result'
                FROM model_category mc
                LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
                WHERE pmc.slug = :category
                AND IF(:action IN('malecasts', 'femalecasts', 'familycasts'), mc.slug = 'casts', mc.slug = :action) 
            ) AS category
            FROM user_info ui
            WHERE ui.id = :info_user_id
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':info_user_id' => $info_user_id,
            ':category' => $category,
            ':action' => $action,
        ])->queryOne();
        
        if($request){
            $request['category'] = json_decode($request['category'], true);
            $request['short'] = $request['category']['short'];
        }
        return $request ;
    }
    
    public static function getUserInfoFromService($info_user_id){
        $query = "
            SELECT ui.id, ui.height, ui.chest, ui.waist, ui.hips, ui.shoe, ui.hair, ui.eye, sc.short
            FROM user_info ui
            LEFT JOIN service_users su ON su.info_user_id = ui.id
            LEFT JOIN service_categories sc ON su.service_cat_id = sc.id
            WHERE ui.id = :info_user_id
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':info_user_id' => $info_user_id,
        ])->queryOne();
        
        $request['eye'] = preg_replace('/\["(.*)?"\]/', "$1", $request['eye']);
        
        return $request;
    }
    
    public static function getName($user_id){
        $query = "
            SELECT CONCAT(ui.`name`, ' ', ui.last_name) AS name
            FROM `user` u
            LEFT JOIN user_info ui ON ui.user_id = u.id
            WHERE u.id = :user_id
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':user_id' => $user_id,
        ])->queryScalar();
        
        return $request;
    }
    
    
    public static function getListCategoryFromSite(){
        $query = "
            SELECT id, `name`
            FROM model_category
            WHERE `type` = 'site'
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        return \yii\helpers\ArrayHelper::map($list, 'id', 'name') ;
    }
    
    public static function getListCategoryFromSiteSlug(){
        $query = "
            SELECT `name`,
                CASE 
                    WHEN slug = 'models'        THEN 'models'
                    WHEN slug = 'productions'   THEN 'productions'
                    WHEN slug = 'photographers' THEN 'photographers'
                    WHEN slug = 'influencers'   THEN 'influencer'
                    WHEN slug = 'casts'         THEN 'cast'
                    WHEN slug = 'entertainer'   THEN 'entertainers'
                    WHEN slug = 'eventsupport'  THEN 'events'
                    WHEN slug = 'locations'     THEN 'location'
                    WHEN slug = 'promoters'     THEN 'promoter'
                    WHEN slug = 'stylists'      THEN 'stylist'
                    WHEN slug = 'director'      THEN 'directors'
                    ELSE slug
                END AS slug 
            FROM model_category
            WHERE `type` = 'site'
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        return \yii\helpers\ArrayHelper::map($list, 'slug', 'name') ;
    }
    
    public static function sentMailForRegister($tupe, $id){
        $hostName = Yii::$app->request->hostName;
        $theme = \app\models\EmailTheme::getTheme($tupe, $id);
        
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Дополнительные заголовки
        $headers[] = "From: $hostName";
        
//        $temp = mail($theme['email'], $theme['subject'], $theme['message'], implode("\r\n", $headers));
//        vd($temp, false);
//
//        vd($theme);


        // Отправляем
       return mail($theme['email'], $theme['subject'], $theme['message'], implode("\r\n", $headers));
    }
    
    
    public static function getNextLastUser($info_user_id, $category, $action){
        Yii::$app->db->createCommand("
            SET @i := 0;
            SET @key := null;
        ")->execute();
        
        $query = "

            SELECT us.* 
            FROM (
                SELECT @i := (@i + 1) AS 'i', IF(du.info_user_id = :info_user_id, @key :=@i, null) AS 'resut', du.info_user_id
                FROM diva_user du
                LEFT JOIN diva_media dm ON dm.id = du.diva_media_id
                LEFT JOIN diva d ON d.id = dm.diva_id
                WHERE dm.url = :action
                AND d.url = IF(:category = 'production', 'productions', :category) 
            ) as `us`
            WHERE us.i IN (@key-1, @key, @key+1)
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':category' => $category,
            ':action' => $action,
            ':info_user_id' => $info_user_id, // 20
        ])->queryAll(); 
        
        $key = false;
        $result = [
            'next_id' => false,
            'prev_id' => false,
        ];
        
        
        foreach ($request as $value) {
            if($key === false && $value['resut'] === null){
                $result['prev_id'] = $value['info_user_id'];
            }elseif($key === false && $value['resut'] != null){
                $key = true;
            }elseif($key === true && $value['resut'] === null){
                $result['next_id'] = $value['info_user_id'];
            }
        }
        
        return $result;
    }
    
    
    public static function getNextLastProfile($info_user_id){
        Yii::$app->db->createCommand("
            SET @i := 0;
            SET @key := null;
        ")->execute();
        
        $query = "
            SELECT us.*
            FROM(
                SELECT @i := (@i + 1) AS 'i', IF(id = :info_user_id, @key :=@i, null) AS 'resut', id, gender
                FROM user_info
                WHERE active = '1'
            ) AS us
            WHERE us.i IN (@key-1, @key, @key+1)
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':info_user_id' => $info_user_id, 
        ])->queryAll(); 
        
        $key = false;
        $result = [
            'url' => NULL,
            'next_id' => false,
            'prev_id' => false,
        ];
        
        foreach ($request as $value) {
            if($key === false && $value['resut'] === null){
                $result['prev_id'] = $value['id'];
            }elseif($key === false && $value['resut'] != null){
                $key = true;
            }elseif($key === true && $value['resut'] === null){
                $result['next_id'] = $value['id'];
            }
            
            $result['url'] = null;
        }
        
        return $result;
    }
    
    
    public function getSubcategory(){
        
        
        if(is_array($this->subcategory)){
            $subcategory = $this->subcategory;
        }else{
            $subcategory = ($this->subcategory != NULL) ? json_decode($this->subcategory) : [];
        }
        
        $result= [];
        foreach ($subcategory as $value) {
            $result[$value] = "<div class='sub-block'>$value</div>";
        }
        
        return empty($result) ? null : implode('', $result);

        
        $result = [];
        foreach ($subcategory as $key => $value) {
            $item = \app\models\FilterForm::itemSubcategory($this->type, $value);
            
            if($item){
                $result[$key] = \app\models\FilterForm::itemSubcategory($this->type, $value);
            }else{
                
            }
        }
        
        return empty($subcategory) ? null : implode(', </br>', $result);
    }
    
    public static function setSubcategory(){
        $info_user_id = Yii::$app->request->post('editableKey');
        $index = Yii::$app->request->post('editableIndex');
        $userInfo = Yii::$app->request->post('UserInfo');
        $subcategories = (isset($userInfo[$index]['subcategory_key']) && $userInfo[$index]['subcategory_key'] != '') ? $userInfo[$index]['subcategory_key'] : [];
        
        $oldSubcategories = ModelSubcategory::getListSubcategoryFromUser($info_user_id);
        $newSubcategories = ModelSubcategory::getListSubcategoryFromId($subcategories);
        
        $categories = [];
        if(isset($_GET['categories'])){
            $categories = $_GET['categories'];
        }
        
        foreach ($categories as $value) {
            $old = isset($oldSubcategories[$value]) ? $oldSubcategories[$value] : [];
            $new = isset($newSubcategories[$value]) ? $newSubcategories[$value] : [];
            
            //create
            foreach (array_diff($new, $old) as $subcategory_id) {
                $model = new \app\models\UserSubcategory();
                $model->info_user_id = $info_user_id;
                $model->subcategory_id = $subcategory_id;
                $model->save();
            }
            
            //delete
            foreach (array_diff($old, $new) as $subcategory_id) {
                $model = \app\models\UserSubcategory::findOne([
                    'info_user_id' => $info_user_id,
                    'subcategory_id' => $subcategory_id,
                ]);
                $model->delete();
            }
        }
        
//        $user = \app\models\UserInfo::find()
//                ->from('user_info ui')
//                ->select([
//                    "ui.*",
//                    "(
//                        SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',ms.id, '\":', '\"', ms.`name`, '\"') SEPARATOR ','), '}')
//                        FROM user_subcategory us
//                        LEFT JOIN model_subcategry ms ON ms.id = us.subcategory_id
//                        WHERE us.info_user_id = ui.id
//                    ) AS subcategory",
//                ])
//                ->where(['id'=> $info_user_id])
//                ->one();
        
//        $oldListSubcategoryKey = array_keys($oldListSubcategory);
        
        // Delete model
//        foreach (array_diff_key($user->subcategory, $subcategories) as $key => $value) {
//            $model = UserSubcategory::findOne([
//                'info_user_id' => $info_user_id,
//                'subcategory_id' => $key,
//            ])->delete();
//        }
        // Create model
//        foreach (array_diff_key($subcategories, $user->subcategory) as $key => $value) {
//                $model = new UserSubcategory();
//                $model->info_user_id = $info_user_id;
//            $model->subcategory_id = $key;
//                $model->save();
//            }
            
        
        
//            $subcategory = UserSubcategory::getLIstSubcategoyForUser($info_user_id);
            
//            $user = \app\models\UserInfo::find()
//                ->from('user_info ui')
//                ->select([
//                    "ui.*",
//                    "(
//                        SELECT CONCAT('{',GROUP_CONCAT(CONCAT('\"',ms.id, '\":', '\"', ms.`name`, '\"') SEPARATOR ','), '}')
//                        FROM user_subcategory us
//                        LEFT JOIN model_subcategry ms ON ms.id = us.subcategory_id
//                        WHERE us.info_user_id = ui.id
//                    ) AS subcategory",
//                ])
//                ->where(['id'=> $info_user_id])
//                ->one();
        
            $subcategoryName = UserSubcategory::getLIstSubcategoyForUser($info_user_id);
            $subcategoryName = \app\models\UserInfo::htmlCategories($subcategoryName);

            echo  \yii\helpers\Json::encode(['output' => $subcategoryName, 'message' => '']);
            
        return;
    }
    
    
    public function getHtmlCategories(){
        $result = '';
        if($this->categories != null){
            foreach ($this->categories as $value) {
                $result .= "<div class='sub-block'>$value</div>";
            }
        }
        return $result;
    }
    
    
    public static function htmlCategories($categories){
        $result = '';
        if($categories != null){
            foreach ($categories as $value) {
                $result .= "<div class='sub-block'>$value</div>";
            }
        }
        return $result;
    }
    
    public static function getInstancesModel($user_id, $fields){
        $columAll = \Yii::$app->db->getTableSchema('user_info')->getColumnNames();
        $colum = array_intersect($fields, $columAll);
        
        $model = \app\models\UserInfo::find()
                ->where(['user_id'=>$user_id])
                ->select($colum)
                ->orderBy('created_at DESC')
                ->one();
        
        if($model == null){
            $model = new \app\models\UserInfo(['scenario'=>'registration']);
        }else{
            $model->isNewRecord = true;
            $model->scenario = 'registration';
        }
        
        return $model;
    }
    
    public static function listCategoryFromUser($user_id = ''){
        $query = "
            SELECT ui.id, mc.`name`
            FROM user_info ui
            LEFT JOIN model_category mc ON mc.id = ui.category_id
            WHERE ui.user_id = :user_id
            AND ui.category_id IS NOT NULL
            ORDER BY ui.created_at DESC
        ";
        
        $list = Yii::$app->db->createCommand($query, [':user_id'=>$user_id])->queryAll();
        
        return \yii\helpers\ArrayHelper::map($list, 'id', 'name');
    }
    
    public static function getEmailFromID($listID){
        $listID = implode(',', $listID);
        
        $query = "
            SELECT ui.id,  u.email
            FROM user_info ui
            LEFT JOIN `user` u ON u.id = ui.user_id
            WHERE ui.id IN ({$listID})
            GROUP BY ui.user_id
        ";
            
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $value) {
            $result[$value['id']] = $value['email'];
        }
        
        return $result;
    }
    
    public static function itemAliasChildren(){
        $request = Yii::$app->request;
        
        $post = $request->post('UserInfoSearch', FALSE);
        $gender = '';
        if($post && (isset($post['gender2']) || isset($post['gender'])) ){
            $gender = $post['gender2'] ? $post['gender2'] : $post['gender'];
        }else{
            $post = $request->post();
            if(isset($post['gender2']) || isset($post['gender'])){
                $gender = isset($post['gender2']) ? $post['gender2'] : $post['gender'];
            }
        }
        if($gender == ''){
            $get = $request->get('UserInfoSearch', false);
            
            if($get && (isset($get['gender2']) || isset($get['gender'])) ){
                $gender = isset($get['gender2']) ? $get['gender2'] : $get['gender'];
            }else{
                $get = $request->get();
                if(isset($get['gender2']) || isset($get['gender'])){
                    $gender = $get['gender2'] ? $get['gender2'] : $get['gender'];
                }
            }
        }
        
        
        if($gender == ''){
            return \app\models\UserInfo::itemAlias('age');
        }elseif(in_array($gender, ['boy', 'girl'])){
            return \app\models\UserInfo::itemAlias('age-children');
        }else{
            return \app\models\UserInfo::itemAlias('age');
            
        }
    }
    
    public static function criteriaList($action, $gender, $list, $filter){
 
        $subcategory = null;
        if($filter && $filter['subcategory']){
            $subcategory = implode(',', array_keys($filter['subcategory']));
        }
        
        $and = '';
        $order = '';
        if(($action === 'models') && in_array($gender, ['male','female', 'family'])){
            $and =
                $subcategory ? "AND ms.id IN ({$subcategory})" : "AND ms.slug IN ('portfolio', 'international', 'model 1', 'model 2', 'New Face', 'celebrity', 'Direct Booking') AND ms.slug != 'out of town'".
                    
                "AND us.subcategory_id = ms.id
                AND ui.`availability` IN ('1', '0')
                AND (mc.id IN ({$list}) OR mc.parent_id IN ({$list}))
            "; 
            $order = "ORDER BY ui.availability DESC, sort DESC, ui.`name` ASC";
        }elseif(($action === 'models') && in_array($gender, ['boy', 'girl'])){
            $and = 
                $subcategory ? "AND ms.id IN ({$subcategory})" : "AND ms.slug != 'out of town'
                AND ui.`availability` != '-1'
                AND (mc.id IN ({$list}) OR mc.parent_id IN ({$list}))
            "; 
            $order = "ORDER BY ui.birth DESC";
        }elseif(in_array($action, ['productions', 'locations', 'photographers', 'director'])){
            if($subcategory){$and .= "AND ms.id IN ({$subcategory})";}
            $and .= 
                "AND ui.`availability` IN ('1', '-1') 
                AND mc.slug = :action
            "; 
            $order = "ORDER BY ui.availability DESC, ui.`name` ASC";
        }elseif($action === 'stylists'){
            if($subcategory){$and .= "AND ms.id IN ({$subcategory})";}
            $and .=
                "AND ui.`availability` IN ('1', '-1') 
                AND mc.slug = :action
            "; 
            $order = "ORDER BY ui.availability DESC, sort DESC, ui.`name` ASC";
        }elseif(($action === 'casts') && in_array($gender, ['male', 'female', 'family'])){
            $and = $subcategory ? "AND ms.id IN ({$subcategory})" : "AND ms.slug != 'out of town'
                AND ui.`availability` IN ('1', '-1') 
                AND mc.slug = :action
            "; 
            $order = "ORDER BY ui.availability DESC, ui.`name` ASC";
        }elseif(in_array($action, ['host', 'hostess'])){
            if($subcategory){$and .= "AND ms.id IN ({$subcategory})";}

            $and .= 
                "AND ui.`availability` != '-1' 
                AND ms.slug = :action
            "; 
            $order = "ORDER BY ui.availability DESC, ui.`name` ASC";
        }elseif($action == 'promoters'){
            if($subcategory){$and .= "AND ms.id IN ({$subcategory})";}

            $and .=
                "AND mc.slug = :action
                AND ms.slug NOT LIKE 'out of town'
            "; 
            $order = "ORDER BY ui.availability DESC, ui.`name` ASC";
        }elseif(in_array ($action, ['eventsupport', 'entertainer', 'ourwork', 'influencers'])){
            if($subcategory){$and .= "AND ms.id IN ({$subcategory})";}
            $and .= "AND mc.slug = :action"; 
            $order  = "ORDER BY ui.availability DESC, ui.`name` ASC";
        }
        
        return [$and, $order];
    }
    
    public static function sqlLogo($is_logo, $action = null){
        $logo = null;
        
        $and = '';
        if($action == 'director'){
            $and .= "AND `type` IN('showreel', 'catwalk')";
        }else{
            $and .= "AND `type` = 'image'";
        }
        
        if($is_logo){
            $logo = "
                IFNULL(
                    (
                        SELECT src
                        FROM user_media
                        WHERE info_user_id = uc.info_user_id
                        {$and}
                        ORDER BY `order` ASC
                        LIMIT 1
                    ), 
                    'diva-logo.png'
                ) AS 'logo',
            ";
        }
        return $logo;
    }
    
    public static function getDateFilterFromSql($filter, $gender){
        
        if($filter === null){
            return ['', '', $gender, '', ''];
        }
        
        $ethnicity = self::getStringFromArray($filter['ethnicity']);
        $specialization = self::getStringFromArray($filter['specialization']);
        
        if($filter['gender']){ $gender = $filter['gender']; }
        
        $subcategory = '';
        if($filter['subcategory']){
            $subcategory = array_keys($filter['subcategory']);
            $subcategory = implode(',', $subcategory);
        }
        
        if(($age = $filter['age']) != null && $age != 'al'){
            $ageArray = explode('-', $age);
            
            if(count($ageArray) > 1){
                list($STRstart, $STRfinish) = $ageArray;
                $start = strtotime("-{$STRfinish} year");
                $finish = strtotime("-{$STRstart} year");
            }
        }
        
        return [
            $ethnicity,
            $specialization,
            $gender,
            $subcategory,
            $age,
        ];
    }

    public static function getListUniversal($action, $actionOld, $gender, $list, $filter = null, $is_logo = false, $is_limit = false, $limit = 40, $ofsset = 0){
        list($ethnicity, $specialization, $gender, $subcategory, $age) = self::getDateFilterFromSql($filter, $gender);
   
        $SQLlimit = null; 
        if($is_limit){
            $SQLlimit = "LIMIT :ofsset, :limit";
            $params[':limit'] = $limit;
            $params[':ofsset'] = $ofsset;
        }

        list($and, $order) = self::criteriaList($action, $gender, $list, $filter);
        $logo = self::sqlLogo($is_logo, $action);
        
        $query = "
            SELECT IFNULL(ui.old_id, ui.id) AS old_id, ui.id AS info_user_id, :actionOld AS 'action', 
                if(:action = 'productions', 
                    ui.name, 
                    CONCAT_WS('*', mc.short, IFNULL(ui.old_id, ui.id))  
                )AS 'name',
                {$logo}
                IF(:action = 'stylists',
                    -- SUM(
                        CASE 
                            WHEN ms.slug = 'Makeup Stylist'     THEN 8192 
                            WHEN ms.slug = 'Hair Stylist'       THEN 4096
                            WHEN ms.slug = 'Hair and Make'      THEN 2048
                            WHEN ms.slug = 'Prosthetic Stylist' THEN 1024
                            WHEN ms.slug = 'Wardrobe Stylist'   THEN 512
                            WHEN ms.slug = 'Prop Stylist'       THEN 256
                            WHEN ms.slug = 'Food Stylist'       THEN 128
                            WHEN ms.slug = 'Makeup Stylist'     THEN 64
                            WHEN ms.slug = 'Hair Stylist'       THEN 32
                            WHEN ms.slug = 'Hair and Make'      THEN 16
                            WHEN ms.slug = 'Prosthetic Stylist' THEN 8
                            WHEN ms.slug = 'Wardrobe Stylist'   THEN 4
                            WHEN ms.slug = 'Prop Stylist'       THEN 2
                            WHEN ms.slug = 'Food Stylist'       THEN 1
                       END
                    -- )
                    ,
                    SUM(
                        CASE 
                            WHEN ms.slug = 'international' THEN 64 
                            WHEN ms.slug = 'model 1' THEN 32 
                            WHEN ms.slug = 'model 2' THEN 16 
                            WHEN ms.slug = 'new face' THEN 8
                            WHEN ms.slug = 'celebrity' THEN 4
                            WHEN ms.slug = 'direct booking' THEN 2
                            WHEN ms.slug = 'portfolio' THEN 1
                       END
                    )
                ) AS sort
            FROM `user_info` ui
            LEFT JOIN  user_category uc ON uc.info_user_id = ui.id
            LEFT JOIN  model_category mc ON mc.id = uc.category_id
            LEFT JOIN user_subcategory us ON us.info_user_id = ui.id
            LEFT JOIN model_subcategry ms ON ms.id = us.subcategory_id AND ms.category_id = uc.category_id
            WHERE IF(:gender IN ('male', 'female', 'family', 'boy', 'girl'), ui.`gender`=:gender, true) 
                AND IF(:name = '%%', true, ui.name LIKE :name)
                AND ui.`active`= '1'
                {$and}".
                (($subcategory != '') ? " \n AND us.subcategory_id IN ({$subcategory})" : NULL).
                (($ethnicity != '') ? " \n AND IF('{$ethnicity}' = '', true,  ui.ethnicity REGEXP '({$ethnicity})')" : NULL).
                (($specialization != '') ? " \n AND IF('{$specialization}' = '', true,  ui.specialization REGEXP '({$specialization})')" : NULL).
                (($age && $age != 'all') ? " \n AND (ui.birth > {$start} AND ui.birth < {$finish})" : null)."
            GROUP BY ui.id
            {$order}
            {$SQLlimit}
        ";
        
        $params[':actionOld'] = $actionOld;  
        $params[':gender'] = $gender;  
        $params[':action'] = $action;  
        $params[':name'] = "%$filter->name%";  
            
        return Yii::$app->db->createCommand($query, $params)->queryAll(); 
    }
    
    
    public static function NextPrev($id, $action, $items, $urlCat, $filterS){
        
        $gender = '';
        $actionOld = $action;

        if(preg_match("/(male|female|family|boy|girl)(.*)$/", $action, $match)){
            $gender = $match[1];
            $action = $match[2];
        }
        $list = self::getListUniversal($action, $actionOld, $gender, $items, $filterS);
        
        $result = [
            'pre_url' => $urlCat,
            'action' => $actionOld,
            'next_id' => false,
            'prev_id' => false,
        ];
        foreach ($list as $key => $value) {
            if($value['info_user_id'] == $id){
                $result['next_id'] = isset($list[$key+1]) ? $list[$key+1]['info_user_id'] : false;
                $result['prev_id'] = isset($list[$key-1]) ? $list[$key-1]['info_user_id'] : false;
                break;
            }                
        }
        return $result;
    }
    
    public static function getUserInfoFromProfile($id, $menu){
        $query = "
            SELECT ui.id, u.email, ui.height, ui.chest, ui.waist, ui.hips, ui.shoe, ui.hair, ui.eye, mc.short
            FROM user_info ui
            LEFT JOIN `user` u ON u.id = ui.user_id
            LEFT JOIN user_category uc ON uc.info_user_id = ui.id
            LEFT JOIN model_category mc ON mc.id = uc.category_id AND mc.menu = :menu
            WHERE ui.id = :id
        ";
        
        return Yii::$app->db->createCommand($query, [
            ':id'=>$id,
            ':menu'=>$menu,
        ])->queryOne();
    }


    public static function getStringFromArray($array){
        $result = '';
        if($array){
            $i = 0;
            foreach ($array as $key => $value) {
                $result[$i++] = $key;
            }
            $result = implode('|', $result);
        }
        return $result;
    } 


}
