<?php
namespace app\models;


use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SearchForm extends Model
{
    public $search;
    public $result = [];
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['search'], 'required'],
        ];
    }
    
      /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'search' => 'Search'
        ];
        
    }
    
    public static function getUserInfo($id){
        $query = "
            SELECT 
                ui.id,
                ui.email,
                ui.user_id,
                ui.height, 
                ui.chest, 
                ui.waist, 
                ui.hips, 
                ui.shoe, 
                ui.hair, 
                ui.eye, 
                'SE' AS short
            FROM user_info ui
            WHERE ui.id = :id
        ";
        
        return Yii::$app->db->createCommand($query, [':id'=>$id])->queryOne();
    }
    
    public static function resultSearch($q){
        $query = "
            SELECT ui.id, TRIM(CONCAT(COALESCE(`name`,''), ' ', COALESCE(`last_name`,''))) AS 'text',
                CONCAT('/profile/', ui.id) AS 'url'
            FROM user_info ui
            WHERE `name` LIKE :q OR last_name LIKE :q
        ";
        
        return \Yii::$app->db->createCommand($query, [':q'=>"%$q%"])->queryAll();
    }
    
    public static function resultSearchUser($q){
        $query = "
            SELECT id, username AS text
            FROM `user`
            WHERE `username` LIKE :q
        ";
        return \Yii::$app->db->createCommand($query, [':q'=>"%$q%"])->queryAll();
    }
    
    
    
    public static function getCountAllSearch($q, $categoryID){
        
        $short = '';
        $id = '';
        if(preg_match('/(\w+)\*\.(\d+)/', $q, $march)){
            list($q, $short, $id)  = $march;
        }
        
        $query = "
            SELECT 'user' AS type, COUNT(ui.id) AS 'count', CONCAT(COALESCE(mc.short, ''), '*.', ui.id) AS 'name'
            FROM user_info ui
            LEFT JOIN user_category uc ON uc.info_user_id = ui.id
            LEFT JOIN model_category mc ON mc.id = uc.category_id
            WHERE ui.active = '1'
            AND( 
                IF('{$categoryID}' != '', uc.category_id IN($categoryID), true)
            ) AND (
                ui.id = :id OR
                mc.`name` LIKE :category OR
                (mc.short = :short AND ui.id = :user_id) OR
                ui.nationality LIKE :nationality OR
                (:id = '')
            )
            UNION
            SELECT 'blog' AS type, COUNT(id) AS 'count', '' AS 'name'
            FROM blogs
            WHERE (title LIKE :title OR description LIKE :description)
        ";
        
        $q = trim($q);
        
        $list = [];
        if($q != '' || $categoryID != ''){
            $list = Yii::$app->db->createCommand($query, [
                ':id' => $q,
                ':category' => "%{$q}%",
                ':nationality' => "%{$q}%",
                ':title' => "%{$q}%",
                ':description' => "%{$q}%",
                ':short' => $short,
                ':user_id' => $id,
            ])->queryAll();
        }
        
        $count = 0;
        foreach ($list as $value) {
            $count += (int)$value['count'];
        }
        
        return $count;
    }

    

    public static function searchAll ($q, $categoryID, $limit, $offset = 0){
        $short = '';
        $id = '';
        if(preg_match('/(\w+)\*\.(\d+)/', $q, $march)){
            list($q, $short, $id)  = $march;
        }
        
        $query = "
            (
                SELECT  'user' AS 'type', CONCAT(COALESCE(mc.short, ''), '*.', ui.id) AS 'name', 
                mc.`name` AS field1, ui.nationality AS fied2,  
                CONCAT(
                    IFNULL(
                        CASE uc.category_id
                            WHEN 4 THEN 'model-management'
                            WHEN 41 THEN 'our-work'
                        END,
                        CASE mc.parent_id
                            WHEN 16 THEN 'production'
                            WHEN 5 THEN 'promotions-activations'
                            WHEN 7 THEN 'events'
                            WHEN 39 THEN 'digital-marketing'
                            WHEN 41 THEN 'our-work'
                        END
                        ), '/',
                    mc.slug, '/', ui.id
                ) AS slug,
                IFNULL(
                    (
                        SELECT CONCAT('/images/user-media/', src)
                        FROM user_media
                        WHERE info_user_id = ui.id
                        AND `type` IN ('image', 'polaroid')
                        ORDER BY `order`
                        LIMIT 1
                    ), 
                    'diva-logo.png'
                ) AS logo, null AS 'description'
                FROM user_info ui
                LEFT JOIN user_category uc ON uc.info_user_id = ui.id
                LEFT JOIN model_category mc ON mc.id = uc.category_id
                WHERE ui.active = '1'
                AND( 
                    IF('{$categoryID}' != '', uc.category_id IN($categoryID), true)
                ) AND (
                    ui.id = :id OR
                    mc.`name` LIKE :category OR
                    (mc.short = :short AND ui.id = :user_id) OR
                    ui.nationality LIKE :nationality OR
                    (:id = '')
                )
                HAVING slug IS NOT NULL
            )
            UNION
            (
                SELECT 'blog' AS 'type', title AS 'name', 
                    null AS 'field1', 
                    created_at AS fied2, 
                    CONCAT('/blog/', id) AS 'slug', 
                    CONCAT('/images/blog/',src) AS 'logo',
                    description
                FROM blogs
                WHERE (title LIKE :title OR description LIKE :description)
            )
            LIMIT :offset, :limit
        ";
        
        $list = [];
        if($q != '' || $categoryID != ''){
            $list = Yii::$app->db->createCommand($query, [
                ':id' => $q,
                ':category' => "%{$q}%",
                ':nationality' => "%{$q}%",
                ':title' => "%{$q}%",
                ':description' => "%{$q}%",
                ':short' => $short,
                ':user_id' => $id,
                'offset' => $offset,
                'limit' => $limit,
            ])->queryAll();
        }
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$key] = $value;
            if($value['type'] != 'user'){
                $result[$key]['description'] = mb_strimwidth(strip_tags($result[$key]['description']), 0, 200, "...");
            }
        }
        
        return $result;
    }
   
}
