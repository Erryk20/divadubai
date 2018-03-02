<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Upload;
use app\modules\admin\models\UploadSearch;
use app\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\Vimeo;
use yii\web\Response;
use yii\helpers\Html;

/**
 * UploadController implements the CRUD actions for Upload model.
 */
class UploadController extends Controller
{
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        // Пропускаєм тільки зареєстрованих користувачів
                        'roles' => ['@'],
                        // Пропускаєм тільки користавачів зі статусом адмін
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Lists all Upload models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UploadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
    /**
     * Displays a single Videos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Videos #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    
    
    
    

    /**
     * Creates a new Upload model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Upload();
        $model->access_token = Vimeo::ACCESS_TOKEN;
        $model->upgrade_to_1080 = 0;
        $model->make_private = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
//            return $this->redirect(['view', 'id' => $model->id_vimeo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionAddVideo() 
    {
        $pageSize = 10;
        $page = (int) Yii::$app->request->get('page');
        $result = Upload::arrayDataProvider($pageSize, $page);
        
        
        $pages = new \yii\data\Pagination([
            'totalCount' => $result['total'], 
            'pageSize' => $pageSize,
            'pageSizeParam'=>false
        ]);
        
        $dataProvider = new \yii\data\ArrayDataProvider([
            'key' => 'id_vimeo',
            'allModels' => $result['models'],
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
        
        return $this->render('add-video-index', [
            'dataProvider'=>$dataProvider,
            'pages'=>$pages
        ]);
    }
    
    
    public function actionAddForVimeo($id) {
        $request = Yii::$app->request;
        $model = Vimeo::getInfoVideo($id);
        

        if ($request->isAjax) {
            $model->published = 1;
            
            /*
             *   Process for ajax request
             */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Add a Vimeo",
                    'content' => $this->renderAjax('_add-for-vimeo', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Video added",
                    'content' => '<span class="text-success">Video added successfully</span>',
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Add a Vimeo",
                    'content' => $this->renderAjax('_add-for-vimeo', ['model' => $model]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
             *   Process for non-ajax request
             */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_vimeo]);
            } else {
                return $this->render('_add-for-vimeo', ['model' => $model]);
            }
        }
    }

    /**
     * Updates an existing Upload model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_vimeo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Upload model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(\app\modules\admin\models\Vimeo::deleteVideo($model->id_vimeo)){
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Upload model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Upload the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Upload::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
