<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

?>
<?php foreach ($list as $value) : ?>
    <li class="col">
        <div class="col_content">
            <div class="image">
                <a href="<?= Url::toRoute([$url_profile, 'url' => $value['type'], 'id' => $value['info_user_id']]) ?>">
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
                <?= Html::a("{$value['short']}*{$value['info_user_id']}", [$url_profile, 'type' => $value['type'], 'id' => $value['info_user_id']]) ?>
            </div>
        </div>
    </li>
<?php endforeach; ?>
<a href="<?= $url ?>" class="pagination__next"></a>