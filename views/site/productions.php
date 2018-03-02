<?php 
use yii\helpers\Url;
use kartik\helpers\Html;

$this->title = $content['title'];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="view_category view_events view_production">
    <?php // if(isset($content['block_1'], $content['block_2'], $content['block_3'], $content['block_4'])) : ?>
        <div class="view_header clearfix">
            <div class="view_content">
                <div class="row">
                    <?php foreach ($category as $value) : ?>
                        <div class="col col-xs-12 col-sm-6 col-md-3">
                            <div class="image">
                                <a href="<?= Url::toRoute(["/{$value['url']}"]) ?>">
                                    <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/diva-media/{$value['img']}"), 'width' => 255, 'height' => 253]); ?>
                                </a>
                            </div>
                            <div class="title">
                                <?= Html::a($value['title'], ["/{$value['url']}"]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php if($content['block_1'] != '') : ?>
                <p class="first_paragraph"><?= $content['block_1'] ?></p>
            <?php endif; ?>
                
            <?php if($content['block_3'] != '') : ?>
                <div class="col col-sm-6 col-sm-offset-1 main_text">
                    <?= $content['block_3'] ?>
                </div>
            <?php endif; ?>
            <?php if($content['block_4'] != '') : ?>
                <p class="last_paragraph">
                    <?= $content['block_4'] ?>
                </p>
            <?php endif; ?>
        </div>
    <div class="view_content">
        <div class="description">
            <?= $content['block_5'] ?>
        </div>
    </div>
</div>