<?php

namespace app\actions\categories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use app\actions\categories\MainAction;
use kartik\helpers\Html;
use app\modules\admin\models\DivaMediaSearch;
use app\models\DivaMedia;
use \yii\web\Response;
use Yii;

/**
 * Description of MyAction
 *
 * @author PC
 */
class UpdateMedia extends MainAction {
    
    protected function render($viewName){
        
        $request = Yii::$app->request;
        $id = $request->get('id');

        $model = $this->findModel($id);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update DivaMedia #".$id,
                    'content'=>$this->controller->renderAjax('@actions-views/create-media/update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $this->saveFile($model);

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "DivaMedia #".$id,
                    'content'=>$this->controller->renderAjax('@actions-views/create-media/view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update DivaMedia #".$id,
                    'content'=>$this->controller->renderAjax('@actions-views/create-media/update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->validate()) {
                $this->saveFile($model);
                                
                return $this->controller->redirect(['@actions-views/create-media/view', 'id' => $model->id]);
            } else {
                return $this->controller->render('@actions-views/create-media/update', [
                    'model' => $model,
                ]);
            }
        }
    }
}
