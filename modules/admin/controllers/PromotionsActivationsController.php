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
use app\models\FilterForm;

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
                            return Yii::$app->user->identity->role == 'admin';
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
        $searchModel = new PromotionsActivationsSearch();

        $request = \Yii::$app->request;
        $filter = new \app\modules\admin\models\FilterFormAdmin();
        
        $params = [];
        if($filter->load($request->get())){
            if($request->isGet){
                $getFilter = $request->get('FilterFormAdmin');
            }
            
            if($request->isPost){
                $filter->load($request->post());
                
                $getFilter = $request->post('FilterFormAdmin');
            }
            
            $params['PromotionsActivationsSearch'] = $getFilter;
            
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
            'filter' => $filter,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionActive($id){
        $models = \app\models\UserCategory::findAll(['info_user_id'=>$id]);
        
        foreach ($models as $model) {
            $model->active = ($model->active == '0') ? '1' : '0';
            $model->save(false);
        }
        
        return true;
    }
}