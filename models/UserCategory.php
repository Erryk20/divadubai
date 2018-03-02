<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_category".
 *
 * @property int $id
 * @property int $category_id
 * @property int $info_user_id
 * @property string $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UserInfo $infoUser
 * @property ModelCategory $category
 */
class UserCategory extends \yii\db\ActiveRecord
{
    
    public $category_name;
    public $activies;
    
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'info_user_id'], 'required'],
            [['info_user_id', 'created_at', 'updated_at'], 'integer'],
            [['active'], 'string'],
            [['category_id'], 'safe'],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']],
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
            'info_user_id' => 'Info User ID',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfoUser()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'info_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ModelCategory::className(), ['id' => 'category_id']);
    }
    
    
    public static function separator($model){
        $query = "
            SELECT id, category_id, active
            FROM user_category
            WHERE info_user_id = :user_id
        ";
        
        $list = Yii::$app->db->createCommand($query, [":user_id"=>$model->info_user_id])->queryAll();
        
        $oldCategory = [];
        foreach ($list as $value) {
            $oldCategory[] = $value['category_id'];
        }
        
        $model->category_id = ($model->category_id == '' || $model->category_id == null) ? [] : $model->category_id;
        
        // create category
        foreach (array_diff($model->category_id, $oldCategory) AS $value){
            $Umodel = new \app\models\UserCategory();
            $Umodel->category_id = $value;
            $Umodel->info_user_id = $model->info_user_id;
            $Umodel->active = '1';
            $Umodel->save();
        };
        
        foreach (array_diff($oldCategory, $model->category_id) AS $value){
            $Umodel = \app\models\UserCategory::findOne([
                'category_id' => $value,
                'info_user_id' => $model->info_user_id
            ]);
           $Umodel->delete();
        };
    }




    public function setListVallue($user_info_id){
        $query = "
            SELECT uc.id, uc.category_id, uc.active, mc.`name` AS category_name
            FROM user_category uc
            LEFT JOIN model_category mc ON mc.id = uc.category_id
            WHERE uc.info_user_id = :user_id
        ";
        
        $list = Yii::$app->db->createCommand($query, [':user_id'=>$user_info_id])->queryAll();
        
        
        $categories = [];
        foreach ($list as $value) {
            $categories[] = $value['category_id'];
        }
        
        $this->category_id = $categories;
        $this->info_user_id = $user_info_id;
        
    }
    
    public static function getListCategoriesFromUser($id){
        $query = "
            SELECT category_id
            FROM user_category
            WHERE info_user_id = :info_user_id
        ";
        $list = \Yii::$app->db->createCommand($query, ['info_user_id'=>$id])->queryAll();

        $result = [];
        foreach ($list as $value) {
            $result[] = $value['category_id'];
        }
        return $result;
    }
    
    public static function getListCategoriesNameFromUser($id){
        $query = "
            SELECT mc.id, mc.name
            FROM user_category uc
            LEFT JOIN model_category mc ON mc.id = uc.category_id
            WHERE uc.info_user_id = :info_user_id
        ";
        $list = \Yii::$app->db->createCommand($query, ['info_user_id'=>$id])->queryAll();
        
        return \yii\helpers\ArrayHelper::map($list, 'id', 'name');
    }
    
    
    public static function listUsersFromCategory($action, $filter, $limit, $ofsset){
        $query = "
            SELECT uc.category_id, uc.info_user_id,
            mc.slug AS url,  mc.short AS short, uc.info_user_id, 
            '/site/diva' AS pre_url,
            IFNULL((
                SELECT src
                FROM user_media
                WHERE info_user_id = uc.info_user_id
                AND `type` = 'image'
                ORDER BY `order` ASC
                LIMIT 1
            ), 'diva-logo.png') AS 'src',
            (
                SELECT GROUP_CONCAT(CONCAT('\"', subcategory_id, '\"') SEPARATOR ',')
                FROM user_subcategory
                WHERE info_user_id = uc.info_user_id
            ) AS subcategory

            FROM user_category uc
            LEFT JOIN model_category mc ON mc.id = uc.category_id
            WHERE uc.active = '1'
        ";
        
        $list = \Yii::$app->db->createCommand($query, [])->queryAll();
        
        vd($list);
                
    }
    
    public static function getNextLastUserGender($info_user_id, $categoryP, $gender, $list){
//        Yii::$app->db->createCommand("
//            SET @i := 0;
//            SET @key := null;
//        ")->execute();
        
//        $query = "
//            SELECT us.*, ui.gender
//            FROM (
//                SELECT @i := (@i + 1) AS 'i', IF(uc.info_user_id = :info_user_id, @key :=@i, null) AS 'resut', uc.info_user_id
//                FROM user_category uc
//                WHERE uc.category_id = :category_id
//                AND uc.active = '1'
//                ORDER BY uc.created_at
//            ) AS us
//            LEFT JOIN user_info ui ON ui.id = us.info_user_id
//            WHERE us.i IN (@key-1, @key, @key+1)
//        ";
        
        $query = "
            SELECT us.*, us.gender
            FROM (
                SELECT @i := (@i + 1) AS 'i', IF(ui.id = :info_user_id, @key :=@i, null) AS 'resut', 
                    ui.id, ui.gender, uc.created_at
                FROM model_category mc
                LEFT JOIN user_category uc ON uc.category_id = mc.id
                LEFT JOIN user_info ui ON ui.id = uc.info_user_id
                WHERE (mc.id IN (4,46,47,48,49) OR mc.parent_id IN (4,46,47,48,49))
                AND ui.gender = :gender
                AND uc.id IS NOT NULL
                AND ui.active = '1'
                ORDER BY uc.created_at ASC
            ) AS us
            WHERE us.i IN (@key-1, @key, @key+1)
      ";
        
//        $request = Yii::$app->db->createCommand($query, [
////            ':categoryP' => $categoryP,
//            ':gender' => $gender,
//            ':info_user_id' => $info_user_id,
//        ])->queryAll(); 
        
        $key = false;
        $result = [
            'gender' => NULL,
            'next_id' => false,
            'prev_id' => false,
        ];
        
        
//        foreach ($request as $value) {
//            if($key === false && $value['resut'] === null){
//                $result['next_id'] = $value['id'];
//                $result['gender'] = $value['gender'];
//            }elseif($key === false && $value['resut'] != null){
//                $key = true;
//            }elseif($key === true && $value['resut'] === null){
//                $result['prev_id'] = $value['id'];
//                $result['gender'] = $value['gender'];
//            }
//        }
        
        return $result;
    }
    
    
    public static function getNextLastUserCategory($info_user_id, $category, $action){
        Yii::$app->db->createCommand("
            SET @i := 0;
            SET @key := null;
        ")->execute();
        
        $query = "
            -- IF(:type IN ('malecasts', 'femalecasts', 'familycasts'), sh.short, mc.short) AS short
            SELECT us.* 
            FROM (
                SELECT mc.slug, @i := (@i + 1) AS 'i', IF(uc.info_user_id = :info_user_id, @key :=@i, null) AS 'resut', uc.info_user_id
                FROM user_category uc
                LEFT JOIN model_category mc ON mc.id = uc.category_id
                LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
                WHERE mc.slug = :action
                AND pmc.slug = :category
                AND uc.active = '1'
                ORDER BY uc.created_at DESC
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
            'url' => NULL,
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
            $result['url'] = $value['slug'];
        }
        return $result;
    }
}
