<?php

use yii\helpers\Url;
use kartik\helpers\Html;

$this->title = $content['title'];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="view_category view_events">
    <div class="view_header clearfix">
        <div class="col col-sm-12">
            <div class="view_content">
                <?php foreach ($category as $value) : ?>
                    <div class="col col-xs-12 col-sm-6 col-md-3">
                        <div class="image">
                            <a href="<?= Url::toRoute(["/{$value['url']}"]) ?>">
                                <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/diva-media/{$value['img']}"), 'width' => 255, 'height' => 253]); ?>
                            </a>
                        </div>
                        <div class="title">
                            <?= Html::a($value['title'], ['/site/event', 'action' => $value['url']]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <p><?= $content['block_1'] ?></p>
            <blockquote><?= $content['block_2'] ?></blockquote>		
            <p><?= $content['block_3'] ?></p>
            <p><?= $content['block_4'] ?></p>
        </div>
    </div>

    <div class="description">
<?= $content['block_5'] ?>
    </div>
</div>