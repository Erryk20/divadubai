<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Content;
use app\modules\admin\models\ContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * ContentController implements the CRUD actions for Content model.
 */
class ContentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulkdelete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Content models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Content model.
     * @param integer $target_id
     * @param string $type
     * @return mixed
     */
    public function actionView($target_id, $type)
    {   
        $request = Yii::$app->request;
        $istView = [
            'is_top' => '1',
            'is_blockquote' => '1',
            'is_description' => '0',
            'is_block_1' => '0',
            'is_block_2' => '0',
            'is_block_3' => '0',
        ];
        if($type == 'page'){
            $istView = \app\models\Pages::getIsView($target_id);
        }
        
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            
            return [
                    'title'=> "Content #".$target_id, $type,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($target_id, $type),
                        'istView'=>$istView
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','target_id'=>$target_id, 'type'=>$type],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($target_id, $type),
                'istView'=>$istView
            ]);
        }
    }

    /**
     * Creates a new Content model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Content();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Content",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Content",
                    'content'=>'<span class="text-success">Create Content success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Content",
                    'content'=>$this->renderAjax('create', [
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
                return $this->redirect(['view', 'target_id' => $model->target_id, 'type' => $model->type]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Content model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $target_id
     * @param string $type
     * @return mixed
     */
    public function actionUpdate($target_id, $type)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($target_id, $type);       
        
        $istView = [
            'is_top' => '1',
            'is_blockquote' => '1',
            'is_description' => '0',
            'is_block_1' => '0',
            'is_block_2' => '0',
            'is_block_3' => '0',
        ];
        if($type == 'page'){
            $istView = \app\models\Pages::getIsView($target_id);
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Content #".$target_id, $type,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'istView' => $istView,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Content #".$target_id, $type,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'istView' => $istView,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','target_id'=>$target_id, 'type'=>$type],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Content #".$target_id, $type,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'istView' => $istView,
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
                return $this->redirect(['view', 'target_id' => $model->target_id, 'type' => $model->type]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'istView' => $istView,
                ]);
            }
        }
    }

    /**
     * Delete an existing Content model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $target_id
     * @param string $type
     * @return mixed
     */
    public function actionDelete($target_id, $type)
    {
        $request = Yii::$app->request;
        $this->findModel($target_id, $type)->delete();

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
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Content model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $target_id
     * @param string $type
     * @return mixed
     */
    public function actionBulkdelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

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
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Content model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $target_id
     * @param string $type
     * @return Content the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($target_id, $type)
    {
        if (($model = Content::findOne(['target_id' => $target_id, 'type' => $type])) == null) {
            $model = new Content();
            $model->target_id = $target_id;
            $model->type = $type;
        }
        return $model;
    }
}
