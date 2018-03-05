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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "/css/normalize.css",
//        "/css/bootstrap.min.css",
        "/css/style.min.css?v=11",
        "/css/jquery.jgrowl.min.css",
        "/css/jquery-ui.min.css",
        
        "/css/slick.css",
    ];
    
    public $js = [
        "/js/main.js",
        "/js/jquery.jgrowl.min.js",
//        "/js/jquery-ui.min.js",
        "/js/slick.min.js",
        '/js/jquery.livequery.min.js',
        
	'/js/infinite-scroll.pkgd.min.js',
//	'/js/imagesloaded.pkgd.min.js',
//	'/js/cropper.min.js',
//	"/js/main.js",
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\JqueryAsset',
    ];
}
