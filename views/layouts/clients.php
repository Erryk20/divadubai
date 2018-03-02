<?php
use app\assets\AppAsset;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);

//$this->registerJsFile('http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyAsgajRdZv5H2LGoHO8BXbyVZq2CLMZNxE');
//$this->registerJsFile('https://www.google.com/recaptcha/api.js');

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
            <header class="header header_inner">
                <?= $this->render('@app/views/blocks/header-page') ?>
            </header>
            <div class="popup"></div>
            <div class="wrapper_content page_clients not_front">
                <div class="middle clearfix container-fluid">
                    <div class="top_inner">
                        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]);?>
                        <?= $this->render('@app/views/blocks/top-inner') ?>
                    </div>
                    <?= $content ?>
                </div>
            </div>
        </div>
         <?php // = $this->render('@app/views/blocks/socials-block') ?>
        <footer class="footer clearfix">
            <?= $this->render('@app/views/blocks/footer') ?>
        </footer>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>