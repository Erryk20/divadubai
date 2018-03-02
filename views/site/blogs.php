<?php 
use yii\widgets\LinkPager;
use kartik\helpers\Html;
use yii\helpers\Url;


$this->title = 'News & Blogs';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="view_news single_news clearfix">
    <div class="view_content col-sm-8">
        <?php foreach ($models as $value) : ?>
            <div class="view_row">
                <div class="image">
                    <a href="<?= Url::toRoute(['/site/blog', 'id'=>$value['id']]) ?>">
                        <img src="/images/blog/<?= $value['src'] ?>" alt="">
                    </a>
                </div>
                <div class="date">By Admin on <?= date('M d, Y', $value['created_at']) ?></div>
                <div class="title">
                    <b><?= $value['title'] ?></b>
                    <?php // = Html::a($value['title'], ) ?>
                </div>
                <div class="description">
                    <?= $value['description'] ?>
                </div>
                <div class="more_wrap clearfix">
                    <?= Html::a("More", ['/site/blog', 'id'=>$value['id']], ['class'=>"more_btn"]) ?>
                    <div class="share_wrap">
                        <div class="share_btn">Share</div>
                        <div class="share_content">
                            <div class="addthis_inline_share_toolbox"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="view_sidebar col-sm-4">
        <?= $this->render('@app/views/blocks/popular-posts', [
            'popular'=>$popular,
            'recent' => $recent,
        ]) ?>
    </div>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59ccb1da02de10f7"></script> 
</div>

<div class="pagination-div">
    <?= LinkPager::widget(['pagination' => $pages]);?>
</div>