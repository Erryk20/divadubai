<?php
namespace app\assets;
 
use yii\web\AssetBundle;
use yii\web\View;
 
class JqueryAsset extends AssetBundle
{
    public $js = [
//         "/js/jquery-2.2.4.min.js",
//         "/js/jquery.js",
        "/js/jquery-ui.min.js",
//        "/js/bootstrap.min.js",
    ];
    
    public $jsOptions = [
        'position' => View::POS_END, 
    ];
    
    
}