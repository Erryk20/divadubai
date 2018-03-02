<?php

use app\assets\AppAsset;
use yii\widgets\Breadcrumbs;

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
        <div class="wrapper">
            <header class="header header_inner">
                <?= $this->render('@app/views/blocks/header-page') ?>
            </header>
            <div class="popup"></div>
            <div class="wrapper_content not_front">
                <div class="middle clearfix container">
                    <div class="top_inner">
                        <div class="breadcrumbs">
                            <a href="/">Home</a>
                            <span class="this">Search</span>
                        </div>
                        <h1 class="page_title">Search</h1>
                    </div>
                    <div class="search clearfix">
                        <div class="search__content">
                            <?= $content ?>
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