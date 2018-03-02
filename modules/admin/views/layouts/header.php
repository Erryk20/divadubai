<?php
use yii\helpers\Html;
use yii\helpers\Url;

//$user = Yii::$app->controller->getUser();

?>
<header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b><?=$title?></b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b><?=$title?></b> Administrator</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            
              
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <?php // = $this->render('@app/modules/admin/views/blocks/admin-messages') ?>
                
                <!-- Notifications: style can be found in dropdown.less -->
                <?php // = $this->render('@app/modules/admin/views/blocks/admin-notifications') ?>
                
                <!-- Tasks: style can be found in dropdown.less -->
                <?php // = $this->render('@app/modules/admin/views/blocks/admin-tasks') ?>
              
              
              <!-- User Account: style can be found in dropdown.less -->
              <!--/admin/user/view?id=1-->
              
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<?= Html::img('@web/images/user2-160x160.jpg', ['class' => 'user-image', 'alt'=>'User Image']) ?>
                  <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?= Html::img('@web/images/user2-160x160.jpg', ['class' => 'img-circle', 'alt'=>'User Image']) ?>
                    <p>
                      Alexander Pierce - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?= Url::toRoute(['/admin/user/view', 'id'=>55]); ?>" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="<?= Url::toRoute(['/site/logout']); ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
<!--              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
              
              
          </div>
        </nav>
        <?php 
            if(Yii::$app->session->hasFlash('success')) {
                $message = Yii::$app->session->getFlash('success'); 
                $this->registerJs("$.jGrowl('{$message}');", \yii\web\View::POS_END);
            }
        ?>
      </header>
