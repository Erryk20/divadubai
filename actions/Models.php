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
class Models extends ViewAction {
    
    public $action;
    public $menu;
    public $urlCat;
    public $title;
    
    protected function render($viewName){
        $controller = \Yii::$app->controller;
        $request = \Yii::$app->request;
        
        $controller->layout = 'service-cat';
        $controller->seo = \app\models\Seo::getInfoSeoFromCategory($this->action);
        
        $gender = '';
        $action = $this->action;

        $menu = \app\models\MenuCategory::getMenu($this->menu, $action);
        
        if(preg_match("/(male|female|family|boy|girl)(.*)$/", $action, $match)){
            $gender = $match[1];
            $action = $match[2];
        }
    
        
        $page = (int) $request->get('page');
        
        if($action == 'casts'){
            $limit = 50;
        }else{
            $limit = Yii::$app->params['countTalents'];
        }
        
        
        if($request->isAjax){
            $ofsset = ($page == null) ? 0 : $page*$limit;
        }else{
            $ofsset = 0;
            $limit = ($page == 0) ? $limit : $page*$limit;
        }
        
        $controller->filter = new \app\models\FilterForm();
        
        switch ($action){
            case 'host' : $actionF = 'malehost'; break;
            case 'hostess' : $actionF = 'malehost'; break;
            default : $actionF = $action;
        }
        
        $controller->filter->setForm($actionF);
        
        $controller->filter->load(Yii::$app->request->get());
        
        $session = Yii::$app->session;
        $session->set('filter', $controller->filter);
        
        $items = \app\models\MenuCategory::getListIDFromMenu($this->menu);
        
        $list = \app\models\UserInfo::getListUniversal($action, $this->action, $gender, $items, $controller->filter, true, TRUE, $limit, $ofsset);
        
        
        if($request->isAjax){
            return $controller->renderPartial('@app/actions/views/models/infinite-scroll-bocks', [
                'url'=> \yii\helpers\Url::to(['']+['page'=>$page++]+Yii::$app->request->get(), true),
                'list' => $list, 
                'urlCat'=> $this->urlCat,
            ]);
        }
            
        if($action == 'director'){
            return $controller->render('@app/actions/views/models/list-director', [
                'url'=> \yii\helpers\Url::to(['']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
                'menu'=> $menu,
                'list'=> $list,
                'urlCat'=> $this->urlCat,
                'title'=> $this->title,
            ]);
        }else{
            return $controller->render('@app/actions/views/models/list', [
                'url'=> \yii\helpers\Url::to(['']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
                'menu'=> $menu,
                'list'=> $list,
                'urlCat'=> $this->urlCat,
                'title'=> $this->title,
            ]);
        }


    }
}
