<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

?>
<div class="block_content container">
    <div class="row">
        <div class="col col-sm-6 col-md-3">
            <div class="image">
                <a href="<?= Url::toRoute(['/site/awards']) ?>">
                    <img src="/images/awards.jpg" alt="">
                </a>
            </div>
            <div class="title">
                <?= Html::a('Awards', ['/site/awards']) ?>
            </div>
        </div>
        <div class="col col-sm-6 col-md-3">
            <div class="image">
                <a href="<?= Url::toRoute(['/site/clients']) ?>">
                    <img src="/images/our-clients.jpg" alt="">
                </a>
            </div>
            <div class="title">
                <?= Html::a('Our Clients', ['/site/clients']) ?>
            </div>
        </div>
        <div class="col col_text col-sm-6">
            <h2 class="main_title">Our<br>Achievements</h2>
            <div class="description">Our vast experience and largest database of talents in the ME region make us the best choice. Diva Modelling and Events is the Gulfs’ leading Modelling Agency. Having an elite reputation for providing top-class international models, hostesses, promoters, staff and entertainers that is second to none. We have completed print and video production campaigns, fashion events, gala events and product launches to name a few for many high profile clients.</div>
        </div>
    </div>
    <div class="row">
        <div class="col col_text col-sm-3 visible-md visible-lg"></div>
        <div class="col col-sm-6 col-md-3">
            <div class="image">
                <a href="<?= Url::toRoute(['/site/our-work']) ?>">
                    <img src="/images/our-works-.jpg" alt="">
                </a>
            </div>
            <div class="title">
                <?= Html::a('Our Works', ['/site/our-work']) ?>
            </div>
        </div>
        <div class="col col-sm-6 col-md-3">
            <div class="image">
                <a href="<?= Url::toRoute(['/site/blogs']) ?>">
                    <img src="/images/news-and-blogs-.jpg" alt="">
                </a>
            </div>
            <div class="title">
                <?= Html::a('News & Blogs', ['/site/blogs']) ?>
            </div>
        </div>
    </div>
</div>