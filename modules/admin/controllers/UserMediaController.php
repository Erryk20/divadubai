<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\UserMedia;
use app\modules\admin\models\UserMediaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserMediaController implements the CRUD actions for UserMedia model.
 */
class UserMediaController extends Controller
{
    
    public function actions(){
        return [
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => UserMedia::find(),
            ],
            'upload-photo' => [
                'class' => '\app\components\MyUpload',
                'url' => '/images/user-media/',
                'path' => '@webroot/images/user-media/',
            ],
            'cropImage' => [
                'class' => 'demi\image\CropImageAction',
                'modelClass' => UserMedia::className(),
                'redirectUrl' => function ($model) {
                    /* @var $model Post */
                    // triggered on !Yii::$app->request->isAjax, else will be returned JSON: {status: "success"}
                    return ['update', 'id' => $model->id];
                },
            ],
            
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
//            'imageUploaderBehavior' => [
//                'class' => 'demi\image\ImageUploaderBehavior',
//                'imageConfig' => [
//                    // Name of image attribute where the image will be stored
//                    'imageAttribute' => 'image',
//                    // Yii-alias to dir where will be stored subdirectories with images
//                    'savePathAlias' => '@webroot/images/user-media',
//                    // Yii-alias to root project dir, relative path to the image will exclude this part of the full path
//                    'rootPathAlias' => '@webroot',
//                    // Name of default image. Image placed to: webrooot/images/{noImageBaseName}
//                    // You must create all noimage files: noimage.jpg, medium_noimage.jpg, small_noimage.jpg, etc.
//                    'noImageBaseName' => 'noimage.jpg',
//                    // List of thumbnails sizes.
//                    // Format: [prefix=>max_width]
//                    // Thumbnails height calculated proportionally automatically
//                    // Prefix '' is special, it determines the max width of the main image
//                    'imageSizes' => [
//                        '' => 1000,
//                        'medium_' => 270,
//                        'small_' => 70,
//                        'my_custom_size' => 25,
//                    ],
//                    // This params will be passed to \yii\validators\ImageValidator
//                    'imageValidatorParams' => [
//                        'minWidth' => 400,
//                        'minHeight' => 300,
//                    ],
//                    // Cropper config
//                    'aspectRatio' => 4 / 3, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
//                    // default config
//                    'imageRequire' => false,
//                    'fileTypes' => 'jpg,jpeg,gif,png',
//                    'maxFileSize' => 10485760, // 10mb
//                    // If backend is located on a subdomain 'admin.', and images are uploaded to a directory
//                    // located in the frontend, you can set this param and then getImageSrc() will be return
//                    // path to image without subdomain part even in backend part
//                    'backendSubdomain' => 'admin.',
//                ],
//            ],
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
     * Lists all UserMedia models.
     * @return mixed
     */
    public function actionIndex($info_user_id)
    {    
        $searchModel = new UserMediaSearch();
        $searchModel->info_user_id = $info_user_id;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single UserMedia model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "UserMedia #".$id,
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
     * Creates a new UserMedia model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($info_user_id, $type)
    {
        $request = Yii::$app->request;
        
        switch ($type){
            case 'image' : $model = new UserMedia(['scenario'=>'image']); break;
            case 'video' : $model = new UserMedia(['scenario'=>'video']); break;
        }
        
        $model->info_user_id = $info_user_id;
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new UserMedia",
                    'content'=>$this->renderAjax($type== 'image' ? 'create-img' : 'create-video', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $model->setSrc();
                $model->save(false);
//                $this->saveFile($model);
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new UserMedia",
                    'content'=>'<span class="text-success">Create UserMedia success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create', 'info_user_id' => $info_user_id, 'type'=>$type],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new UserMedia",
                    'content'=>$this->renderAjax($type== 'image' ? 'create-img' : 'create-video', [
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
                $model->setSrc();
                $model->save(false);
                

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render($type== 'image' ? 'create-img' : 'create-video', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing UserMedia model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        
        if(in_array($model->type, array_keys(UserMedia::itemAlias('photo')))){
            $action = 'img';
            $model->scenario = 'image';
        }else{
            $action = 'video';
            $model->scenario = 'video';
        }
       
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update UserMedia #".$id,
                    'content'=>$this->renderAjax("update-{$action}", [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                    if(in_array($model->type, array_keys(UserMedia::itemAlias('photo')))){
                        $model->setSrc();
                        $model->save(false);
                
//                        $this->saveFile($model);
                        $model = $this->findModel($id);       
                    }else{
                        $model->save();
                        if(!in_array($model->type, ['catwalk', 'showreel'])){
                            $model->src =  "/images/user-media/". $model->src;
                        }
                        
                        
                    }
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "UserMedia #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',["update",'id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update UserMedia #".$id,
                    'content'=>$this->renderAjax("update-{$action}", [
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
                $model->setSrc();
                $model->save(false);
//                $this->saveFile($model);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render("update-{$action}", [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing UserMedia model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
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
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing UserMedia model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
    
    public function saveFile($model){
        if(!empty($_FILES['UserMedia']['name']['file'])){
            $upload = new \app\models\File();
            $upload->file = \yii\web\UploadedFile::getInstanceByName("UserMedia[file]");
            $path = \Yii::getAlias("@webroot/images/user-media/");
            
            if ($upload->upload($path)) {
                $model->src = $upload->url;
            }
        }
        return $model->save(false);
    }

    /**
     * Finds the UserMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = UserMedia::find()
                ->select([
                    'id', 
                    'info_user_id', 
                    'type', 
                    "IF(type IN ('catwalk', 'showreel'), src, CONCAT('images/user-media/', src)) AS src"
                ])
                ->where(['id'=>$id])
                ->one();
        
        $model->file = $model->src ? "/$model->src" : null;
        
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
