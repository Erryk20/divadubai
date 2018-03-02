<?php
use app\assets\AppAsset;
use yii\helpers\Html;

$this->registerJsFile('/js/slick.min.js', [
    'depends' => [\yii\web\JqueryAsset::className()]
]);

$this->registerCssFile('/css/slick.css', [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);

AppAsset::register($this);
?>



<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= $this->render('@app/views/blocks/head') ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="wrapper front">
            <header class="header">
                <?= $this->render('@app/views/blocks/header-page') ?>
            </header>
            <div class="popup"></div>
            <div class="wrapper_content">
                    <div class="middle clearfix">
                            <?= $this->render('@app/views/blocks/main-slider') ?>
                            <div class="services_block">
                                <?= $this->render('@app/views/blocks/services-block') ?>
                            </div>
                            <div class="achievements_block">
                                <?= $this->render('@app/views/blocks/achievements-block') ?>
                            </div>
                            <div class="registrer_block">
                                    <div class="block_content container">
                                            <div class="col col-lg-6">
                                                    <h2 class="main_title">Register Now</h2>
                                                    <div class="description">
                                                        Register with Us and be discoverd among the best companies and brands across the region
                                                    </div>
                                                    <?= Html::a('Register', ['site/register'], ['class'=>"register_btn"]) ?>
                                            </div>
                                            <div class="col col-lg-6"></div>
                                    </div>
                            </div>
                            <div class="socials_block">
                                <?= $this->render('@app/views/blocks/socials-block') ?>
                            </div>
                            <div class="company_block">
                                <div class="block_content container">
                                    <div class="row">
                                        <?= $content ?>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>
    </div>
    <footer class="footer clearfix">
        <?= $this->render('@app/views/blocks/footer') ?>
    </footer>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>