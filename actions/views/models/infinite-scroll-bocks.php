<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

?>
    <?php foreach ($list as $value) : ?>
        <li class="col">
            <div class="col_content">
                <div class="image">
                    <a href="<?= Url::toRoute(["{$urlCat}-profile", 'action'=>$value['action'], 'id'=>$value['info_user_id']]) ?>">
                        <?=  $this->render(
                            '@app/views/blocks/thumbnail-img', 
                            [
                                'url' => Yii::getAlias("@webroot/images/user-media/{$value['logo']}"), 
                                'width' => 240, 
                                'height' => 320
                            ]) 
                        ?>
                    </a>
                </div>
                <div class="name">
                    <?= Html::a($value['name'], ["{$urlCat}-profile", 'action'=>$value['action'], 'id'=>$value['info_user_id']]) ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
<a href="<?= $url ?>" class="pagination__next"></a>