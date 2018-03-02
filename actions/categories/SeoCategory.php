<?php

namespace app\actions\categories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\actions\categories\MainAction;
use app\modules\admin\models\DivaMediaSearch;
use Yii;

/**
 * Description of MyAction
 *
 * @author PC
 */
class SeoCategory extends MainAction {
    
    public $type;
    
    protected function render($viewName){
        
        $searchModel = new DivaMediaSearch();
        $searchModel->type = $this->type;
        
        $category_id = (int)\app\models\Diva::find()
                ->where(['url' => $this->type])
                ->select('id')
                ->scalar();
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        
        return $this->controller->render('@actions-views/seo-category/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $this->type,
            'category_id' => $category_id,
        ]);
    }
}
