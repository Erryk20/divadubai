<?php

use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;

$this->title = $title;
//$this->params['breadcrumbs'][] = "{$model['short']}.*{$model['id']}";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => $pre_url];

$this->registerCssFile('/css/photobox.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/js/jquery.photobox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<div class="top_inner">
<?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]); ?>
    <div class="page_arrows_wrap clearfix">
    <?php if ($nextPrev['prev_id']) : ?>
            <div class="page_arr prev_arr">
            <?=
            Html::a("Prev", [
                $nextPrev['pre_url'],
                'action' => $nextPrev['action'],
                'id' => $nextPrev['prev_id']
            ])
            ?>
            </div>
            <?php endif; ?>

        <?php if ($nextPrev['next_id']) : ?>
            <div class="page_arr next_arr">
            <?=
            Html::a("Next", [
                $nextPrev['pre_url'],
                'action' => $nextPrev['action'],
                'id' => $nextPrev['next_id']
            ])
            ?>
            </div>
        <?php endif; ?>
    </div>
    <h1 class="page_title"><?= "{$model['short']}.*{$model['id']}" ?></h1>
</div>

<div class="view_directors view_directors-inner">
    <div class="director_popup">
        <div class="director_iframe">
            <div class="close"></div>
            <div class="director_iframe_content"></div>
        </div>
    </div>
    <div class="view_content">
        <div class="row">
            <?php if (isset($list['catwalk'])) : ?>
                <?php foreach ($list['catwalk'] as $item) : ?> 
            
                    <div class="col col-md-3">
                        <div class="col_content">
                            <div class="video_youtube-inner" data-video="<?= $item['id'] ?>">
                                <?php if ($item['type'] == 'vimeo') : ?>
                                    <iframe src="https://player.vimeo.com/video/<?= $item['id'] ?>"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <?php else : ?>
                                    <iframe  src="https://www.youtube.com/embed/<?= $item['id'] ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                                <?php endif; ?>
                                <div class="popup_click"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?> 
            <?php endif; ?>
            <?php if (isset($list['showreel'])) : ?>
                <?php foreach ($list['showreel'] as $item) : ?> 
            
                    <div class="col col-md-3">
                        <div class="col_content">
                            <div class="video_youtube-inner" data-video="<?= $item['id'] ?>">
                                <?php if ($item['type'] == 'vimeo') : ?>
                                    <iframe src="https://player.vimeo.com/video/<?= $item['id'] ?>"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                <?php else : ?>
                                    <iframe  src="https://www.youtube.com/embed/<?= $item['id'] ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                                <?php endif; ?>
                                <div class="popup_click"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?> 
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="modals_wrap">
    <div id="castingModal" class="casting_modal modal fade">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Close</button>
                <div class="form_title">Send profile to user</div>
            </div>
            <div class="modal-content">
                <?= $this->render('@app/views/blocks/modal-email-profile', ['model' => new app\models\Email(['scenario' => 'profile-send']), 'id' => $model['id']]) ?>
            </div>
        </div>
    </div>
</div>
