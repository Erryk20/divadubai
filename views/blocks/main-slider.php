<?php 
use yii\helpers\Html;

$list = app\models\Slider::getAllList();
$sliderProperty = \app\models\Settings::getSliderProperty();

?>


<div data-pause="<?= $sliderProperty['pause'] ?>" data-speed="<?= $sliderProperty['speed'] ?>" class="main_slider">
    <div class="block_content">
        <?php foreach ($list as $value): ?>
            <div class="slide">
                <div class="image">
                    <img class="active" src="<?= $value['src'] ?>" alt="">
                      <?php 
//                      = Html::img(
//                            $this->render('@app/views/blocks/thumbnail-url-resize-height', 
//                            ['url' => Yii::getAlias("@webroot{$value['src']}"), 'height' => 1080]),
//                            ["width"=>"1920px;"]
//                    ) ?> 
                </div>
                <div class="container slider_text">
                    <div class="title"><?= $value['title'] ?></div>
                    <div class="description"><?= $value['description'] ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>