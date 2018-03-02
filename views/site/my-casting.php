<?php

use app\models\UserInfo;
use yii\helpers\Url;
use yii\web\View;
use kartik\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use kartik\form\ActiveForm;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('/css/font-awesome.min.css', [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);
?>

<div class="view_profile">
    <div class="wrap-button">
        <?= $this->render('@app/views/blocks/profile-menu') ?>
    </div>
</div>
<div class="view_app">
    <div class="view_content">
        <?php foreach ($castings as $value) : ?>
            <div class="view_row" data-id="<?= $value['id'] ?>">
                <div class="view_header clearfix">
                    <div class="col-sm-3">
                        <div class="image">
                            <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/casting/{$value['src']}"), 'width' => 248, 'height' => 139], ['alt'=>'temp-alt']);?>
                            <div class="time <?= $value['finished'] ?>"><?= $value['left'] ?></div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="title_wrapper clearfix">
                            <div class="title">
                                <?= Html::a($value['title'], ['/site/casting', '#'=>"casting-id-{$value['id']}"]) ?>
                            </div>
                            <?php if ($delete) : ?>
                            <a data-id="<?= $value['id'] ?>" href="<?= Url::toRoute(['/ajax/favorite-casting-delete', 'id'=>$value['id']])?>" class="delete_btn">Delete</a>
                            <?php endif; ?>
                        </div>
                        <div class="description"><?= $value['details'] ?></div>
                    </div>
                </div>
                <div class="view_footer clearfix row">
                    <div class="view_footer_info col-sm-8">
                        <div class="location col-sm-4 col-md-4">
                            <div class="label_title">Location address:</div>
                            <div class="value"><?= $value['location'] ?></div>
                        </div>
                        <div class="date col-sm-4 col-md-3">
                            <div class="label_title">Casting Date:</div>
                            <div class="value"><?= date('Y-m-d', $value['casting_date']) ?></div>
                        </div>
                        <div class="number col-sm-4 col-md-3">
                            <div class="label_title">Booker's number:</div>
                            <div class="value"><a href="tel:<?= str_replace(" ","", $value['bookers_number']) ?>"><?= $value['bookers_number'] ?></a></div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="count_people"><?= $value['count'] ?> shortlisted for this role</div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>