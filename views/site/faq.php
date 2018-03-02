<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;

$this->title = $content['title'];
$this->params['breadcrumbs'][] = 'FAQ';

?>
<div class="view_faq clearfix">
    <div class="row">
    <?php foreach ($models as $key => $items) : ?>
        <div class='col col-sm-4'>
            <?php foreach ($items as $value) : ?>
                <div class="item">
                    <h2 class="title"><?= $value['title'] ?></h2>
                    <div class="description"><?= $value['description'] ?></div>
                </div>
            <?php endforeach; ?>
            <?php if($key == 2) : ?>
                <div class="item">
                    <h3 class="main_title">Did not find the answer to your question?</h3>
                    <div class="ask_btn" data-toggle="modal" data-target="#faqModal">Ask a Question</div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
   </div>
</div>

<div class="modals_wrap">
    <div id="faqModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-header">
                <!-- <div class="close_icon">Close</div> -->
                <button type="button" class="close" data-dismiss="modal">Close</button>
                <div class="form_title">Ask a Question</div>
            </div>
            <div class="modal-content">
                
                <!--$ask-->
                <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($ask, 'email')->textInput([
                        'class'=>"form-control form_text",
                        'placeholder'=>"Email"
                    ])->label(false); ?>

                    <?= $form->field($ask, 'question')->textarea([
                        'class'=>"form-control form_textarea",
                        'placeholder'=>"Message"
                    ])->label(false); ?>
                
                    <div class="form_actions">
                        <?= $form->field($ask, 'reCaptcha')->widget(ReCaptcha::className())->label(false) ?>
                        
                        <?= Html::submitButton('Send', ['class' => 'btn btn-default']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>