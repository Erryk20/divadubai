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
            <div class="wrapper_content page_office not_front">
                <div class="middle clearfix container-fluid">
                    <div class="top_inner">
                        <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]);?>
                        <div class="page_arrows_wrap clearfix">
                            <div class="page_arr prev_arr">Prev</div>
                            <div class="page_arr next_arr">Next</div>
                        </div>
                        <h1 class="page_title"><?= Yii::$app->controller->top_text ?></h1>
                    </div>
                    <?= $content ?>
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