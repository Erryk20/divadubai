<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\BookingSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\base\Model;

/**
 * UserInfoController implements the CRUD actions for UserInfo model.
 */
class BookingFormController extends Controller
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
            'profile'   => ['class' => \app\actions\EditProfile::className()],
            'index'     => [
                'class' => \app\actions\Talents::className(),
                'index'=>'booking'
            ],
        ];
    }
    
    public function actionSentMail()
    {
        $request = Yii::$app->request;
        
        $searchModel = new BookingSearch();
        
        $checked = $request->get('checked', false);
        $dataProvider = $searchModel->setDataForEmail($checked);
        
        $models = [];
        foreach(Yii::$app->request->post('Booking', []) as $model) {
            $models[$model['model_id']] = new \app\models\Booking();
        }
        
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Send Email",
                    'content'=>$this->renderAjax('sent-mail', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if(Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)){
                $count = 0;
                foreach ($models as $model) {
                    $model->save(false);
                    $count++;
                    
                    \app\models\Email::sendMailBooking($model);
                }
                
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Send Email",
                    'content'=>"<span class='text-success'>Processed {$count} records successfully.</span>",
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{    
                $dataProvider = new \yii\data\ArrayDataProvider([
                    'allModels' => $models,
                ]);

                return [
                    'title'=> "Send Email",
                    'content'=>$this->renderAjax('sent-mail', [
                        'dataProvider' => $dataProvider,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
                return $this->redirect(['/admin/booking-form']);
            } else {
                return $this->render ('sent-mail', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                ]);
            }
        }
       
    }
}
