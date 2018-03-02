<?php 

use yii\helpers\Html;

$this->title = $content['title'];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="view_awards clearfix">
    <?php foreach ($modes as $value) : ?>
        <div class="col col-sm-6 col-md-3">
            <div class="col_content">
                <div class="image">
                    <a href="<?= $value['url'] ?>" target="_blank">
                        <img src="<?= "/images/awards/{$value['img']}" ?>" style="height:144px;"  alt="">
                        <?php 
//                            echo Html::img(
//                                $this->render('@app/views/blocks/thumbnail-url-resize-height', 
//                                ['url' => Yii::getAlias("@webroot/images/awards/{$value['img']}"), 'height' => 122]),
//                                ["width"=>"155px;"]
//                            ) 
                        ?> 
                    </a>
                </div>
                <div class="title">
                    <?= Html::a($value['title'], $value['url'], ['target'=>"_blank"]) ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>