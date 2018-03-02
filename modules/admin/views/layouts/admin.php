<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAsset;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <?= $this->render('@app/modules/admin/views/blocks/head') ?>
    </head>
    <body class="nav-md">
    <?php $this->beginBody() ?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
            <?= $this->render('@app/modules/admin/views/blocks/left-menu') ?>
        </div>


        <!-- top navigation -->
        <div class="top_nav">
            <?= $this->render('@app/modules/admin/views/blocks/header') ?>
        </div>
        
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
<!--                <div class="page-title">
                    <div class="title_left">
                        <h3><?= $this->title ?></h3>
                    </div>
                </div>-->
                <?= $content ?>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <?= $this->render('@app/modules/admin/views/blocks/footer') ?>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

   
    <?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>