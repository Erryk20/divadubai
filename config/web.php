<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => ['class' => 'app\modules\admin\Module'],
        'gridview' => [ 'class' => '\kartik\grid\Module' ] 
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@adminlte/widgets'=>'@vendor/adminlte/yii2-widgets'
    ],
    'components' => [
        'pdf' => [
            'class' => kartik\mpdf\Pdf::classname(),
            'format' => kartik\mpdf\Pdf::FORMAT_A4,
            'orientation' => kartik\mpdf\Pdf::ORIENT_LANDSCAPE,
//            'destination' => kartik\mpdf\Pdf::DEST_DOWNLOAD,
            // refer settings section for all configuration options
        ],
//        'assetManager' => [
//            'bundles' => [
//                'dmstr\web\AdminLteAsset' => [
//                    'skin' => 'skin-red',
//                ],
//            ],
//        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LefYDAUAAAAAAc6VtVeK3v5Zxy3F4ANSJg3VyPZ',
            'secret' => '6LefYDAUAAAAAB3DS1QKXjTT5TyGuogFapF1mG-L',
        ],
        'thumbnail' => [
            'class' => 'sadovojav\image\Thumbnail',
            'cachePath' => '@webroot/thumbnails',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
//            'class' => 'app\components\Request',
            'cookieValidationKey' => 'Aq4Rbadk9rGadi2yp6z-JV6GnucFoFZm',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'model-management/<action>/<id:\d+>' => '/site/model-management-profile',

                'reset-password/<token>' => '/site/reset-password',
                
//                '<action:(reset-password)>' => '/site/<action>',
//                '<action:(male|female|family)>casts' => '/site/production',
//                '<action:(malecasts|femalecasts|familycasts)>' => '/site/production',
//                '<action:(casts|director|stylist|catering)>' => '/site/production',
                '<action:(photographers|director|stylists|productions|locations|malecasts|femalecasts|familycasts)>' => '/site/production',
                
                '<action:(internationalmodels|malemodels|femalemodels|boymodels|girlmodels|childmodels)>'=>'/site/model-management',
                
                '<category:(directors)>'=> 'site/register',

                'requestpasswordreset'    => '/site/request-password-reset',
                'mainproduction'    => '/site/productions',
                'modelagency'       => '/site/productions',
                'mainpromotion'     => '/site/productions',
                'modelagency'       =>'/site/productions',

                '<action:(publicrelation|permit)>'=>'/site/public-relations',
                
//                'influencers' => '/site/digital-marketing',
                
                
                '<action:(malehost|malepromoters|femalepromoters|femalehostess)>'=>'/site/promotions-activations',
                
                'categoryevents' => '/site/events',
                '<action:(eventsupport|entertainer)>' => '/site/event',
                '<action:(influencers)>'=>'/site/digital-marketing',
                '<action:(ourwork)>'=>'/site/our-work',

                
//                '<url:(mainpromotion|hostess)>'=>'/site/promotions-activations',
                
//                '<url:(male|female)promoters>'=>'/site/promotions-activations',
//                'female<url:hostess>'=>'/site/promotions-activations',
//                'male<url:host>'=>'/site/promotions-activations',
                
                'promotions-activations/<url>'=>'/site/promotions-activations',
                'promotions-activations'=>'/site/promotions-activations',
                
               
                
                
                'award'=>'/site/awards',
                'book<action:(photoshoot|fashion|host|entertainer|tvc|video|location|other)>' => '/site/book',
                'register<category:(\w+)>'=> 'site/register',

                'bookingprocess/<id:\d+>/<type>'=>'/site/bookingprocess',


                
                'ajax/<action>'=>'ajax/<action>',
                'sinc'=>'sinc/index',
                'sinc/<action>'=>'sinc/<action>',
                
                'admin'=>'admin/user-info',
//                'admin/it-manager'=>'admin/default',
                'admin/register<category:(\w+)>'=>'admin/register',
                'admin/<category:directors>'=>'admin/register',
                'admin/<controler>'=>'admin/<controler>',
                
                'admin/<controler>/<action>'=>'admin/<controler>/<action>',
                
                '/download/<action>/<id:\d+>'=>'/download/<action>',
                '/download/<action>'=>'/download/<action>',
                
//                [
//                    'class' => 'app\components\RedirectUrlRule'
//                ],
                'search'=>'search/index',
                'logout'=>'site/logout',
                'login'=>'site/login',
                'index'=>'site',
                'register'=>'site/register',
                
                'aboutus'=>'site/about-us',
                
                'profile/<id:\d+>'=>'/site/profile',
                
//                'model-management/<action>'=>'/site/model-management',
                
                'digital-marketing/<action>/<id:\d+>'=>'/site/digital-marketing-profile',
                'digital-marketing/<url>'=>'/site/digital-marketing',
                'digital-marketing'=>'/site/digital-marketing',
                
                'production/<action>/<id:\d+>' => '/site/production-profile',
                
                
                

                
                'our-work/<action>/<id:\d+>'=>'/site/our-work-profile',
                'our-work/<url>'=>'/site/our-work',
                'our-work'=>'/site/our-work',
                
                'promotions-activations/<action>/<id:\d+>'=>'/site/promotions-activations-profile',
                'event/<action>/<id:\d+>'=>'/site/event-profile',
           
                
                'service'=>'site/services',
                'services/<service>/<url>' => '/site/service',
                'services/<service>' => '/site/service',
                'service-profile/<service>/<category>/<info_user_id:\d+>' => '/site/service-profile',
                

                
                'disclaimer'=>'site/disclaimer',
                'training'=>'/site/training',
//                'public-relations'=>'site/public-relations',
                
                'contactus'=>'/site/contact',
                'awards'=>'/site/awards',
                'clients'=>'/site/clients',
                'frequentlyaskedquestions'=>'/site/faq',
                'registration'=>'/site/registration',
                'officeimages' => '/site/office',
                
                'my-castings' => '/site/my-castings',
                'my-book' => '/site/my-book',
                'favorite-castings' => '/site/favorite-castings',
                'casting' => '/site/casting',
                
                'newsblog' => '/site/blogs',
                'blog/<id:\d+>' => '/site/blog',
                
                'production/<action>' => '/site/production',
                'productions' => '/site/productions',
                'event/<action>' => '/site/event',
                
                'book/<action>' => '/site/book',
                
                
                'dashboard' => '/site/dashboard',
                'favourite' => '/site/favourite',
                
                'edite-profile/<info_user_id:\d+>' => '/site/edite-profile',
                
                '<category>/<action>/<info_user_id:\d+>' => '/site/diva',
                
                '<parent>/<children>/<user_id>' => '/site/model',
                
                
                '<parent>/<children>' => '/site/children',
                '<parent>' => '/site/parent',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '46.164.190.101', '31.128.82.185'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '46.164.190.101', '31.128.82.185'],
    ];
}

return $config;
