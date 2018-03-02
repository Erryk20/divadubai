<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class _ContentController extends Controller
{
    
    public function actionCont($id, $table)
    {
        $request = Yii::$app->request;
        
        $top = \app\models\Content::findOne(
                [
                    'type'=>'top',
                    'table'=> $table,
                    'target_id'=>$id,
                ]);
        if($top === null){
            $top = new \app\models\Content();
            $top->type = 'top';
            $top->table = $table;
            $top->target_id = $id;
        }
        
        $blockquote = \app\models\Content::findOne(
                [
                    'type' => 'blockquote',
                    'table'=> $table,
                    'target_id'=> $id,
                ]);
        if($blockquote === null){
            $blockquote = new \app\models\Content();
            $blockquote->type = 'blockquote';
            $blockquote->table = $table;
            $blockquote->target_id = $id;
        }
        
        $description = \app\models\Content::findOne(
                [
                    'type'=>'description',
                    'table'=> $table,
                    'target_id'=> $id,
                ]);
        if($description === null){
            $description = new \app\models\Content();
            $description->type = 'description';
            $description->table = $table;
            $description->target_id = $id;
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update {$table}  Content #".$id,
                    'content'=>$this->renderAjax('content', [
                        'top' => $top,
                        'blockquote' => $blockquote,
                        'description' => $description,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($top->saveCont() && $blockquote->saveCont() && $description->saveCont()){
                
                return $this->redirect(['/admin/categories']);

            }else{
                 return [
                    'title'=> "Update {$table} Content #".$id,
                    'content'=>$this->renderAjax('content', [
                        'top' => $top,
                        'blockquote' => $blockquote,
                        'description' => $description,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($top->saveCont() && $blockquote->saveCont() && $description->saveCont()) {
                return $this->redirect(["/admin/{$table}"]);
            } else {
                return $this->render('content', [
                    'top' => $top,
                    'blockquote' => $blockquote,
                    'description' => $description,
                ]);
            }
        }
    }
}
