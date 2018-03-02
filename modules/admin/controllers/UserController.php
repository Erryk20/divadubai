<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\User;
use app\modules\admin\models\UserSearch;
use app\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
            $id = Yii::$app->request->post('editableKey');
            $model = User::findOne($id);
            $attribute = Yii::$app->request->post('editableAttribute');
            $model->scenario = $attribute;
            
            $value = null;
            foreach (Yii::$app->request->post('User') as $item) {
                $model->$attribute = $item[$attribute];
            }
            
            $out = "[]";
            if ($model->save()) {
                $output = $model->$attribute;
                $out = \yii\helpers\Json::encode(['output' => $output, 'message' => '']);
            }
            
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "User #".$id,
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
     * Creates a new User model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new User(['scenario'=>'admin']);  
        $model->status = User::STATUS_ACTIVE;
        $categories = \app\models\Categories::getAllCategoriesId();
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new User",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'categories' => $categories,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $model->setPassword($model->password);
                $model->generateAuthKey();
                $model->status = User::STATUS_ACTIVE;
                $this->saveFile($model);

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new User",
                    'content'=>'<span class="text-success">Create User success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{    
                return [
                    'title'=> "Create new User",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'categories' => $categories,
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'categories' => $categories,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id); 
        $categories = \app\models\Categories::getAllCategoriesId();


        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update User #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'categories' => $categories,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->validate()){
                $this->saveFile($model);

                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "User #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                        'categories' => $categories,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update User #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'categories' => $categories,
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
                    'categories' => $categories,
                ]);
            }
        }
    }

    /**
     * Delete an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id){
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
     * Delete multiple existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete(){        
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
        if(!empty($_FILES['User']['name']['file'])){
            $upload = new \app\models\File();
            $upload->file = \yii\web\UploadedFile::getInstanceByName("User[file]");
       
            $path = \Yii::getAlias("@webroot/images/users/");
            if ($upload->upload($path)) {
                $model->logo = $upload->url;
            }
        }
        return $model->save(false);
    }
    
    public function actionTest(){
        $temp = \app\models\Categories::getAllCategoriesId();
        vd($temp);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $query = User::find();
        $query->where(['u.id'=>$id]);
        $query->select('u.*, ui.type');
        $query->from('user u');
        $query->leftJoin('user_info ui', 'u.id = ui.user_id');
        
        if (($model = $query->one()) !== null) {
            $model->scenario ='admin';
            
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
