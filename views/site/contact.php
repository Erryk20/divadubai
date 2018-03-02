<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

$this->title = $content['title'];
$this->params['breadcrumbs'][] = 'Contacts';

?>
<div class="view_contacts clearfix">
    <div class="view_header">
        <div id="map" data-coordinate="<?= $content['coordinate'] ?>"></div>
    </div>
    <div class="view_content">
        <?php foreach ($contacts as $value) : ?>
            <div class="col col-sm-6 col-md-3">
                <div class="col_content">
                    <div class="title">
                        <?= $value['title'] ?>
                        <div class="post"><?= $value['post'] ?></div>
                    </div>
                    <div class="contact_info">
                        <?php if(!empty($value['mobile'])) : ?>
                            <div class="contact_label">Mobile:</div>
                            <div class="contact_val">
                                <?php 
                                $count = count($value['mobile']);
                                foreach ($value['mobile'] as $key => $mobile) : ?>
                                <a href="tel:<?= $mobile ?>"><?= $mobile ?></a> 
                                    <?= $count > ($key+1) ? '/' : null ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                            
                        <?php if(!empty($value['email'])) : ?>
                            <div class="contact_label">Email:</div>
                            <div class="contact_val">
                                <?php foreach ($value['email'] as $email) : ?>
                                    <a href="mailto:<?= $email ?>"><?= $email ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                                
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>