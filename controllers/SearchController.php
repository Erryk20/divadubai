<?php
namespace app\controllers;

use Yii;
//use app\components\Controller;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Url;
use app\models\Products;

use kartik\mpdf\Pdf;


class SearchController extends Controller {
    
    public $seo = [
        'title'=>'',
        'keywords'=>'',
        'description'=>'',
    ];
    
    
    public function actionIndex($q = ''){
        $this->layout = 'search';
        $request = \Yii::$app->request;
        
        $categories = \app\models\ModelCategory::getListAllCategory();
        
        $Qarray = explode(' ', trim($q));
        
        $categoryID = '';
        foreach ($categories AS $key => $value){
            foreach ($Qarray AS $cut){
                if(preg_match("/{$cut}/ui", $value)){
                    $categoryID[] = $key;
                    $q = trim(str_replace($cut, '', $q));
                }
            }
        }
        $categoryID = implode(',', $categoryID);
       
        $count = \app\models\SearchForm::getCountAllSearch($q, $categoryID);
        
        $page = (int) $request->get('page', 1);
        $limit = $request->get('limit', 16);
        $offset = ($page == 1) ? 0 : ($limit * ($page-1));
        
        $pages = new \yii\data\Pagination([
            'totalCount' => (int) $count, 
            'pageSize' => $limit,
        ]);
        $pages->pageSizeParam = false;
        
        $list = \app\models\SearchForm::searchAll($q, $categoryID, $limit, $offset);
     
        return $this->render('index', [
            'title' => 'Search',
            'pages' => $pages,
            'list' => $list
        ]);
    }
}
