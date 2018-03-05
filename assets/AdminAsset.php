<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "/css/admin.css",
        "css/font-awesome.min.css",
        "css/nprogress.css",
        "css/jquery.mCustomScrollbar.min.css",
        "css/custom.min.css",
        
        "css/jquery-ui.min.css",
        "css/jquery-ui.structure.css",
        "css/jquery-ui.structure.min.css",
        "css/jquery-ui.theme.css",
        "css/jquery-ui.theme.min.css",
    ];
    
    public $js = [
        "js/jquery-ui.min.js",
        "/js/jquery.jgrowl.min.js",
        "js/fastclick.js",
        "js/nprogress.js",
        "js/jquery.mCustomScrollbar.concat.min.js",
        "js/custom.min.js",
        
        'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
        'https://cdn.rawgit.com/websemantics/bragit/0.1.2/bragit.js',
    ];
    
    public $depends = [
//        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\JqueryAsset',
        'yiister\gentelella\assets\Asset',
    ];
}
