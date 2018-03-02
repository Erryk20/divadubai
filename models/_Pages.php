<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $language
 * @property string $url
 * @property string $name
 * @property string $content
 * @property integer $published
 * @property integer $main
 * @property integer $order
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Page $parent
 * @property Page[] $pages
 * @property Language $language
 */
class _Pages extends \yii\db\ActiveRecord
{
    public $array_video;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
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
            [['parent_id', 'published', 'main', 'order', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['content'], 'string'],
            [['language'], 'string', 'max' => 5],
            [['url'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 255],
            [['language', 'name'], 'unique', 'targetAttribute' => ['language', 'name'], 'message' => 'The combination of Language ID and Name has already been taken.'],
            [['language', 'url'], 'unique', 'targetAttribute' => ['language', 'url'], 'message' => 'The combination of Language ID and Url has already been taken.'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::className(), 'targetAttribute' => ['parent_id' => 'id']],
            [['language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language' => 'short_name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'language' => Yii::t('app', 'Language'),
            'url' => Yii::t('app', 'Url'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'published' => Yii::t('app', 'Published'),
            'main' => Yii::t('app', 'Main'),
            'order' => Yii::t('app', 'Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    
    public static function itemAlias($type, $code = NULL) {
        $_items = [
            'published' => [
                0 => Yii::t('app', 'Inactive'),
                1 => Yii::t('app', 'Active'),
            ],
            'main' => [
                0 => Yii::t('app', 'Inactive'),
                1 => Yii::t('app', 'Active'),
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
    public function getParent()
    {
        return $this->hasOne(Page::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'id']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
    */
   public function getLanguage()
   {
       return $this->hasOne(Language::className(), ['short_name' => 'language']);
   }
    
    
    public function beforeValidate() {
       if(parent::beforeValidate()){
            if ($this->url == ''){
                $this->url = \app\components\TranslitFilter::translitUrl($this->name);
            }
            return true;
        }else
            return false;
    }
    
    
    
    public static function getParsSql($array){
        $menu = [];
        foreach (explode(';', $array) AS $key => $value){
            $item = explode(':', $value);
            $menu[$item[0]] = $item[1];
        }
        
        return $menu;
    }
    
    
    public static function countResultSearch($q, $language){
        $query ="
            SELECT COUNT(p.id) AS 'count'
            FROM pages p
            WHERE p.`name` LIKE :q
            AND p.published = 1
            AND p.content != ''
            AND p.url NOT IN ('basket', 'wine-memories', 'contacts', 'search')
            UNION
            SELECT COUNT(n.id) AS 'count'
            FROM news n
            WHERE n.published = 1
            AND (n.`name` LIKE :q OR n.description LIKE :q)
            UNION
            (
                SELECT COUNT(p.id) AS 'count'
                FROM products p
                LEFT JOIN products_lan pl ON pl.product_id = p.id AND pl.`language` = :language
                LEFT JOIN categories c ON c.id = p.category_id
                LEFT JOIN product_comments pc ON pc.product_id = p.id
                WHERE (pl.`name` LIKE '%a%' OR pl.description LIKE '%a%')
                AND p.published = 1
                AND pl.`name` != ''
                AND pl.description != ''
                AND p.category_id IS NOT NULL
                GROUP BY p.id
            )
            UNION
            (
                SELECT COUNT(p.id) AS 'count'
                FROM products p
                LEFT JOIN products_lan pl ON pl.product_id = p.id AND pl.`language` = :language
                WHERE p.published = 1
                AND (pl.`name` LIKE :q OR pl.description LIKE :q)
                AND pl.`name` != ''
                AND pl.description != ''
                AND p.category_id IS NOT NULL
            )
            UNION
            (
                SELECT COUNT(p.id) AS 'count'
                FROM posts p
                WHERE p.published = 1
                AND (p.`name` LIKE :q OR p.description LIKE :q)
            )
            UNION
            (
                SELECT COUNT(e.id) AS 'count'
                FROM events e
                WHERE e.published = 1
                AND (e.`name` LIKE :q OR e.description LIKE :q)
            )
        ";
        
        $result = [];
        if($q != ''){
            $result = Yii::$app->db->createCommand($query, [
                ':q' => "%{$q}%",
                ':language' => $language
            ])->queryAll();
                
            if(!$result){
                $result = Yii::$app->db->createCommand($query, [
                    ':q' => "%{$q}%",
                    ':language' => 'en'
                ])->queryAll();
            }
        
        }
        $count = 0;
        foreach ($result AS $value) $count += $value['count'];
        
        return $count;
    }
    
    public static function SearchSite($q, $language, $limit = 10, $offset = 0){
        $query ="
            (
                SELECT 
                    'news' AS 'type',
                    n.url AS 'url',
                    '/site/news' AS 'pre_url',
                    n.`like` AS 'likes',
                    COUNT(nc.id) AS 'comments',
                    n.`name`,
                    n.created_at,
                    n.description AS 'description'
                FROM news n
                LEFT JOIN news_comments nc ON nc.news_id = n.id
                WHERE n.published = 1
                AND (n.`name` LIKE :q OR n.description LIKE :q)
                GROUP BY n.id
            )
            UNION
            (
                SELECT 
                    'page' AS 'type',
                    '' AS 'url',
                    p.url AS 'pre_url',
                    '0' AS 'likes',
                    '0' AS 'comments',
                    p.`name`, 
                    p.created_at, 
                    p.content AS 'description'
                FROM pages p
                WHERE p.`name` LIKE :q   
                AND p.published = 1
                AND p.content != ''
                AND p.url NOT IN ('basket', 'wine-memories', 'contacts', 'search')
            )
            UNION
            (
                SELECT 
                    'products' AS 'type',
                    CONCAT('/',c.url, '/', p.url) AS 'url',
                    '/shop/product' AS  'pre_url',
                    '0' AS 'likes',
                    COUNT(pc.id) AS 'comments',
                    pl.`name`,
                    p.created_at,
                    pl.description
                FROM products p
                LEFT JOIN products_lan pl ON pl.product_id = p.id AND pl.`language` = :language
                LEFT JOIN categories c ON c.id = p.category_id
                LEFT JOIN product_comments pc ON pc.product_id = p.id
                WHERE p.published = 1
                AND (pl.`name` LIKE :q OR pl.description LIKE :q)
                AND pl.`name` != ''
                AND pl.description != ''
                AND p.category_id IS NOT NULL
                GROUP BY p.id
            )
            UNION
            (
                SELECT 
                    'post' AS 'type',
                    p.url,
                    '/site/post' AS 'pre_url',
                    IFNULL(p.`like`, 0) AS 'like',
                    COUNT(pc.id) AS 'comments',
                    p.`name`,
                    p.created_at,
                    p.short_description AS 'description'
                FROM posts p
                LEFT JOIN comments pc ON pc.target_id = p.id AND pc.type = 'post'
                WHERE p.published = 1
                AND (p.`name` LIKE :q OR p.description LIKE :q)
                GROUP BY p.id
            )
            UNION
            (
                SELECT 
                    'event' AS 'type',
                    e.url,
                    '/user/event' AS 'pre_url',
                    0 AS 'like',
                    0 AS 'comments',
                    e.`name`,
                    e.created_at,
                    e.description
                FROM events e
                WHERE e.published = 1
                AND (e.`name` LIKE :q OR e.description LIKE :q)
            )
            LIMIT :offset, :limit
        ";
        
        $result = [];
        if($q != ''){
            $result = Yii::$app->db->createCommand(
                $query, 
                [   ':q' => "%{$q}%",
                    ':language'=>$language, 
                    ':limit'=>$limit, 
                    ':offset'=>$offset
                ])->queryAll();
                
            if(!$result){
                $result = Yii::$app->db->createCommand(
                    $query, 
                    [   ':q' => "%{$q}%",
                        ':language'=>'en', 
                        ':limit'=>$limit, 
                        ':offset'=>$offset
                    ])->queryAll();
            }
            
        
        }
        return $result;
    }
    
}
