<?php

namespace app\actions;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Url;
use yii\web\ViewAction;
use Yii;

/**
 * Description of MyAction
 *
 * @author PC
 */
class Profile extends ViewAction {
    
    public $action;
    public $id;
    public $menu;
    
    public $urlCat;
    public $title;
    
    protected function render($viewName){
        $controller = \Yii::$app->controller;
        $request = \Yii::$app->request;
        $controller->layout = 'profile';
        
        $model = \app\models\UserInfo::getUserInfoFromProfile($this->id, $this->menu);
        $list = \app\models\UserMedia::getListMediaFromUser($this->id);
        
        $items = \app\models\MenuCategory::getListIDFromMenu($this->menu);

        $session = Yii::$app->session;
        $filterS = $session->get('filter');
       
        $nextPrev = \app\models\UserInfo::NextPrev($this->id, $this->action, $items, "{$this->urlCat}-profile", $filterS);

        $renderFile = ($request->get('action') != 'director') ? 'profile' : 'profile-director';
        
        return $controller->render("@app/actions/views/profile/{$renderFile}", [
            'title'=> $this->title,
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'pre_url' => Url::toRoute([$this->urlCat, 'action'=>$this->action]),
        ]);
        
    }
}
