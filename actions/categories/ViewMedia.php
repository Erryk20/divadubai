<?php

namespace app\actions\categories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\actions\categories\MainAction;
use kartik\helpers\Html;
use \yii\web\Response;
use Yii;

/**
 * Description of MyAction
 *
 * @author PC
 */
class ViewMedia extends MainAction {
    
    protected function render($viewName){
        
        $request = Yii::$app->request;
        $id = $request->get('id');

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "DivaMedia #".$id,
                    'content'=>$this->controller->renderAjax('@actions-views/create-media/view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('@actions-views/create-media/view', [
                'model' => $this->controller->findModel($id),
            ]);
        }
    }
}
