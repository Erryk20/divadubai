<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use himiklab\yii2\recaptcha\ReCaptcha;

$this->title = $content['title'];
$this->params['breadcrumbs'][] = ['label' => 'Book', 'url' => ['/site/book', 'action'=>$content['url']]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="book_form_wrapper">
    <?php $form = ActiveForm::begin([
        'id' => 'book_form_tvc',
        'options'=>[
            'class'=>"book_form"
        ]
    ]); ?>
    
        <div class="form_content">
            <?php foreach ($fields as $key => $value) : ?>
                <?php  if(is_integer($key)) : ?>
                    <div class="form-group clearfix">
                        <label class="main_label"><?= $value['label'] ?></label>
                        <?php if($value['label'] == 'Name') : ?>
                            <?= Html::input($value['type'], $value['id'], $user_name, [ 'required' => true, 'class' => 'form-control form_text', 'id'=>"categoryofhost", 'required'=>$value['require']]) ?>
                        <?php elseif($value['type'] == 'email') : ?>
                            <?= Html::input($value['type'], $value['id'], $email, [ 'required' => true, 'class' => 'form-control form_text', 'id'=>"categoryofhost", 'required'=>$value['require']]) ?>
                        <?php else : ?>
                            <?= Html::input($value['type'], $value['id'], $value['value'], [ 'required' => true, 'class' => 'form-control form_text', 'id'=>"categoryofhost", 'required'=>$value['require']]) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="form_description">
                <?= $content['description'] ?>
            </div>
        </div>
        <div class="form_actions">
            
            <?= $form->field($bookFields, 'reCaptcha', [
                'enableAjaxValidation' => true,
                'options'=>[
                    'class'=> 'form-group field-contactform-recaptcha',
                ]
            ])->widget(ReCaptcha::className(),['theme'=> 'light'])->label(false) ?>
            <?= Html::submitButton('Book now', ['class' => 'btn btn-default', 'name' => 'contact-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>