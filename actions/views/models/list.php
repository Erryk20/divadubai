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
    <ul class="view_locations view_infinite">
    <?= $this->render('@app/actions/views/models/infinite-scroll-bocks', ['list' => $list, 'url' => $url, 'urlCat' => $urlCat]) ?>
    </ul>
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