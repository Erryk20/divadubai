<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\RegisterFields;
use app\modules\admin\models\RegisterFieldsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * RegisterFieldsController implements the CRUD actions for RegisterFields model.
 */
class RegisterController extends Controller
{
    public function actions() {
        return [
            'index' => [
                'class' => \app\actions\Register::className(),
            ],
        ];
    }
    
}
