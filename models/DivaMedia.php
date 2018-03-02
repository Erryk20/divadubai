<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "diva_media".
 *
 * @property int $id
 * @property int $diva_id
 * @property string $title
 * @property string $slug
 * @property string $img
 * @property int $order
 *
 * @property Diva $diva
 */
class DivaMedia extends \yii\db\ActiveRecord
{
    public $file;
    
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
    public static function tableName()
    {
        return 'diva_media';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['diva_id', 'title', 'slug'], 'required'],
            [['diva_id', 'order'], 'integer'],
            [['title', 'slug', 'img'], 'string', 'max' => 50],
            [['diva_id'], 'exist', 'skipOnError' => true, 'targetClass' => Diva::className(), 'targetAttribute' => ['diva_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'diva_id' => 'Diva ID',
            'title' => 'Title',
            'slug' => 'Url',
            'img' => 'Img',
            'order' => 'Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiva()
    {
        return $this->hasOne(Diva::className(), ['id' => 'diva_id']);
    }
    
    public static function getBooksId($diva_id){
        $query = self::find()
                ->select(['id','title'])
                ->where(['diva_id'=>$diva_id])
                ->orderBy('title')
                ->asArray();
        
        return  [0 =>'(not set)'] + ArrayHelper::map($query->all(), 'id', 'title');
    }
    
    
//    public static function getList($diva_url, $divaMediaUrl, $limit, $offset, $filter){
//        
//        $ethnicity = self::getStringFromArray($filter['ethnicity']);
//        $specialization = self::getStringFromArray($filter['specialization']);
//       
//        $query = "
//            SELECT dm.short, d.title, d.url, dm.title, 
//                dm.url, du.info_user_id, '/site/diva' AS pre_url, ui.`name`,
//            IFNULL(
//            (
//                SELECT src
//                FROM user_media
//                WHERE info_user_id = du.info_user_id
//                AND `type` = 'image'
//                ORDER BY `order` ASC
//                LIMIT 1
//            ), 'diva-logo.png') AS 'src'
//            
//            FROM diva d
//            LEFT JOIN diva_media dm ON dm.diva_id = d.id
//            LEFT JOIN diva_user du ON du.diva_media_id = dm.id
//            LEFT JOIN user_info ui ON ui.id = du.info_user_id
//
//            WHERE d.url = :diva_url
//            AND IF(:name = '', true, ui.name LIKE :name)
//            AND dm.url = :diva_m_url".
//            (($ethnicity != '') ? " \n AND IF('{$ethnicity}' = '', true,  ui.ethnicity REGEXP '({$ethnicity})')" : NULL).
//            (($specialization != '') ? " \n AND IF('{$specialization}' = '', true,  ui.specialization REGEXP '({$specialization})')" : NULL).
//            " ORDER BY du.order ASC".
//            " LIMIT :offset, :limit";
//            
//        return Yii::$app->db->createCommand($query, [
//            ':diva_url' => $diva_url,
//            ':name' => "%$filter->name%",
//            ':diva_m_url' => $divaMediaUrl,
//            ':limit' => $limit,
//            ':offset' => $offset,
//        ])->queryAll();
//    }
    
    
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
    
    
    
    public static function getListCategoryDivaMedia($parent_id, $pre_url){
        $query = "
            SELECT id, parent_id, `name` AS 'title', slug AS url, img, :pre_url AS 'pre_url'
            FROM model_category
            WHERE parent_id = :parent_id
            ORDER BY `order` ASC
        ";
        
        $list = Yii::$app->db->createCommand($query, [
            ':parent_id' => $parent_id,
            ':pre_url' => $pre_url,
        ])->queryAll();
        
        $parent = [];
        foreach ($list as $value) {
            $parent[$value['id']] = $value;
        }
        
        
        $listID = [];
        foreach ($list as $value) {
            $listID[] = (int)$value['id'];
        }
        
        if(!empty($listID)){
            $listID = implode(',', $listID);
            
            $query = "
                    SELECT id, parent_id, `name` AS 'title', slug AS url, img, '/site/production' AS 'pre_url'
                    FROM model_category
                    WHERE parent_id IN ({$listID})
                ";
                    
            $listChildren = Yii::$app->db->createCommand($query)->queryAll();
            
            foreach ($listChildren as $value) {
                if(isset($parent[$value['parent_id']])){
                    unset($parent[$value['parent_id']]);
                }
            }
           $parent = array_merge($parent, $listChildren);
        }
        
        $result = [];
        foreach ($parent as $value) {
            $result[$value['url']] = $value;
        }
        
        return $result;
    }

}
