<?php

namespace app\models;

use Yii;
use kartik\helpers\Html;

/**
 * ContactForm is the model behind the contact form.
 */
class Sinc
{   
    public static function getTable($type){
        $table = '';
        switch ($type){
            case 'stylist'      : $table = 'old_stylist'; break;
            case 'digital'      : $table = 'old_digital'; break;
            case 'directors'    : $table = 'old_directors'; break;
            case 'host'         : $table = 'old_host'; break;
            case 'cast'         : $table = 'old_cast'; break;
            case 'promoter'     : $table = 'old_promoters'; break;
            case 'ourwork'      : $table = 'old_ourwork'; break;
            case 'location'     : $table = 'old_location'; break;
            case 'production'   : $table = 'old_production'; break;
            case 'events'       : $table = 'old_events'; break;
            case 'photographers': $table = 'old_photographers'; break;
            case 'entertainers' : $table = 'old_entertainers'; break;
            case 'model'        : $table = 'old_model'; break;
        }
        return  $table;
    }
    
    public static function getModel($id, $type){
        $table = self::getTable($type);
        $query = "
            SELECT om.*, IFNULL(u.id, 3) AS 'user_id'
            FROM {$table} om
            LEFT JOIN user u ON u.old_id = om.user_id
            WHERE om.id = :id
        ";
        return Yii::$app->db->createCommand($query, [':id'=>$id] )->queryOne();
    }
    
        
    public static function getIdCategory($name, $type){
        
        switch ($type){
            case 'stylist'      : $name = 'Stylists'; break;
            case 'digital'      : $name = 'Influencers'; break;
            case 'directors'    : $name = 'Directors/DOP'; break;
            case 'entertainers' : $name = 'Entertainers'; break;
            case 'events'       : $name = 'Event Support'; break;
            case 'host'         : $name = 'Host'; break;
            case 'host'         : $name = 'Host'; break;
            case 'location'     : $name = 'Locations'; break;
            case 'cast'         : $name = 'Cast'; break;
            case 'promoter'     : $name = 'Promoters'; break;
            case 'model'        : $name = 'models'; break;
            case 'ourwork'      : $name = 'Our works'; break;
            case 'photographers': $name = 'Photographers'; break;
            case 'production'   : $name = 'Post Production'; break;
        }
        
        $parent = '';
        switch ($name){
            case 'Stylists'     : $parent = 'Production'; break;
            case 'Influencers'  : $parent = 'Digital Marketing'; break;
            case 'Directors/DOP': $parent = 'Production'; break;
            case 'Event Support': $parent = 'Events'; break;
            case 'LOCATIONS'    : $parent = 'Locations'; break;
            case 'CAST'         : $parent = 'Cast'; break;
            case 'PROMOTERS'    : $parent = 'Promoters/Activations'; break;
            case 'LOCATIONS'    : $parent = 'Production'; break;
            case 'OUR WORK'     : $parent = 'Our works'; break;
            case 'PHOTOGRAPHERS': $parent = 'Photographers'; break;
            case 'PRODUCTION'   : $parent = 'Production'; break;
        }
        
        $query = "SELECT mc.id
            FROM model_category mc
            LEFT JOIN model_category pmc ON pmc.id = mc.parent_id
            WHERE mc.`name` = '{$name}' 
            AND IF('{$parent}' = '', true, pmc.`name` = '{$parent}')
        ";
            
        $id = Yii::$app->db->createCommand($query)->queryScalar();
        return ($id !== false) ? (int)$id : null;
    }
    
    public static function copyImages($id, $type){
        $table = self::getTable($type);
        
        $image = [
            'image1', 'image2', 'image3', 
            'image4', 'image5', 'image6', 
            'image7', 'image8', 'image9',
            'image10','image11', 'image12', 
            'image13', 'image14', 'image15'
        ];
        
        $polaroid = ['polaroid_1', 'polaroid_2', 'polaroid_3'];
        $catwalk = ['catwalk_1', 'catwalk_2', 'catwalk_3'];
        $showreel = ['showreel_2', 'showreel_3', 'showreel_4', 'showreel_5', 'showreel_1']; // 
            
        
        $field = '';
        switch ($type){
            case  'stylist'         : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'digital'         : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'directors'       : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'events'          : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'host'            : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'cast'            : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'promoter'        : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'ourwork'         : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'model'           : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'location'        : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'events'          : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'entertainers'    : $field = implode(',', array_merge($image, $polaroid, $catwalk, $showreel)); break;
            case  'photographers'   : $field = implode(',', array_merge($image, $catwalk, $showreel)); break;
            case  'production'      : $field = implode(',', array_merge($image, $catwalk)); break;
        }
        
//        vd($type, false);
//        vd($field);
//        --, ui.id, mc.`name` AS 'category',
        $query = "
            SELECT {$field}
            FROM user_info ui
            LEFT JOIN model_category mc ON mc.id = ui.category_id
            LEFT JOIN {$table} o ON o.id = ui.old_id
            WHERE ui.id = :id
            -- AND mc.`name` LIKE :type
        ";
        $modelOld = Yii::$app->db->createCommand($query, [':id'=>$id] )->queryOne();
        
//        vd($modelOld);
        
        //$id = array_shift($modelOld);
        //$category = array_shift($modelOld);
        
        $result = [];
        $i = 0;
        foreach ($modelOld as $key => $value) {
            if($value != '' && preg_match("/^(image|polaroid|catwal|showreel).*$/ui", $key, $match)){
                
                $name = preg_replace("/(\+)/", ' ', $value);
                
                $url = "http://www.divadubai.com/backend/web/{$type}/".(rawurlencode($value));
                $pathOld = Yii::getAlias("@webroot/../Diva/dev/backend/web/{$type}/{$value}");
                $pathNew = Yii::getAlias("@webroot/images/user-media/{$name}");
                
                $model = new \app\models\UserMedia();
                $model->info_user_id = $id;
                $model->type = $match[1];
                $model->src = $name;
                
//                $headers = get_headers($url);
//                vd($pathOld, false);
//                vd($url, false);
//                vd($headers, false);
//                vd(file_exists($pathOld));
                if (
                    file_exists($pathOld) 
                    && rename($pathOld, $pathNew)
                ) {
                    $model->save();
                }elseif(
                    ($headers = get_headers($url)) 
                    && !preg_match("/40\d/", $headers[0]) 
                    && copy($url, $pathNew)
                ){
                    $model->save();
                }
            };
        }
        return TRUE;
    }


    
    public static function setCreateCopyModel($modelOld, $type){
//        $model->? = $modelOld['availability']; Available/Not Available/Blacklisted
//        $model->hair = $modelOld['hair_color'];
        
        $model = new UserInfo(['scenario'=>'registration']);

        $model->old_table = self::getTable($type);
        $model->user_id = $modelOld['user_id'];
        
        $model->subcategory     = json_encode(explode(',', mb_strtolower($modelOld['subcategory'])));
        $model->specialization  = explode(',', mb_strtolower($modelOld['specialization']));
        $model->city            = [mb_strtolower($modelOld['city'])];
        $model->ethnicity       = [mb_strtolower($modelOld['ethncity'])];
        $model->language        = explode(',', mb_strtolower($modelOld['language']));
        $model->category_id = Sinc::getIdCategory($modelOld['category'], $type);
        $model->old_id = $modelOld['id'];
        $model->name = $modelOld['first_name'];
        $model->last_name = $modelOld['last_name'];
        $model->gender = $modelOld['gender'];
        $model->birth = $modelOld['dob'];
        $model->active = $modelOld['status'];
        $model->phone = $modelOld['mobile_no'];
        $model->phone2 = $modelOld['alt_no'];
        $model->email = $modelOld['email'];
        $model->nationality = $modelOld['nationality'];
        $model->address = $modelOld['address'];
        $model->country = $modelOld['country'];
        $model->height = (string)round($modelOld['height']);
        $model->weight = round($modelOld['weight']);
        $model->collar = (int)$modelOld['collar'];
        $model->chest = round(trim($modelOld['chest']));
        $model->waist = round($modelOld['waist']);
        $model->hips = (string)round(trim($modelOld['hips']));
        $model->shoe = (int)$modelOld['shoe'];
        $model->suit = trim($modelOld['suit']);
        $model->pant = str_replace(" ", '', $modelOld['pant']);
        $model->hair = mb_strtolower($modelOld['hair']);
        $model->hair_length = $modelOld['hair_length'];
        $model->eye = mb_strtolower($modelOld['eye']);
        $model->visa_status = $modelOld['visa_status'];
        $model->created_at = strtotime($modelOld['date']);
        $model->remark = $modelOld['remark'];
        
        
//        vd($modelOld, false);
//        vd($model);
        
        $fields = [];
        foreach ($model->attributes as $key => $value) {
            if($value != '' && !in_array($key, ['birth','phone', 'phone2', 'email'])){
                $fields[] = $key;
            }
        }
   
        if($model->validate($fields)){
            return [
                'status'=>$model->save(false), 
                'id'=>$model->id
            ];
        }else{
            return [
                'status'=>false, 
                'message'=> $model->getErrors()
            ];
        }
        
    }
    
    public static function getFields($path){
        $result = [];
        if ($handle = opendir($path)) {
            while (false !== ($entry = readdir($handle))) {
                if(!in_array($entry, ['.', '..', 'video', 'awards'])){
                    $result[] = $entry;
                }
            }
            closedir($handle);
        }
        return $result;
    }
    
    public static function deleteImg($path, $listDB){
        $listField = self::getFields($path);
        
        $delete = array_diff($listField, $listDB);
        
        foreach ($delete as $value) {
            if($value != 'diva-logo.png'){
                unlink("{$path}/{$value}");
            }
        }
        return true;
    }
    
    /**
     * copy from fieldOld to fieldNew
     * @param type $pathFrom - path from images Old
     * @param type $pathTo - path to images new
     */
    public static function copyAllImages($pathFrom, $pathTo){
        $listField = self::getFields($pathFrom);
        foreach ($listField as $value) {
            $from = "{$pathFrom}/$value";
            $to = "{$pathTo}/$value";
            
            vd(copy($from, $to), false);
        }
    }

        /**
     * Переноси пользователя с одной категории в другую
     * @param type $from_id
     * @param type $to_id
     */
    public static function moveCategory($from_id, $to_id){
        $list = UserInfo::find()
                ->where(['category_id' => $from_id])
                ->all();
        
        foreach ($list as $value) {
            $value->scenario = 'registration';
            $value->category_id = $to_id;
            vd($value->save(false),false);
        }
        
    }
    
    
    
    
    
}