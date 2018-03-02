<?php

use kartik\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\web\JqueryAsset;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('/js/infinite-scroll.pkgd.min.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('/js/masonry.pkgd.min.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('/js/imagesloaded.pkgd.min.js', ['depends' => [JqueryAsset::className()]]);

?>

<div class="filter_wrapper">
    <div class="row">
        <div class="male_filter col-sm-12 col-lg-10">
            <ul>
                <?php foreach ($menu as $value) : ?>
                    <li>
                        <?= Html::a($value['name'], [$urlCat, 'action' => $value['url']], ['class' => $value['is_active'] ? 'active' : null]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="parameters_wrap col-sm-12 col-lg-2">
            <div class="parameters_btn">Show parameters</div>
            <?= $this->render('@app/views/blocks/filter-models') ?>
        </div>
    </div>
</div>



<?php if (count($list) == 0) : ?>
    <h2>There are no models in this category.</h2>
<?php else : ?>
   
    <div class="view_directors">
        <div class="view_content">
            <div class="row">
                <?php foreach ($list as $value) : ?>
                    <div class="col col-md-3">
                        <div class="col_content">
                            <div class="video_youtube pause" data-video="<?= $value['logo'] ?>">
                                <!--<img src="/images/user-media/<?= "{$value['logo']}.jpg" ?>" alt="<?= $value['name'] ?>">-->

                                <?php //=  $this->render(
//                                    '@app/views/blocks/thumbnail-img', 
//                                    [
//                                        'url' => Yii::getAlias("@webroot/images/user-media/{$value['logo']}.png}"), 
//                                        'width' => 240, 
//                                        'height' => 320
//                                    ]) 
                                ?>
                            </div>
                            <div class="name"><a href="#"><?= $value['name'] ?></a></div>
                        </div>
                    </div>
                <?php endforeach; ?>
<!--                    <div class="col col-md-3">
                        <div class="col_content">
                            <div class="video_vimeo pause" data-video="94832897"><img src="/images/director_2.png" alt="**.Atilio"></div>
                            <div class="name"><a href="#">**.Atilio</a></div>
                        </div>
                    </div>-->
                <a href="<?= $url ?>" class="pagination__next"></a>
            </div>
        </div>
    </div>
        <?php // vd($list, false); ?> 




<!--    <ul class="view_locations view_infinite">
        <?php //= $this->render('@app/actions/views/models/infinite-scroll-director', ['list' => $list, 'url' => $url, 'urlCat' => $urlCat]) ?>
    </ul>-->
    <div class="page-load-status">
        <div class="loader-ellips infinite-scroll-request">
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
        </div>
        <p class="infinite-scroll-last">End of content</p>
    </div>
<?php endif; ?>