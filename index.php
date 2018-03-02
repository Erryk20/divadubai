<?php

if(isset($_GET['ip'])){
    print_r($_SERVER["REMOTE_ADDR"]);
//    /home/divaduba/public_html/webcaptain

//    phpinfo();
    die(); 
}

function debug() {
    if (in_array($_SERVER["REMOTE_ADDR"], ['127.0.0.1', '46.164.190.101', '31.128.82.185']))
        return true;
    else
        return false;
}

// comment out the following two lines when deployed to production
if (debug()) {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
} else {
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    defined('YII_ENV') or define('YII_ENV', 'prod');
}

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/config/web.php');

(new yii\web\Application($config))->run();



function vd($var, $exit = true) {
    if(debug()){
        $dumper = new yii\helpers\BaseVarDumper();
        echo $dumper::dump($var, 10, true);
        echo "<br/>";
        echo "<br/>";
        if ($exit)
            die("<br/>end");
    }
}


function die_my() {
    if(debug()){
        die("<br/>end");
    }
}
