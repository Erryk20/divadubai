<?php 
use yii\helpers\Url;
use kartik\helpers\Html;

?>


<div class="block_popular block">
    <div class="block_title">Popular posts</div>
    <div class="block_content">
        <?php foreach ($popular as $value) : ?>
            <div class="view_row">
                <div class="image">
                    <a href="<?= Url::toRoute(['/site/blog', 'id'=>$value['id']]) ?>">
                        <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/blog/{$value['src']}"), 'width' => 67, 'height' => 67]) ?>
                    </a>
                </div>
                <div class="title_wrap">
                    <div class="title">
                        <?= Html::a($value['title'], ['/site/blog', 'id'=>$value['id']]) ?>
                    </div>
                    <div class="description">
                        <?= $value['description'] ?>
                    </div>
                </div>
            </div>
            <div class="view_row">
                <div class="image">
                    <a href="#">
                        <img src="../images/news_min_2.jpg" alt="">
                    </a>
                </div>
                <div class="title_wrap">
                    <div class="title">
                        <?= Html::a($value['title'], ['/site/blog', 'id'=>$value['id']]) ?>
                    </div>
                    <div class="description">
                        <?= $value['description'] ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="block_recent block">
    <div class="block_title">Recent posts</div>
    <div class="block_content">
        <?php foreach ($recent as $value) : ?>
            <div class="view_row">
                <div class="title">
                    <?= Html::a($value['title'], ['/site/blog', 'id'=>$value['id']]) ?>
                </div>
                <div class="date"><?= date('M d, Y', $value['created_at']) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

