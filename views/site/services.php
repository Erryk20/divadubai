<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
//vd($list);
?>
<div class="view_services clearfix">
    <?php foreach ($list as $name => $value) : ?>
        
        <div class="col col-md-3 col-sm-6">
            <div class="image">
                <a href="<?= Url::toRoute(["/{$value['link']}"]) ?>">
                    <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/main-list/{$value['src']}"), 'width' => 255, 'height' => 276]) ?>
                </a>
            </div>
            <div class="title">
                <?= Html::a($name, [$value['link']]) ?>
            </div>
            <ul class="sub_services">
                <?php foreach ($value['list'] as $item) : ?>
                    <li>
                        <?= Html::a($item['name'], [$item['link']]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>