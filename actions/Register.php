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
class Register extends ViewAction {
    
    protected function render($viewName){
        \Yii::$app->controller->layout = 'registration';
        
        $category = \app\models\UserInfo::getListCategoryFromSiteSlug();
        
        $categorySlug = \Yii::$app->request->get('category', key($category));

//        if(in_array($category_id, ['models','casts','promoters','stylists','eventsupport','entertainer','photographers','locations','influencers'])){
            $id = \app\models\ModelCategory::getIdFromCategorySlug($categorySlug);
            $category_id = ($id != 0) ? $id : 113;
//        }

        $fields = \app\models\RegisterFields::getFields($category_id);
        
        $subcategory = [];
        if(in_array('subcategory', $fields)){
            $subcategory = \app\models\ModelSubcategory::getListSubcategoryFofCategoryID($category_id);
        }
        
        $user_id = '';
        $info_user_id = null;
        
        
        $postUser = Yii::$app->request->post('User', false);
        $postUserInfo = Yii::$app->request->post('UserInfo', false);
        $userMedia = new \app\models\UserMedia(['scenario' => 'video']);
        
        $user = \app\models\User::findOne(['email' => $postUserInfo['email']]);

        if($user == null){
            $user = new \app\models\User(['scenario'=>'registration']);  
        }else{
            $login = new \app\models\LoginForm(['scenario'=>'login-site']);

            $login->usernameOrEmail = $user->email;
            $login->password = $user->password;
            $login->username = $user->username;

            $login->login();

            $user_id = $user->id;
        }



        if($user_id == '' && $user->load(Yii::$app->request->post())){
            $user->email = $postUserInfo['email'];
            $user->setPassword($user->password);
            $user->generateAuthKey();
            $user->status = \app\models\User::STATUS_ACTIVE;
            
            if($user->save()){
                $user_id = $user->id;
                
                $login = new \app\models\LoginForm(['scenario'=>'login-site']);
                    
                $login->usernameOrEmail = $user->email;
                $login->password = $user->password;
                $login->username = $user->username;

                $login->login();
            }
        }
        
        $info = new \app\models\UserInfo(['scenario'=>'registration']);
        $info->category_id = $category_id;
        $info->categorySlug = $categorySlug;
        $info->prepend_phone = 971;
        $info->prepend_phone2 = 971;
        $info->active = 1;
        
        
        if($user_id != ''){$info->user_id = $user_id;}
        
        
        if ($info->load(Yii::$app->request->post()) && $info->validate($fields)) {
            
            $info->user_id = ($user_id != null) ? $user_id : '';

            if($info->save(false)){
                $info_user_id = $info->id;
                
                // Subcategory
                $userSubcategory = \Yii::$app->request->post("UserSubcategory", ['subcategory_id'=>[]]);
                $userSubcat = \app\models\UserSubcategory::setSubcategory($userSubcategory, $info->id);
                
                $postUserMedia = $_POST['UserMedia'];
                
                if(isset($postUserMedia['src']['image'])){
                    if(!empty($postUserMedia['src']['image'])){
                        foreach ($postUserMedia['src']['image'] as $key => $value) {
                            if ($value != '') {
                                if (is_array($value) && !empty($value)) {
                                    $userMedia = \app\models\UserMedia::findOne($key);

                                    if ($userMedia->src != $value[0]) {
                                        $userMedia->src = $value[0];
                                        $userMedia->save();
                                    }
                                } else {
                                    $userMedia = new \app\models\UserMedia();
                                    $userMedia->info_user_id = $info->id;
                                    $userMedia->type = 'image';
                                    $userMedia->src = $value;
                                    $userMedia->save();
                                }
                            }
                        }
                    }
                }
                
                if(isset($postUserMedia['src']['polaroid'])){
                    foreach ($postUserMedia['src']['polaroid'] as $key => $value) {
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
                                    $result = \Yii::getAlias("@webroot/images/user-media/{$userMedia->src}");
                                    copy($path, $result);
                                }
                            }
                        }
                    }
                }

                
                if(isset($postUserMedia['src'])){
                    foreach ($postUserMedia['src'] as $key => $value) {
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

                
                \Yii::$app->session->setFlash('success', "Are you registered!");
                
                $userFind = \app\models\User::findOne($info->user_id);
                     
                if($userFind != null){
                    \app\models\UserInfo::sentMailForRegister("registration", $info->id);
                }

                 $this->controller->redirect([\yii\helpers\Url::previous()]);
            };
        }
        $medias = \app\models\UserMedia::getImagesFromUser($info_user_id);
        
        return $this->controller->render('@app/views/site/register', [
            'category_id' => $category_id,
            'user' => $user,
            'info' => $info,
            'userMedia' => $userMedia,
            'medias' => $medias,
            'category' => $category,
            'subcategory' => $subcategory,
            'fields' => $fields,
            'userSubcat' => [],
            'title' => "Registration",
        ]);
    }
}
