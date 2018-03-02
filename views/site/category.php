<?php
use yii\helpers\Url;

$this->title = $model['name'];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="view_category">
    <div class="view_content">
        <?php foreach ($chilldren as $value) : ?>
            <div class="col col-xs-12 col-sm-6 col-md-3">
                <div class="image">
                    <a href="<?= Url::toRoute([$value['pre_url'], 'parent'=>$model['url'], 'children'=>$value['children']]) ?>">
                        <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/{$value['src']}"), 'width' => 255, 'height' => 253])    ?>
                    </a>
                </div>
                <div class="title">
                    <a href="<?= Url::toRoute([$value['pre_url'], 'parent'=>$model['url'], 'children'=>$value['children']]) ?>">
                        <?= $value['name'] ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="view_header clearfix">
        <div class="col col-sm-5">
            <blockquote>
                <?= $model['blockquote'] ?>
            </blockquote>		
        </div>
        <div class="col col-sm-6 col-sm-offset-1 main_text">
            <?= $model['description'] ?>
        </div>
    </div>
</div>