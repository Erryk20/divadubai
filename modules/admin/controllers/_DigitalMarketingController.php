<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\UserInfo;
use app\modules\admin\models\DigitalMarketingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class _DigitalMarketingController extends Controller
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
        $searchModel = new DigitalMarketingSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
            $info_user_id = Yii::$app->request->post('editableKey');
            $type = Yii::$app->request->post('type');
            
            
            $model = \app\models\DigitalMarketing::findOne([
                'info_user_id'=> $info_user_id
            ]);
            
            
            $type_name = \app\models\DigitalMarketing::itemAlias('type', $type);
            
            if($model == null){
                $model = new \app\models\DigitalMarketing();
                $model->info_user_id = $info_user_id;
            }
            
            $out = "[]";
            if($type == '0'){
                $model->delete();
                echo  \yii\helpers\Json::encode(['output' => '(not set)', 'message' => '']);
            }else{
                $model->type = $type;
                
                if ($model->save(false)) {
                    echo  \yii\helpers\Json::encode(['output' => $type_name, 'message' => '']);
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
    
    public function actionAddUser($id){
        $model = \app\models\DigitalMarketing::findOne(['info_user_id'=>$id]);
        if($model == null){
            $model = new \app\models\DigitalMarketing();
            $model->info_user_id = $id;
            $model->save();
        }else{
            $model->delete();
        }
        return true;
    }

}
