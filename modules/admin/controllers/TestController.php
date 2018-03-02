<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Upload;
use app\modules\admin\models\UploadSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\admin\models\Vimeo;

/**
 * UploadController implements the CRUD actions for Upload model.
 */
class TestController extends Controller {

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
     * Lists all Upload models.
     * @return mixed
     */
    public function actionIndex()
    {
//        'Wed Feb 15 2017 02:00:00 GMT+0200 (Фінляндія (зима))'  
        
//        $time = strtotime("01-02-2017 13:15");
        
//        $temp = strtotime(date('Y-m', time()));
//        vd($temp, false);
        
        
        vd(date('Y-m-d H:i', 1496658660));
        
        
        $client_id = Vimeo::CLIENT_ID;
        $client_secret = Vimeo::CLIENT_SECRET;
        $access_token = Vimeo::ACCESS_TOKEN;
        
        $vimeo = new \Vimeo\Vimeo($client_id, $client_secret, $access_token);
        $fields = [
            'uri, created_time, modified_time, release_time',
            'status',
        ];
        
        $request = $vimeo->request('/me/videos', [
            'fields'=>  implode(',', $fields), 
            'sort'=>'date', 
            'direction'=>'desc', 
            'per_page'=>10,
        ]);
        
        vd($request['body']['data'], false);
        die_my();
        
        die_my();
        
        
//        vd(json_decode($vimeo->download), false);
//        die_my();

         $request = \app\models\Upload::find()
                ->select(['id_vimeo', 'updated_at', 'name'])
                ->where('UNIX_TIMESTAMP() < (updated_at + 39600)')
                ->limit(2);
         
        foreach ($request->all() as $value) {
            $vimeo = Vimeo::getInfoVideo($value->id_vimeo);
            
//            vd(json_decode($vimeo->download, TRUE), false);
//            die_my();
            
            $value->attributes = $vimeo->attributes;
            $value->access_token = \app\modules\admin\models\Vimeo::ACCESS_TOKEN;
            
//            vd($value->attributes, false);

            vd($value->save(), false);
//            vd($value->updateImage(), false);
//            die_my();
        }
        die_my();


        $model = new \Vimeo\Vimeo($client_id, $client_secret, $access_token);
//        $temp = $model->request('/me/videos', ['fields'=>'files', 'page'=>2, 'per_page'=>10]); //['query' => 'a']
        $temp = $model->request('/me/videos', ['fields' => 'files,name,uri,pictures.sizes', 'sort' => 'date', 'direction' => 'asc', 'per_page' => 10]); //['query' => 'a'] 
//        $temp = $model->request('/me/videos', ['sort'=>'date', 'direction'=>'asc', 'per_page'=>10]); //['query' => 'a'] 

        vd($temp, false);
        vd($model, false);
//    $vimeo = \app\modules\admin\models\Vimeo::getInfoVideo("194014287");
//    vd($vimeo, false);
//        vd($model->getInfoVideo, false);
        die_my();

        return $this->render('index');
    }

}
