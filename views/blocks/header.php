<?php 
use yii\helpers\Url;

if(Yii::$app->session->hasFlash('success')):
    $message = Yii::$app->session->getFlash('success'); 
    $this->registerJs("$.jGrowl('{$message}', {theme:'bg-green'});", \yii\web\View::POS_END);
endif; ?>

<nav class="main_menu">
    <?= $this->render('@app/views/blocks/menu-clearfix') ?>
</nav> 
<div class="header_content clearfix">
    <div class="dropdown_menu">
        <div class="menu_btn">
            <div class="item_1 item">-</div>
            <div class="item_2 item">-</div>
            <div class="item_3 item">-</div>		
        </div>
        <div class="menu_show">
            <?= $this->render('@app/views/blocks/menu-maine') ?>
        </div>
    </div>
    
    <div class="search_block">
        <a href="<?= Url::toRoute(['/site/favourite']) ?>" class="cart_btn">Cart</a>
        <div class="search_btn">Search</div>
        <div class="search_form">
            <form action="#">
                <input type="text" class="form_text" placeholder="Search">
                <input type="submit" class="form_submit" value="Search">
            </form>
        </div>
    </div>
    <div class="logo"><a href="/"><img src="/images/logo.png" alt="Diva | Modeling & Events FZ - LLC"></a></div>
</div>