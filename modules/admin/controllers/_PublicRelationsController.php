<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DivaMediaSearch;


class _PublicRelationsController extends \yii\web\Controller
{
    public function actions() {
        return [
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => \app\models\DivaMedia::find(),
            ],
        ];
    }
    
    public function actionIndex()
    {
        
        $searchModel = new DivaMediaSearch();
        $searchModel->type = 'public-relations';
        
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
        
        
        
        
        
        
        
        
        $request = \Yii::$app->request;
        
        $model = \app\models\Diva::findOne(['type'=>'production']);
        
        
        if($model->load($request->post()) && $model->save()){
            \Yii::$app->session->setFlash('success', "Your data has been saved.");
            return $this->refresh();
        }
        
        $searchModel = new \app\modules\admin\models\ContentMediaSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=> $model
        ]);
    }

}
