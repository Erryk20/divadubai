<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Products;
use app\modules\admin\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\ProductsLan;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    
    /**
     * @inheritdoc
     */
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $get = Yii::$app->request->get('ProductsSearch', false);
        $language = ($get && isset($get['language']) && !empty($get['language'])) ? $get['language'] : NULL;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'language' => $language,
        ]);
    }


    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id, $language)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Products #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id, $language),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id, 'language'=>$language],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id, $language),
            ]);
        }
    }

    /**
     * Creates a new Products model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Products();  
        $model->published = 1;
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Products",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $this->saveFile($model);

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Products",
                    'content'=>'<span class="text-success">Create Products success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Products",
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
            if ($model->load($request->post()) && $model->validate()) {
                $this->saveFile($model);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }
    
    /**
     * Creates a new Products model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateLan($id)
    {
        $request = Yii::$app->request;
        $model = Products::findOne($id); 
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new Products",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $this->saveFile($model);

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new Products",
                    'content'=>'<span class="text-success">Create Products success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new Products",
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
            if ($model->load($request->post()) && $model->validate()) {
                $this->saveFile($model);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing Products model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $language)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id, $language);
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update Products #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $this->saveFile($model);

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Products #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id, 'language' => $language],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update Products #".$id,
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
            if ($model->load($request->post()) && $model->validate()) {
                $this->saveFile($model);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Products model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $language)
    {
        $request = Yii::$app->request;
        
        $model = ProductsLan::findOne([
            'product_id' => $id, 
            'language'=>$language
        ])->delete();
        
        $model = ProductsLan::findOne(['product_id' => $id]);
        
        if($model === null){
            Products::findOne($id)->delete();
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
     * Delete multiple existing Products model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        
        $result = [];
        foreach ($pks as $value) {
            $item = explode('-', $value);
            
            $result[$item[0]][] = $item[1];
        }

        
        foreach ( $result as $id => $pk ) {
            
            foreach ($pk as $lan) {
                $model = ProductsLan::findOne([
                    'product_id' => $id, 
                    'language'=>$lan
                ])->delete();
            }
            
            $model = ProductsLan::findOne(['product_id' => $id]);

            if($model === null){
                Products::findOne($id)->delete();
            }
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
     * Save the file on the server
     * @param type $model
     * @return type
     */
    public function saveFile($model){
//        vd($_FILES);
//        vd($model);
        
        
        if(!empty($_FILES['Products']['name']['file'])){
            $upload = new \app\models\File();
            $upload->file = \yii\web\UploadedFile::getInstanceByName("Products[file]");
       
            $path = \Yii::getAlias("@webroot/images/products/");
            if ($upload->upload($path)) {
                $model->img = $upload->url;
            }
        }
        
        if($model->save(false)){
            $product_lan = ProductsLan::findOne([
                'product_id' => $model->id, 
                'language' => $model->language
            ]);

            if(!$product_lan){
                $product_lan = new ProductsLan();
                $product_lan->product_id = $model->id;
            }

            $product_lan->name = $model->name;
            $product_lan->description = $model->description;
            $product_lan->language = $model->language;
            
            return $product_lan->save(false);
        }
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $language)
    {
        $model = Products::find()
            ->from('products p')
            ->select(['p.id', 'p.img', 'p.price', 'p.published', 'p.created_at', 'p.updated_at', 'pl.language', 'pl.name', 'p.category_id', 'pl.description', 'l.name AS language_name'])
            ->leftJoin('products_lan pl', 'pl.product_id = p.id')
            ->leftJoin('language l', 'pl.language = l.short_name')
            ->where(['p.id' => $id, 'pl.language'=>$language])
            ->one();
        
        if (($model) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
