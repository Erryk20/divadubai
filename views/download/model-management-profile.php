<?php

use yii\widgets\Breadcrumbs;
use kartik\helpers\Html;
use app\models\UserInfo;

$this->title = "Model Management";
//$this->params['breadcrumbs'][] = "{$model['short']}.*{$model['id']}";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => '/model-management'];

$this->registerCssFile('/css/photobox.css', ['depends' => [\yii\bootstrap\BootstrapAsset::className()]]);
$this->registerJsFile('/js/jquery.photobox.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

<div class="top_inner">
    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]); ?>
    <div class="page_arrows_wrap clearfix">
            <?php if ($nextPrev['prev_id']) : ?>
                <div class="page_arr prev_arr">
                    <?= Html::a("Prev", [
                        "/site/model-management-profile",
                        'gender' => $nextPrev['gender'],
                        'id' => $nextPrev['prev_id']
                    ])
                    ?>
                </div>
            <?php endif; ?>

            <?php if ($nextPrev['next_id']) : ?>
                <div class="page_arr next_arr">
                    <?= Html::a("Next", [
                        "/site/model-management-profile",
                        'gender' => $nextPrev['gender'],
                        'id' => $nextPrev['next_id']
                    ])
                    ?>
                </div>
            <?php endif; ?>
    </div>
    <h1 class="page_title"><?= "{$model['short']}.*{$model['id']}" ?></h1>
</div>
<div class="node_model clearfix">
    <?= $this->render('@app/views/blocks/profile-image', ['list'=>$list]); ?>
    <table class="model_info clearfix">
        <?= $this->render('@app/views/blocks/model-info', ['model'=>$model]); ?>
    </table>
    <div class="action_wrap">
        <?= $this->render('@app/views/blocks/profile-bottom', ['model'=>$model, 'logo'=>$list['logo']] ) ?>
    </div>
    
    <?php if(isset($list['all'])) : ?>
        <div class="portfolio_slider model_slider model_slider_default">
            <div class="title_wrapper clearfix">
                <div class="block_title">
                    <h2 class="title">Portfolio</h2>
                    <div class="slider_arrows">
                        <div class="slide_arr slide_prev">Prev</div>
                        <div class="slide_arr slide_next">Next</div>
                    </div>
                </div>
                <!--<a href="#" class="view_all">View Fullbook</a>-->
            </div>
            <div class="block_content">
                <?php foreach ($list['all'] as $item) : ?>
                    <div class="col">
                        <a class="photobox" href="<?= $item ?>">
                            <?= $this->render('@app/views/blocks/slider-image', ['value'=> $item, 'height' => 360, 'width'=> 325] ) ?>
                        </a>
                    </div>
                
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if(isset($list['polaroid'])) : ?>
        <div class="polaroids_slider model_slider model_slider_default">
            <div class="title_wrapper clearfix">
                <div class="block_title">
                    <h2 class="title">Polaroids</h2>
                    <div class="slider_arrows">
                        <div class="slide_arr slide_prev">Prev</div>
                        <div class="slide_arr slide_next">Next</div>
                    </div>
                </div>
                <!--<a href="#" class="view_all">View Fullbook</a>-->
            </div>
            <div class="block_content">
                 <?php foreach ($list['polaroid'] as $item) : ?>
                    <div class="col">
                        <a class="photobox" href="<?= $item ?>">
                            <?= $this->render('@app/views/blocks/slider-image', ['value'=> $item, 'height' => 360, 'width'=> 325] ) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php if(isset($list['showreel'])) : ?>
        <div class="showreel_slider model_slider2 model_slider_default">
            <div class="title_wrapper clearfix">
                <div class="block_title">
                    <h2 class="title">Showreel</h2>
                    <div class="slider_arrows">
                        <div class="slide_arr slide_prev">Prev</div>
                        <div class="slide_arr slide_next">Next</div>
                    </div>
                </div>
            </div>
            <div class="block_content">
                <?= $this->render('@app/views/blocks/slider-video', ['list'=> $list['showreel']] ) ?>
            </div>
        </div>
    <?php endif; ?>
<!--    <div class="showreel_slider model_slider2 model_slider_default">
        <div class="title_wrapper clearfix">
            <div class="block_title">
                <h2 class="title">Casting</h2>
                <div class="slider_arrows">
                    <div class="slide_arr slide_prev">Prev</div>
                    <div class="slide_arr slide_next">Next</div>
                </div>
            </div>
        </div>
        <div class="block_content">
            <div class="row">
                <div class="col col-md-4"><img src="/images/model_slide_9.jpg" alt=""></div>
                <div class="col col-md-4"><img src="/images/model_slide_10.jpg" alt=""></div>
                <div class="col col-md-4"><img src="/images/model_slide_11.jpg" alt=""></div>
                <div class="col col-md-4"><img src="/images/model_slide_12.jpg" alt=""></div>
            </div>
        </div>
    </div>-->
    <?php if(isset($list['catwalk'])) : ?>
        <div class="showreel_slider model_slider2 model_slider_default">
            <div class="title_wrapper clearfix">
                <div class="block_title">
                    <h2 class="title">Catwalk</h2>
                    <div class="slider_arrows">
                        <div class="slide_arr slide_prev">Prev</div>
                        <div class="slide_arr slide_next">Next</div>
                    </div>
                </div>
            </div>
            <div class="block_content">
                <?= $this->render('@app/views/blocks/slider-video', ['list'=> $list['catwalk']] ) ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<div class="modals_wrap">
    <div id="castingModal" class="casting_modal modal fade">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Close</button>
                <div class="form_title">Send profile to user</div>
            </div>
            <div class="modal-content">
                <?= $this->render('@app/views/blocks/modal-email-profile', ['model'=> new app\models\Email(['scenario'=>'profile-send']), 'id'=>$model['id']]) ?>
            </div>
        </div>
    </div>
</div>
