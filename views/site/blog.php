<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

$this->title = 'News & Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="view_news clearfix">
    <div class="view_content col-sm-8">
        <div class="view_row">
            <div class="image">
                <img src="/images/blog/<?= $model['src'] ?>" alt="">
            </div>
            <div class="date">By Admin on <?= date('M d, Y', $model['created_at']) ?></div>
            <div class="title">
                <b><?= $model['title'] ?></b>
            </div>
            <div class="description">
                <?= $model['description'] ?>
            </div>
        </div>
    </div>
    <div class="view_sidebar col-sm-4">
        <?= $this->render('@app/views/blocks/popular-posts', [
            'popular'=>$popular,
            'recent' => $recent,
        ]) ?>
    </div>
</div>