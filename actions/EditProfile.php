<?php

namespace app\actions;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\web\ViewAction;
use Yii;

/**
 * Description of MyAction
 *
 * @author PC
 */
class EditProfile extends ViewAction {
    
    protected function render($viewName){
        \Yii::$app->controller->layout = 'registration';
        
        $post = \Yii::$app->request->post('UserMedia');
        
        $info_user_id = \Yii::$app->request->get('id', 113);
        
        if(isset($post['src'])){
            if(isset($post['src']['polaroid'])){
                foreach ($post['src']['polaroid'] as $key => $value) {
                    if($value != ''){
                        if(is_array($value) && !empty($value)){
                            $userMedia = \app\models\UserMedia::findOne($key);
                            $item = array_shift($value);
                            if($userMedia->src != $item){
                                $userMedia->src = $item;

                                if($userMedia->save()){
                                    $nawDate = date('Y-m-d', time());
                                    $path = \Yii::getAlias("@webroot/temp/user-media/{$nawDate}/{$userMedia->src}");
                                    $result = Yii::getAlias("@webroot/images/user-media/{$userMedia->src}");
                                    copy($path, $result);
                                }
                            }
                        }else{
                            $userMedia = new \app\models\UserMedia();
                            $userMedia->src = $value;
                            $userMedia->type = 'polaroid';
                            $userMedia->info_user_id = $info_user_id;

                            if ($userMedia->save()) {
                                $nawDate = date('Y-m-d', time());
                                $path = \Yii::getAlias("@webroot/temp/user-media/{$nawDate}/{$userMedia->src}");
                                $result = Yii::getAlias("@webroot/images/user-media/{$userMedia->src}");
                                copy($path, $result);
                            }
                        }
                    }
                }
            }
            
            if(isset($post['src']['image'])){
                foreach ($post['src']['image'] as $key => $value) {
                    if($value != ''){
                        if(is_array($value) && !empty($value)){
                            $userMedia = \app\models\UserMedia::findOne($key);

                            if($userMedia->src != $value[0]){
                                $userMedia->src = $value[0];
                                $userMedia->save();
                            }
                        }else{
                            $userMedia = new \app\models\UserMedia();
                            $userMedia->src = $value;
                            $userMedia->type = 'image';
                            $userMedia->info_user_id = $info_user_id;
                            $userMedia->save();
                        }
                    }
                }
            }
        }
        
        if(isset($_POST['UserMedia'])){
            
            foreach ($post['src'] as $key => $value) {
                if(in_array($key, ['catwalk', 'showreel'])){
                    
                    foreach ($value as $k => $item) {
                        $userMedia = \app\models\UserMedia::findOne([$k]);
                        if($item != ''){
                            if(is_array($item)){
                                if($item[0] == ''){
                                    $userMedia->delete();
                                }else{
                                    $id = preg_replace("/^(.*)\.\w{3}/", "$1", $userMedia->src);

                                    if(stripos($item[0], $id) == false){
                                        $userMedia->scenario = 'video';
                                        $userMedia->link = $item[0];
                                        $userMedia->update();
                                    }
                                }
                            }else{
                                $userMedia = new \app\models\UserMedia();
                                $userMedia->scenario = 'video';
                                $userMedia->info_user_id = $info_user_id;
                                $userMedia->type = $key;
                                $userMedia->link = $item;
                                $userMedia->save();
                            }
                        }
                    }
                }
            }
        }
        
        $this->layout = 'registration'; 
        $request = \Yii::$app->request->post();

        
        $info = \app\models\UserInfo::findOne($info_user_id);
        
        if($info == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        if(!Yii::$app->user->isGuest){
            $email = Yii::$app->user->identity['email'];
            $info->booker_name = $email;
            $info->date = date('Y-m-d');
        }
        
        $info->isAdmin = true;

        $user = \app\models\User::findOne($info->user_id);
        if($user->load(Yii::$app->request->post())){
            $user->save(false);
        }
        
        if(!empty(\Yii::$app->request->post())){
            $userSubcategory = \Yii::$app->request->post("UserSubcategory", ['subcategory_id'=>[]]);
            // Subcategory
            $userSubcat = \app\models\UserSubcategory::setSubcategory($userSubcategory, $info->id);
        }else{
            $userSubcat = \app\models\UserSubcategory::getLIstSubcategoyForUser($info->id);
        }
        
        $category = \app\models\UserInfo::getListCategoryFromSite();
        
        $category_id = (int)\Yii::$app->request->get('category', $info->category_id);
         
        $fields = \app\models\RegisterFields::getFields($category_id);
        
        $subcategory = [];
        if(in_array('subcategory', $fields)){
            $subcategory = \app\models\ModelSubcategory::getListSubcategoryFofCategoryID($info->category_id);
        }
        
        
        $info->scenario = 'registration';
        
//        vd($info->categories_id);
        
        $medias = \app\models\UserMedia::getImagesFromUser($info_user_id);
        
        
        if($info->load(Yii::$app->request->post()) && $info->validate($fields)){
            $info->save(false);
            
            \Yii::$app->session->setFlash('success', "Your information has been updated!");
            $info = \app\models\UserInfo::findOne($info_user_id);
            $info->isAdmin = true;
            
            $this->controller->redirect([\yii\helpers\Url::previous()]);
                    
            // \app\models\PDF::savePdf($info->id);
        }
        
        $userMedia = new \app\models\UserMedia(['scenario' => 'video']);
        
        

        return $this->controller->render('@app/views/site/register', [
            'category_id' => $category_id,
            'user' => $user,
            'info' => $info,
            'userMedia' => $userMedia,
            'fields' => $fields,
            'subcategory' => $subcategory,
            'userSubcat' => $userSubcat,
            'medias' => $medias,
            'category' => $category,
            'title' => "Edit profile",
        ]);
    }
}
