<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\UserInfo;
use app\modules\admin\models\PromotionsActivationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class PromotionsActivationsController extends Controller
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
        $searchModel = new PromotionsActivationsSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        if (Yii::$app->request->post('hasEditable')) {
            $info_user_id = Yii::$app->request->post('editableKey');
            $promotion_type = Yii::$app->request->post('promotion_type');
            
            $model = \app\models\PromotionsActivations::findOne([
                'info_user_id'=> $info_user_id
            ]);
            
            $promotion_type_name = \app\models\PromotionsActivations::itemAlias('type', $promotion_type);
            
            if($model == null){
                $model = new \app\models\PromotionsActivations();
                $model->info_user_id = $info_user_id;
            }
            
            $out = "[]";
            if($promotion_type == '0'){
                $model->delete();
                echo  \yii\helpers\Json::encode(['output' => '(not set)', 'message' => '']);
            }else{
                $model->type = $promotion_type;
                
                if ($model->save(false)) {
                    echo  \yii\helpers\Json::encode(['output' => $promotion_type_name, 'message' => '']);
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
