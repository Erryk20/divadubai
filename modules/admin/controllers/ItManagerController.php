<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;
use Yii;

/**
 * Default controller for the `admin` module
 */
class ItManagerController extends Controller
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
                            return in_array(Yii::$app->user->identity->role, ['admin']);
                        }
                    ],
                ],
            ],
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $genders = \app\models\Charts::getGender();
        
        $total = \app\models\Charts::getTotal();
        
        $subcategoryEntertainers = \app\models\Charts::getSubcategories(15);
        $subcategoryStylists = \app\models\Charts::getSubcategories(19);
        $totalNumbers = \app\models\Charts::getTotalNumbers();
        
        $yearProgression = \app\models\Charts::getYearProgression();
//        vd($yearProgression);
        
        return $this->render('index', [
            'genders' => $genders,
            'total' => $total,
            'subcategoryEntertainers' => $subcategoryEntertainers,
            'subcategoryStylists' => $subcategoryStylists,
            'totalNumbers' => $totalNumbers,
            'yearProgression' => $yearProgression,
        ]);
    }
}
