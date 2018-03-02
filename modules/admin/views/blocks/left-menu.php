<?php 
use yii\helpers\Url;
$item = preg_replace("/(\/index)?\?.*/iu", '', Yii::$app->request->url);
?>


<div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
        <a href="index.html" class="site_title">
            <img alt="" src="/images/WebCapitan.png">
        </a>
    </div>

    <div class="clearfix"></div>
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
                <li>
                    <a target="_blank" href="<?= Yii::$app->request->hostInfo ?>">
                        <i class="fa fa-globe"></i>
                        <?= Yii::t('app', 'Site') ?>
                    </a>
                </li>
                <?php if(debug()) : ?>    
                    <li <?= ($item == '/gii') ? "class='current-page'" : null ?>>
                        <a href="<?= Url::to(['/gii']) ?>" target="_blank">
                            <i class="fa fa-cubes"></i>
                            <?= Yii::t('app', 'Gii') ?>
                        </a>
                    </li>
                <?php endif; ?>
<!--                <li <?= ($item == '/admin/settings') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/settings']) ?>">
                        <i class="fa fa-cogs"></i>
                        <?= Yii::t('app', 'Settings') ?>
                    </a>
                </li>-->
                    
                <li <?= ($item == '/admin/user') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/user']) ?>">
                        <i class="fa fa-users"></i>
                        <?= Yii::t('app', 'Users') ?>
                    </a>
                </li>
                    
                <li <?= ($item == '/admin/share') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/share']) ?>">
                        <i class="fa fa-share-alt"></i>
                        <?= Yii::t('app', 'Share') ?>
                    </a>
                </li>
                
                <li <?= ($item == 'slider') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/slider']) ?>">
                        <i class="fa fa-exchange"></i>
                        <?= Yii::t('app', 'Slider') ?>
                    </a>
                </li>
                
                <li <?= ($item == 'categories') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/categories']) ?>">
                        <i class="fa fa-tasks"></i>
                        <?= Yii::t('app', 'Categories') ?>
                    </a>
                </li>
                <li <?= ($item == 'contacts') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/contacts']) ?>">
                        <i class="fa fa-map-marker"></i>
                        <?= Yii::t('app', 'Contacts') ?>
                    </a>
                </li>
                <li <?= ($item == 'awards') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/awards']) ?>">
                        <i class="fa fa-handshake-o"></i>
                        <?= Yii::t('app', 'Awards') ?>
                    </a>
                </li>
                
                
<!--                <li <?= ($item == 'pages') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/pages']) ?>">
                        <i class="fa fa-file-text-o"></i>
                        <?= Yii::t('app', 'Pages') ?>
                    </a>
                </li>-->
                
<!--                <li>
                    <a>
                        <i class="fa fa-bullhorn"></i>
                        <?= Yii::t('app', 'News') ?>
                        <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu" <?= preg_match("/(admin\/news|admin\/news-categories)/", $item) ? "style='display: block'" : null ?>>
                        <li <?= ($item == '/admin/news-categories') ? "class='current-page'" : null ?> ><a href="<?= Url::to(['/admin/news-categories']) ?>"><?= Yii::t('app', 'Categories') ?></a></li>
                        <li <?= ($item == '/admin/news') ? "class='current-page'" : null ?> ><a href="<?= Url::to(['/admin/news']) ?>"><?= Yii::t('app', 'News') ?></a></li>
                    </ul>
                </li>-->
                
                <!--- 
                <li <?= ($item == '/admin/page') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/page']) ?>">
                        <i class="fa fa-file"></i>
                        <?= Yii::t('app', 'Pages') ?>
                    </a>
                </li>
                
                
                
                
                
                
                <li>
                    <a>
                        <i class="fa fa-comments"></i>
                        <?= Yii::t('app', 'FAQs') ?>
                        <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu" <?= preg_match("/(admin\/upload|admin\/videos)/", $item) ? "style='display: block'" : null ?>>
                        <li <?= ($item == '/admin/category-faqs') ? "class='current-page'" : null ?> ><a href="<?= Url::to(['/admin/category-faqs']) ?>"><?= Yii::t('app', 'Category FAQs') ?></a></li>
                        <li <?= ($item == '/admin/faqs') ? "class='current-page'" : null ?> ><a href="<?= Url::to(['/admin/faqs']) ?>"><?= Yii::t('app', 'FAQs') ?></a></li>
                    </ul>
                </li>
               
                <li <?= ($item == '/admin/seo') ? "class='current-page'" : null ?>>
                    <a href="<?= Url::to(['/admin/seo']) ?>">
                        <i class="fa fa-chain-broken"></i>
                        <?= Yii::t('app', 'SEO') ?>
                    </a>
                </li>
                
                <li>
                    <a>
                        <i class="fa fa-language"></i>
                        <?= Yii::t('app', 'Language') ?>
                        <span class="fa fa-chevron-down"></span>
                    </a>
                    <ul class="nav child_menu" <?= ($item == 'message') ? "style='display: block'" : null ?>>
                        <li <?= ($item == '/admin/source-message') ? "class='current-page'" : null ?> ><a href="<?= Url::to(['/admin/source-message']) ?>"><?= Yii::t('app', 'Source message') ?></a></li>
                        <li <?= ($item == '/admin/language') ? "class='current-page'" : null ?> ><a href="<?= Url::to(['/admin/language']) ?>"><?= Yii::t('app', 'Language') ?></a></li>
                        <li <?= ($item == '/admin/message') ? "class='current-page'" : null ?> ><a href="<?= Url::to(['/admin/message']) ?>"><?= Yii::t('app', 'Message') ?></a></li>
                    </ul>
                </li>
                -->
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
        <a href="<?= Url::toRoute("/logout") ?>" data-toggle="tooltip" data-placement="top" title="Logout">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
    </div>
    <!-- /menu footer buttons -->
</div>
