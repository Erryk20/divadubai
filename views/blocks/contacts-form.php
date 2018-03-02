<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use himiklab\yii2\recaptcha\ReCaptcha;

use yii\widgets\Pjax;

$model = Yii::$app->controller->model;

//print_r($model);
//die();
?>

<div class="contacts_form">
    <div class="block_content container">
        <!-- <div class="row"> -->
        <div class="col col-sm-6 title_wrapper">
            <div class="title">
                Contact Us
            </div>
            <div class="decription">
                Send all your questions and wishes
                by filling out the form
            </div>
        </div>
        <div class="col col-sm-6">
            <div class="form_wrapper">
                <?php Pjax::begin(); ?>
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                        <?= $form->errorSummary($model) ?>
                        <?= $form->field($model, 'name')->textInput(['placeholder'=>"Name"])->label(false); ?>

                        <?= $form->field($model, 'email')->textInput(['placeholder'=>"Email"])->label(false); ?>

                        <?= $form->field($model, 'phone')->textInput(['type'=>'tel', 'placeholder'=>"Phone Number"])->label(false); ?>

                        <?= $form->field($model, 'message')->textarea(['placeholder'=>"Message"])->label(false); ?>

                        <div class="form_actions clearfix">
                            <?= $form->field($model, 'reCaptcha', ['enableAjaxValidation' => true])->widget(ReCaptcha::className(),['theme'=> 'dark'])->label(false) ?>
                            <?= Html::submitButton('Send', ['class' =>'btn btn-success',  'name' => 'contact-button' ]) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>