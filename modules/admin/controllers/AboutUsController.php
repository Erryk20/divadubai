<?php

namespace app\modules\admin\controllers;

use yii\web\Response;
use yii\helpers\Html;
use Yii;

class AboutUsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = $this->findModel(12);
        $provider = new \yii\data\ArrayDataProvider([
            'allModels' => [
                ['video' => $model->block_1]
            ],
        ]);
        
        return $this->render('index', ['provider' => $provider]);
    }
    
    
    /**
     * Displays a single ContentImages model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "About As",
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel(12),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel(12),
            ]);
        }
    }
    
    public function actionUpdate()
    {
        $request = Yii::$app->request;
        $model = $this->findModel(12);       
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Video",
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Video",
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update'],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Video#",
                    'content'=>$this->renderAjax('update', [
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
            if ($model->load($request->post()) && $model->save()) {

                return $this->redirect(['view']);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }
    
    protected function findModel($id)
    {
        if (($model = \app\models\Content::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
