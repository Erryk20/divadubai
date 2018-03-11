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
    
    public function actions() {
        return [
            'index' => [
                'class' => \app\actions\Register::className(),
            ],
        ];
    }
    
}
