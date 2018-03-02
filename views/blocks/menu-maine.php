<?php 
use yii\helpers\Url;
use kartik\helpers\Html;

?>

<ul class="clearfix">
    <li><?= Html::a('Home',             ['/']) ?></li>
    <li><?= Html::a('Model Management', ['/modelagency']) ?></li>
    <li><?= Html::a('Production',       ['/site/productions']) ?></li>
    <li><?= Html::a('Promotions/Activations', ['/mainpromotion']) ?></li>
    <li><?= Html::a('Events',           ['/site/events']) ?></li>
    <li><?= Html::a('Influencers',      ['/influencers']) ?></li>
    <li><?= Html::a('Public Relations', ['/site/public-relations', 'action'=> 'publicrelation']) ?></li>
    <li><?= Html::a('Awards',           ['/site/awards']) ?></li>
    <li><?= Html::a('Training',         ['/site/training']) ?></li>
    <li><?= Html::a('Our Work',         ['/site/our-work', 'action'=>'ourwork']) ?></li>
    <li><?= Html::a('FAQ',              ['/site/faq']) ?></li>
    <li><?= Html::a('Contact Us',       ['/site/contact']) ?></li>
    <li><?= Html::a('Clients',          ['/site/clients']) ?></li>
    <li><?= Html::a('Disclaimer',       ['site/disclaimer']) ?></li>
    <li><?= Html::a("Blogs",            ['/site/blogs']) ?></li>
</ul>
    