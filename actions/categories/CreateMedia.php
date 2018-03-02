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
class CreateMedia extends MainAction {
    
    protected function render($viewName){
        
        $request = Yii::$app->request;
        $target_id = $request->get('target_id');
        $type = $request->get('type');
        
        $model = new DivaMedia();  
        $model->diva_id = $target_id;
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new DivaMedia {$type}",
                    'content'=>$this->controller->renderAjax('@actions-views/create-media/create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $this->saveFile($model);

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new DivaMedia ",
                    'content'=>'<span class="text-success">Create DivaMedia success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create-media', 'target_id'=>$target_id, 'type'=>$type],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new DivaMedia {$type}",
                    'content'=>$this->controller->renderAjax('@actions-views/create-media/create', [
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
                return $this->controller->render('@actions-views/create-media/create', [
                    'model' => $model,
                ]);
            }
        }
    }
    
        /**
     * Save the file on the server
     * @param type $model
     * @return type
     */
    public function saveFile($model){
        if(!empty($_FILES['DivaMedia']['name']['file'])){
            $upload = new \app\models\File();
            $upload->file = \yii\web\UploadedFile::getInstanceByName("DivaMedia[file]");
       
            $path = \Yii::getAlias("@webroot/images/diva-media/");
            if ($upload->upload($path)) {
                $model->img = $upload->url;
            }
        }
        return $model->save(false);
    }
}
