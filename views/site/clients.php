<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;


$this->title = $content['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="view_clients clearfix">
    <?php foreach ($modes as $value) : ?>
        <div class="col col-sm-6 col-md-3">
            <div class="image">
                <a href="<?= $value['url'] ?>" target="_blank">
                    <?php if(preg_match('/\.svg$/', $value['img'])) : ?> 
                            <?= Html::img("/images/clients/{$value['img']}", ['height' => 122, 'alt'=>$value['name']]) ?> 
                        <?php else : ?> 
                            <?= Html::img(
                                    $this->render('@app/views/blocks/thumbnail-url-resize-height', 
                                    ['url' => Yii::getAlias("@webroot/images/clients/{$value['img']}"), 'height' => 122]),
                                    ['alt'=>$value['name']]
                            ) ?> 
                        <?php endif; ?> 
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="pagination-div">
    <?php //= LinkPager::widget(['pagination' => $pages]);?>
</div>