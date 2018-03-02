<?php

namespace app\actions;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\web\ViewAction;
use app\modules\admin\models\UserInfoSearch;

use Yii;


/**
 * Description of MyAction
 *
 * @author PC
 */
class Talents extends ViewAction {
    
    public $index;


    protected function render($viewName){
//          \Yii::$app->controller->layout = 'registration';
            
        \yii\helpers\Url::remember();
        $searchModel = new UserInfoSearch();
        
        $request = \Yii::$app->request;
        
        $filter = new \app\modules\admin\models\FilterFormAdmin();
        $filter->prepend_phone = 971;
        
        
        if (Yii::$app->request->post('hasEditable')) {
            $info_user_id = Yii::$app->request->post('editableKey');
            $userInfo = Yii::$app->request->post('UserInfo');
            $index = Yii::$app->request->post('editableIndex');
            
            
//            if($editableAttribute){
//                $model = UserInfo::findOne($info_user_id);
//                $model->{$editableAttribute} = $userInfo[$index][$editableAttribute];
//                $model->save(false);
//                
//                $items = UserInfo::itemAlias($editableAttribute);
//                
//                echo  \yii\helpers\Json::encode([
//                    'output' => $items[$model->status], 
//                    'message' => ''
//                ]);
//                return;
//            }
            
            
            $categories = (isset($userInfo[$index]['categories_key']) && $userInfo[$index]['categories_key'] != '') ? $userInfo[$index]['categories_key'] : [];
            $oldCategory = \app\models\UserCategory::getListCategoriesFromUser($info_user_id);
            
            // Create model
            foreach (array_diff($categories, $oldCategory) as $category_id) {
                $model = new \app\models\UserCategory();
                $model->category_id = $category_id;
                $model->info_user_id = $info_user_id;
                $model->active = '1';
                $model->save();
            }
            
             // Delete model
            foreach (array_diff($oldCategory, $categories) as $category_id) {
                $model = \app\models\UserCategory::findOne([
                    'category_id' => $category_id,
                    'info_user_id' => $info_user_id,
                ])->delete();
            }

            $categoriesName = \app\models\UserCategory::getListCategoriesNameFromUser($info_user_id);
            $categoriesHTML = \app\models\UserInfo::htmlCategories($categoriesName);
            
            echo  \yii\helpers\Json::encode([
                'output' => empty($categories) ? "(not set)" : $categoriesHTML, 
                'message' => ''
            ]);
            return;
        }
        
        
        $params = [];
        if($filter->load($request->get()) || $request->isPost){
            if($request->isGet){
                $getFilter = $request->get('FilterFormAdmin');
            }
            
            if($request->isPost){
                $filter->attributes = $request->post();
                $filter->load($request->post());
                
//                vd($filter, false);
//                vd($request->post());
                
//                $getFilter = $filter->attributes; //$request->post('FilterFormAdmin');
            }
            
            $params['UserInfoSearch'] = $filter->attributes;

            $filter->setForm();
        }
        
        
        if($request->isAjax){
            if(!isset($_GET['_pjax'])){
                $filter->load($request->get());
                $filter->setForm();
                
                return  $this->controller->renderAjax(
                    '@app/modules/admin/views/blocks/advance-block', 
                    ['filter'=>$filter]);
            }
        }
        
        $dataProvider = $searchModel->search($params);
        
        return $this->controller->render("@app/modules/admin/views/user-info/{$this->index}", [
            'filter' => $filter,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
