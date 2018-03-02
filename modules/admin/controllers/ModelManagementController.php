<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\UserInfo;
use app\modules\admin\models\ModelManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\FilterForm;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class ModelManagementController extends Controller
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
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        // Пропускаєм тільки зареєстрованих користувачів
                        'roles' => ['@'],
                        // Пропускаєм тільки користавачів зі статусом адмін
                        'matchCallback' => function ($rule, $action) {
                            return in_array(Yii::$app->user->identity->role, ['admin', 'user']);
                        }
                    ],
                ],
            ],
        ];
    }
    
    public function actions() {
        return [
            'profile' => [
                'class' => \app\actions\EditProfile::className(),
            ],
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => \app\models\ServiceUsers::find(),
            ],
        ];
    }
    

    /**
     * Lists all UserInfo models.
     * @return mixed
     */
    public function actionIndex()
    {    
        \yii\helpers\Url::remember();
        $searchModel = new ModelManagementSearch();
        
        
        $request = \Yii::$app->request;
        $filter = new \app\modules\admin\models\FilterFormAdmin();
        
        $params = [];
        
        if($filter->load($request->get()) || $request->isPost){
            if($request->isGet){
                $getFilter = $request->get('FilterFormAdmin');
            }
            
            if($request->isPost){
                $filter->load($request->post());
                
//                $getFilter = $request->post('FilterFormAdmin');
            }
            
            $params['ModelManagementSearch'] =  $filter->attributes;
            
            $filter->setForm();
        }
        
        
        if($request->isAjax){
            if(!isset($_GET['_pjax'])){
                $filter->load($request->get());

                $filter->setForm();

                return $this->renderAjax(
                    '@app/modules/admin/views/blocks/advance-block', 
                    ['filter'=>$filter]);
                 
            }
        }
        
        
        $dataProvider = $searchModel->search($params);
        
        if (Yii::$app->request->post('hasEditable')) {
            
            UserInfo::setSubcategory();
            return;
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filter' => $filter,
        ]);
    }
    
    public function actionActive($id, $category_id){
        
        $models = \app\models\UserCategory::findAll([
            'info_user_id'=>$id,
            'category_id'=>$category_id
        ]);
        
        foreach ($models as $value) {
            
            $value->active = ($value->active == '0') ? '1' : '0';
            $value->save(false);
        }
        return true;
    }
    
//    public function actionAddUser($id){
//        $model = \app\models\ModelManagement::findOne(['info_user_id'=>$id]);
//        if($model == null){
//            $model = new \app\models\ModelManagement();
//            $model->info_user_id = $id;
//            $model->save();
//        }else{
//            $model->delete();
//        }
//        return true;
//    }

}
