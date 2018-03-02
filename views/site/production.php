<?php 
use yii\helpers\Url;
use kartik\helpers\Html;
use app\assets\JqueryAsset;

$this->title = isset($categoryes[$action]['title']) ? $categoryes[$action]['title'] :  ucfirst($action);
$this->params['breadcrumbs'][] = $type == 'event' ? 'Events' : "Production";

$this->registerJsFile('/js/infinite-scroll.pkgd.min.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('/js/masonry.pkgd.min.js', ['depends' => [JqueryAsset::className()]]);
$this->registerJsFile('/js/imagesloaded.pkgd.min.js', ['depends' => [JqueryAsset::className()]]);

?>
<div class="filter_wrapper">
    <div class="row">
        <div class="male_filter col-sm-12 col-lg-10">
            <ul>
                <?php foreach ($categoryes as $item) : ?>
                    <li>
                        <?= Html::a($item['title'], [$item['pre_url'], 'action'=>$item['url']], ['class'=> ($item['url'] == $action) ? 'active' : null ]) ?>
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
<ul class="view_models">
    <?php if(count($list) == 0 ) : ?>
        <h2>There are no models in this category.</h2>
    <?php else : ?>
        <ul class="view_content view_infinite">
            <?= $this->render('@app/views/blocks/infinite-scroll-production-bocks', ['list' => $list, 'url' => $url, 'type'=>$type, 'action'=> $action]) ?>
        </ul>
    <?php endif; ?>
</div>