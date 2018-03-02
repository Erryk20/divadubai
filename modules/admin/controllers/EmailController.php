<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Email;
use app\modules\admin\components\Controller;
use yii\web\NotFoundHttpException;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * UserController implements the CRUD actions for User model.
 */
class EmailController extends Controller
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
                            return in_array(Yii::$app->user->identity->role, ['admin', 'user']);
                        }
                    ],
                ],
            ],
        ];
    }
   
    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
//    public function actionView($id)
//    {   
//        $request = Yii::$app->request;
//        if($request->isAjax){
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return [
//                    'title'=> "User #".$id,
//                    'content'=>$this->renderAjax('view', [
//                        'model' => $this->findModel($id),
//                    ]),
//                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
//                            Html::a('Edit',['update','id'=>$id],['class'=>'btn btn-primary','role'=>'modal-remote'])
//                ];    
//        }else{
//            return $this->render('view', [
//                'model' => $this->findModel($id),
//            ]);
//        }
//    }

    /**
     * Creates a new User model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSend($type)
    {
        $request = Yii::$app->request;
        $model = new Email();
        $model->setTheme('for_user_message');

        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Message to Selected Models",
                    'content'=>$this->renderAjax('create', ['model' => $model]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Send',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->sendMessages($type)){
               
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Message",
                    'content'=>'<span class="text-success">Your messages have been sent</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];         
            }else{    
                return [
                    'title'=> "Message to Selected Models",
                    'content'=>$this->renderAjax('create', ['model' => $model]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Send',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }
//        else{
//            /*
//            *   Process for non-ajax request
//            */
//            if ($model->load($request->post()) && $model->sendMessages()) {
//                return $this->redirect(['view', 'id' => $model->id]);
//            } else {
//                return $this->render('create', [
//                    'model' => $model,
//                ]);
//            }
//        }
       
    }
    
    public function actionSendEmail($id)
    {
        $request = Yii::$app->request;
        $model = new Email();
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            if($model->load($request->post()) && $model->sendEmail($id)){
                $model = new Email();
                return [
                    'status' => true,
                    'html'=> $this->renderAjax('send-profile', ['model' => $model, 'id'=>$id])
                ];
            }else{  
                return [
                    'status' => false,
                    'html'=> $this->renderAjax('send-profile', ['model' => $model, 'id'=>$id])
                ];
            }
        }
    }
}
