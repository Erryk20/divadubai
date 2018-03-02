<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\UserInfo;
use app\modules\admin\models\UserInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class CastingCallController extends Controller
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
    
    public function actions() {
        return [
            'profile' => [
                'class' => \app\actions\EditProfile::className(),
            ],
        ];
    }

    /**
     * Lists all UserInfo models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UserInfoSearch();
        $request = \Yii::$app->request;
        $filter = new \app\modules\admin\models\FilterFormAdmin();
        
        
        if (Yii::$app->request->post('hasEditable')) {
            $info_user_id = Yii::$app->request->post('editableKey');
            $editableAttribute = Yii::$app->request->post('editableAttribute');
            $userInfo = Yii::$app->request->post('UserInfo');
            $index = Yii::$app->request->post('editableIndex');
            
            if($editableAttribute){
                $model = UserInfo::findOne($info_user_id);
                $model->{$editableAttribute} = $userInfo[$index][$editableAttribute];
                $model->save(false);
                $items = UserInfo::itemAlias($editableAttribute);
                

                echo  \yii\helpers\Json::encode([
                    'output' => $items[$model->status], 
                    'message' => ''
                ]);
                return;
            }
            
            
            $categories = (isset($userInfo[$index]['categories_key']) && $userInfo[$index]['categories_key'] != '') ? $userInfo[$index]['categories_key'] : [];

            
            $oldCategory = \app\models\UserCategory::getListCategoriesFromUser($info_user_id);
            
            // Create model
            foreach (array_diff($categories, $oldCategory) as $category_id) {
                $model = new \app\models\UserCategory();
                $model->category_id = $category_id;
                $model->info_user_id = $info_user_id;
                $model->active = '1';
                $model->save();
            }
            
             // Delete model
            foreach (array_diff($oldCategory, $categories) as $category_id) {
                $model = \app\models\UserCategory::findOne([
                    'category_id' => $category_id,
                    'info_user_id' => $info_user_id,
                ])->delete();
            }

            $categoriesName = \app\models\UserCategory::getListCategoriesNameFromUser($info_user_id);
            $categoriesHTML = UserInfo::htmlCategories($categoriesName);
            
            echo  \yii\helpers\Json::encode([
                'output' => empty($categories) ? "(not set)" : $categoriesHTML, 
                'message' => ''
            ]);
            return;
        }
        
        $params = [];
        if($filter->load($request->get())){
            if($request->isGet){
                $getFilter = $request->get('FilterFormAdmin');
            }
            
            if($request->isPost){
                $filter->load($request->post());
                
                $getFilter = $request->post('FilterFormAdmin');
            }
            
            $params['UserInfoSearch'] = $getFilter;
            
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
        
        
        
        return $this->render('@app/modules/admin/views/user-info/index', [
            'filter' => $filter,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Delete an existing UserInfo model.
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
     * Delete multiple existing UserInfo model.
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

    /**
     * Finds the UserInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {   
        $model = UserInfo::find()
                ->from('user_info ui')
                ->select([
                    "ui.*", 
                    "c.name AS category",
                    "IFNULL(
                        (
                            SELECT src
                            FROM user_media
                            WHERE info_user_id = ui.id
                            AND `type` IN ('image', 'polaroid')
                            ORDER BY `order`
                            LIMIT 1
                        ), 'diva-logo.png') AS logo"
                ])
                ->leftJoin('categories c', 'c.id = ui.category_id')
                ->where(['ui.id'=>$id])
                ->one();
        
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
