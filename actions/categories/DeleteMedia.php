<?php

namespace app\actions\categories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\actions\categories\MainAction;
use \yii\web\Response;
use Yii;

/**
* Delete an existing DivaMedia model.
* For ajax request will return json object
* and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $id
* @return mixed
*/
class DeleteMedia extends MainAction {
    
    protected function render($viewName){
        $request = Yii::$app->request;
        
        $id = $request->get('id');
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->controller->redirect(['index']);
        }
    }
}
