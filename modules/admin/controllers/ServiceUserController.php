<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\UserInfo;
use app\modules\admin\models\ServiceUsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class ServiceUserController extends Controller
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
                            return Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                ],
            ],
        ];
    }
    
    public function actions() {
        return [
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
        $searchModel = new ServiceUsersSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
            $info_user_id = Yii::$app->request->post('editableKey');
            $service_cat_id = Yii::$app->request->post('service_cat_id');
            
            $model = \app\models\ServiceUsers::findOne([
                'info_user_id'=> $info_user_id
            ]);
            
            $serviceCat = \app\models\ServiceCategories::findOne($service_cat_id);
            
            if($model == null){
                $model = new \app\models\ServiceUsers();
                $model->info_user_id = $info_user_id;
            }
            
            $out = "[]";
            if($service_cat_id == '0'){
                $model->delete();
                echo  \yii\helpers\Json::encode(['output' => '(not set)', 'message' => '']);
            }else{
                $model->service_cat_id = $service_cat_id;
                
                if ($model->save(false)) {
                    echo  \yii\helpers\Json::encode(['output' => $serviceCat['name'], 'message' => '']);
                }else{
                    echo  \yii\helpers\Json::encode(['output' => 'Error', 'message' => '']);
                }
            }
            return;
        }
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
