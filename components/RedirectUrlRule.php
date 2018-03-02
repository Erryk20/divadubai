<?php
namespace app\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use Yii;

class RedirectUrlRule  extends BaseObject implements UrlRuleInterface{
    
    public function createUrl($manager, $route, $params){
        if(debug()){
            $query = "
                        SELECT * 
                        FROM `redirect` 
                        WHERE `old_url` = :url
                    ";

            $newURL = Yii::$app->db->createCommand($query, [':url'=> 'malemodels'])->queryOne();

    //         'model-management/<gender>'=>'/site/model-management',
//            vd($newURL);

            if($newURL){
                return 'search/index'; //$newURL['new_url'];
            }
            return false; // данное правило не применимо
        }
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        if (preg_match('%^(\w+)(/(\w+))?$%', $pathInfo, $matches)) {
            // Ищем совпадения $matches[1] и $matches[3] 
            // с данными manufacturer и model в базе данных
            // Если нашли, устанавливаем $params['manufacturer'] и/или $params['model']
            // и возвращаем ['car/index', $params]
        }
        return false;  // данное правило не применимо
    }
   
}
