<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
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
