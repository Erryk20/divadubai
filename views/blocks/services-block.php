<?php 
use yii\helpers\Url;
use kartik\helpers\Html;

$list = \app\models\MainList::getListMainLink();


$count = count($list);
$i = 1;

?>

<div class="block_wrapper container">
    <div class="block_content ">
        <?php foreach ($list as $value) : ?>
            <?php if(($i%6) == 1) : ?>
                <?php if($i != 1){echo '</div></div>';} ?>
                <div class="slide">
                    <div class="row">
            <?php endif; ?>
            
                <?php if(in_array(($i%6), [0, 1])) : ?>
                    <div class="col col-sm-4 col-md-6">
                        <div class="image">
                            <a href="<?= Url::toRoute(["/{$value['link']}"]) ?>">
                                <?php // = $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/{$value['src']}"), 'width' => 540, 'height' => 253])    ?>
                                <?= Html::img($this->render('@app/views/blocks/thumbnail-url-resize-height', ['url' => Yii::getAlias("@webroot/{$value['src']}"), 'height' => 253])) ?> 
                            </a>
                        </div>
                        <div class="title">
                            <a href="<?= Url::toRoute(["/{$value['link']}"]) ?>"><?= $value['name'] ?></a>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="col col-sm-4 col-md-3">
                        <div class="image">
                            <a href="<?= Url::toRoute(["/{$value['link']}"]) ?>">
                                <?= Html::img($this->render('@app/views/blocks/thumbnail-url-resize-height', ['url' => Yii::getAlias("@webroot/{$value['src']}"), 'height' => 253])) ?> 
                                
                                <?php // = $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/{$value['src']}"), 'width' => 255, 'height' => 253])    ?>
                            </a>
                        </div>
                        <div class="title">
                            <a href="<?= Url::toRoute(["/{$value['link']}"]) ?>"><?= $value['name'] ?></a>
                        </div>
                    </div>
                <?php endif; ?>
                        
            <?php if($i++ == $count){echo '</div></div>';} ?>
        <?php endforeach; ?>
        
    </div>
    <div class="container title_wrapper">
        <div class="block_title">Services</div>
    </div>
</div>