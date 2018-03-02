<?php 
use yii\helpers\Url;
use kartik\helpers\Html;
use app\assets\JqueryAsset;

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
                <?php foreach ($menu as $key => $value) : ?>
                    <li>
                        <?= Html::a($value['name'], [$pre_url, 'url'=>$value['slug']], ['class'=> $value['is_active'] ? 'active' : null ]) ?>
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

<?php

?>

<ul class="view_locations view_infinite">
    <?= $this->render('@app/views/blocks/infinite-scroll-promotions-bocks', [
            'url' => $url,
            'list' => $list,
            'url_profile'=> $url_profile,
        ]) ?>
</ul>