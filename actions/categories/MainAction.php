<?php

namespace app\actions\categories;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\web\ViewAction;
use app\models\DivaMedia;
use yii\web\NotFoundHttpException;
use Yii;

Yii::setAlias('@actions-views', '@app/actions/views');

/**
 * Description of MyAction
 *
 * @author PC
 */
class MainAction extends ViewAction {
    
    
    /**
     * Save the file on the server
     * @param type $model
     * @return type
     */
    public function saveFile($model){
        if(!empty($_FILES['DivaMedia']['name']['file'])){
            $upload = new \app\models\File();
            $upload->file = \yii\web\UploadedFile::getInstanceByName("DivaMedia[file]");
       
            $path = \Yii::getAlias("@webroot/images/diva-media/");
            if ($upload->upload($path)) {
                $model->img = $upload->url;
            }
        }
        return $model->save(false);
    }
    
     /**
     * Finds the DivaMedia model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DivaMedia the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DivaMedia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
