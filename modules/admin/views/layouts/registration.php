<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use app\assets\AdminLteAsset;
//use yii\web\JqueryAsset;

//JqueryAsset::register($this);
//AppAsset::register($this);

$asset      = AdminLteAsset::register($this);
$baseUrl    = $asset->baseUrl;



//        "/css/style.min.css?v=9",
//        "/css/jquery-ui.min.css",

//        
//	'/js/infinite-scroll.pkgd.min.js',


?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-red sidebar-mini">
<?php $this->beginBody() ?>
    
<?php 
$this->registerJsFile('/js/main.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/js/imagesloaded.pkgd.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

$this->registerCssFile('/css/style.min.css?v=9', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerCssFile('/css/jquery-ui.min.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);

?>


<div class="wrapper">
    <?= $this->render('header.php', ['baserUrl' => $baseUrl, 'title'=>Yii::$app->name]) ?>
    <?= $this->render('leftside.php', ['baserUrl' => $baseUrl]) ?>
    
        <div class="page_register">
            <?= $this->render('content.php', ['content' => $content]) ?>
        </div>
    
    <?= $this->render('footer.php', ['baserUrl' => $baseUrl]) ?>
    <?= $this->render('rightside.php', ['baserUrl' => $baseUrl]) ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
