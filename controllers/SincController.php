<?php
namespace app\controllers;

use Yii;
//use app\components\Controller;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Url;
use app\models\Sinc;
use app\models\UserInfo;

class SincController extends Controller {
    
    
    /**
     * model ourwork photographers production promoter cast
     * location events entertainers directors digital
     * host
     * stylist
     * 
     * jobs booking user sitelogin
     */
    public function actionIndex(){
        $type = 'stylist';
        $table = Sinc::getTable($type);

        $query = "
            SELECT om.`id`
            FROM `{$table}` om
            LEFT JOIN user_info ui ON ui.old_id = om.id AND ui.old_table = '{$table}'
            WHERE ui.id IS NULL
            ORDER BY id
            -- LIMIT 2000
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
//        die();
//        Sinc::copyImages(7499, $type); die();
        
//        foreach ($list as $value) {
//            $modelOld = Sinc::getModel($value['id'], $type);
//            $result = Sinc::setCreateCopyModel($modelOld, $type);
////            vd($result);
//            $image = Sinc::copyImages($result['id'], $type);
//        }
    }
    
    public function actionAddSubcategory(){
        \app\models\TempSubcategory::setTempSubcategory();
        
        $query = "
            SELECT ui.id, ui.old_table, ui.old_id, 
                GROUP_CONCAT(ui.category_id SEPARATOR ', ') AS 'category_id', 
                GROUP_CONCAT(CONCAT(mc.`name`, ':', ui.subcategory) SEPARATOR '; ') AS 'sub', ui.subcategory, count(ui.id) AS '_count'
            FROM user_info ui
            LEFT JOIN model_category mc ON mc.id = ui.category_id
            WHERE ui.subcategory IS NOT NULL
            AND ui.old_table  IS NOT NULL
            AND ui.subcategory != '[\"\"]'
            GROUP BY ui.subcategory
            HAVING _count > 1
        ";
        
        $list = Yii::$app->db->createCommand($query)->queryAll();
        
        $result = [];
        foreach ($list as $key => $value) {
            $result[$key] = $value;
            $result[$key]['sub'] = explode(';', $value['sub']);
        }
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        die();
//        vd($list);
    
        
        
    }
    
    public function actionDeleteImg(){
        
        $list = \app\models\UserMedia::find()
                ->select('src')
                ->where(['!=', 'type', 'catwalk'])
                ->andWhere(['!=', 'type', 'showreel'])
                ->andWhere(['!=', 'src', ''])
                ->asArray()
                ->all();
        
        $listDB = [];
        foreach ($list as $value) {
            $listDB[] = $value['src'];
        }
        $path = Yii::getAlias("@app/images/user-media");
        
        return Sinc::deleteImg($path, $listDB);
    }
    
    
    public function actionListFile(){
        $path = Yii::getAlias("@webroot/../Diva/dev/backend/web/model");
//        backend/web/model/
        $listField = Sinc::getFields($path);
        
        $result = [];
        $i = 0;
        foreach ($listField as $value) {
//            if($i++ < 20){
//                $result[] = $value;
//            }
            if(preg_match('/^john/', $value)){
                $result[] = $value;
            }
        }
        
        vd($result, false);
        vd($path);
    }
    
    
    public function actionDeletDubleMedia(){
        $query = "
            SELECT GROUP_CONCAT(id SEPARATOR ',') AS 'list', count(id) AS 'CN'
            FROM user_media
            GROUP BY info_user_id, src
            having CN > 1
        ";
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        vd($list);



        foreach ($list as $value) {
            $item = explode(',', $value['list']);
//            vd($item, false);
            
            unset($item[0]);
            
            $query = "DELETE FROM user_media WHERE id IN (".(implode(',', $item)).")";
            $result = \Yii::$app->db->createCommand($query)->execute();
            

            vd($result, false);
        }
        
        vd($list);
    
        
    }
    
    
    public function actionDeletDubleTalent(){
        $query = "
            SELECT  GROUP_CONCAT(id SEPARATOR ',') AS 'list', count(id) AS 'CN'
            FROM user_info
            WHERE old_id IS NOT NULL
            GROUP BY old_table, old_id
            having CN > 1
        ";
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
//        vd($list);
        foreach ($list as $value) {
            $item = explode(',', $value['list']);
            unset($item[0]);
            
            $query = "DELETE FROM user_info WHERE id IN (".(implode(',', $item)).")";
            
            $result = \Yii::$app->db->createCommand($query)->execute();
            vd($result, false);
        }
        return true;
    }
    
    public function actionVideo(){
        $query = "
            SELECT ui.id, video1, video2, video3, video4, video5, video6, video7, video8, video9, old.id AS 'old'
            FROM old_stylist old
            LEFT JOIN user_info ui ON ui.old_table = 'old_stylist' AND ui.old_id = old.id
            WHERE (
                video1 != ''
                OR video2 != ''
                OR video3 != ''
                OR video4 != ''
                OR video5 != ''
                OR video6 != ''
                OR video7 != ''
                OR video8 != ''
                OR video9 != ''
            )
        ";
        
        $list = \Yii::$app->db->createCommand($query)->queryAll();
        
        foreach ($list as $value) {
            vd($value['id'], false);
//            vd($value['old'], false);
            foreach ($value as $key => $item) {
                if($item != '' && preg_match("/video\d/", $key)){
                    vd($item, false);

                    $item = explode(' ', $item);
                    foreach ($item as $val) {
                        if($val != ''){
                            
//                            vd($val, false);
                            $media = new \app\models\UserMedia();
                            $media->type = 'catwalk';
                            $media->info_user_id = $value['id'];
                            
                            if(preg_match('/vimeo/', $val)){
                                if(preg_match("/(https?:\/\/vimeo.com\/(\d+))/", $val, $match)){
                                    $media->src = $match[2];
                                    vd($match, false);
//                                    vd($media->save(), false);
                                }
                            }elseif(preg_match('/youtu/', $val)){

                                if(!preg_match("/(channel|playlist|user)/", $val)){
                                    if(preg_match("/(https?:\/\/(www\.)?.+?((\?v=)?((-|\w){11})))/", $val, $match)){
                                        $media->src = $match[5];
                                        vd($match, false);
//                                        vd($media->save(), false);
                                    }
                                }
                            }
                        }
                    }
                    
                }
            }
        }
        
        
        vd($list, 10);
    } 
    
    
    public function actionIsYoutube(){
        $list = \app\models\UserMedia::find()
                ->select(['id', 'type', 'src', 'isset'])
                ->where(['type' => ['catwalk', 'showreel']])
                ->andWhere(['isset' => '0'])
//                ->andWhere(['NOT REGEXP', 'src', '^(0|1|2|3|4|5|6|7|8|9)+$'])
                ->asArray()
//                ->limit('20')
                ->all();
        
        $APIKEY = 'AIzaSyCY4uyTKkS0s-vwNA610XhnFZP9cFNe00I';
        
        foreach ($list as $value) {
            if(!preg_match("/^\d+$/", $value['src'])){
                $ytapi = file_get_contents("https://www.googleapis.com/youtube/v3/videos?part=id&id={$value['src']}&key={$APIKEY}");
                $json = json_decode($ytapi, true);

                $value->isset = (count($json['items']) == 0) ? '-1' : '1';
            }else{
                $value->isset = '1';
            }
            
            vd($value->save(), false);
        }
        die_my();
    }
    
    
    public function actionTemp(){
        $query = \app\models\UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                ->andWhere(['active' => '1'])
                ->orderBy(['name' => SORT_ASC])
                ->asArray();
        
        
        $query  ->andFilterWhere(['like', 'subcategory', 'international'])
                ->andFilterWhere(['availability' => '1']);
//                ->All();
//                
        vd($query->createCommand()->getSql());

        $query2 = $query->andFilterWhere(['like', 'subcategory', 'model 1'])
                    ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                    ->andFilterWhere(['availability' => '1'])
                    ->All();
        vd($query2);
        
        
        $query3 =UserInfo::find()->andWhere(['gender' => 'female'])
            ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
            ->andFilterWhere(['like', 'subcategory', 'model 2'])
            ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
            ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
            ->andFilterWhere(['availability' => '1'])
            ->andWhere(['active' => '1'])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->All();
        vd($query3);
        
        $query4 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                ->andFilterWhere(['like', 'subcategory', 'New Face'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['availability' => "1"])
                ->andWhere(['active' => '1'])
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->All();
        vd($query4);

        $query5 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'celebrity'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'New Face'])
                
                ->orderBy(['name' => SORT_ASC])
                ->andFilterWhere(['availability' => "1"])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query5);
        
        $query6 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'Direct Booking'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'New Face'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'celebrity'])
                
                ->orderBy(['name' => SORT_ASC])
                ->andFilterWhere(['availability' => "1"])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query6);
        
        $query7 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'portfolio'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'New Face'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'Direct Booking'])
                
                ->orderBy(['name' => SORT_ASC])
                ->andFilterWhere(['availability' => "1"])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query7);
        
        $query8 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'international'])
                ->andFilterWhere(['availability' => "0"])
                
                ->orderBy(['name' => SORT_ASC])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
        
        vd($query8);
        
        $query9 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['availability' => "0"])
                
                ->orderBy(['name' => SORT_ASC])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
        
        vd($query9);
        
        $query10 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'model 2'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['availability' => "0"])
                
                ->orderBy(['name' => SORT_ASC])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query10);
        
        $query11 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'New Face'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['availability' => "0"])
                
                ->orderBy(['name' => SORT_ASC])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query11);
        
        $query12 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'celebrity'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'New Face'])
                ->andFilterWhere(['availability' => "0"])
                
                ->orderBy(['name' => SORT_ASC])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query12);
        
        $query13 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'Direct Booking'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'New Face'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'celebrity'])
                ->andFilterWhere(['availability' => "0"])
                
                ->orderBy(['name' => SORT_ASC])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query13);
        
        $query14 = UserInfo::find()
                ->select(['id', 'old_table', 'old_id', 'subcategory', 'gender', 'availability', 'active', 'name'])
                ->andWhere(['gender' => 'female'])
                
                ->andFilterWhere(['like', 'subcategory', 'portfolio'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'international'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 1'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'model 2'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'New Face'])
                ->andFilterWhere(['NOT LIKE', 'subcategory', 'Direct Booking'])
                ->andFilterWhere(['availability' => "0"])
                
                ->orderBy(['name' => SORT_ASC])
                ->andWhere(['active' => '1'])
                ->asArray()
                ->All();
//        
//        vd($query14);
        
        








//        $pathFrom = Yii::getAlias("@webroot/../Diva/dev/backend/web/award");
        $pathFrom = Yii::getAlias("@webroot/../Diva/dev/frontend/controllers");
        
        $pathTo = Yii::getAlias("@webroot/delete/frontend/controllers");

//        $result = Sinc::copyAllImages($pathFrom, $pathTo);
        
        $listField = Sinc::getFields($pathFrom);
        vd($listField);

//        foreach ($listField as $value) {
//            $model = new \app\models\Awards();
//            $model->img = $value;
//            $model->save(false);
//        }
        

        
        vd($listField);

        die_my();




        
        foreach ($listField as $value) {
            $pathOld = Yii::getAlias("@webroot/../Diva/dev/backend/web/clients/{$value}");
            $pathNew = Yii::getAlias("@webroot/images/clients/{$value}");
            vd(copy($pathOld, $pathNew), false);
            vd($value, false);
        }
        
        
        vd($listField, false);
            
            
    }

}
