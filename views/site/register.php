<?php

use kartik\form\ActiveForm;
use app\models\UserInfo;
use app\models\User;
use app\models\Countries;
use yii\web\View;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(
        '/js/jquery.validate.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
        '/js/additional-methods.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);

$this->registerJsFile(
        '/js/datepicker.js', ['depends' => [app\assets\JqueryAsset::className()]]
);

//$this->registerJsFile(
//        '/js/imagesloaded.pkgd.min.js', 
//        ['depends' => [\yii\web\JqueryAsset::className()]]
//);
//$this->registerJsFile(
//        '/js/masonry.pkgd.min.js', 
//        ['depends' => [\yii\web\JqueryAsset::className()]]
//);

$this->registerJsFile(
        '/js/cropper.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);
$this->registerJsFile(
        'https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]
);


$this->registerCssFile('/css/cropper.min.css', [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);

$this->registerCssFile('/css/datepicker.min.css', [
    'depends' => [\yii\bootstrap\BootstrapAsset::className()],
]);


//    Photographers, Locations
//if(in_array($category_id, ['17', '19', '11', '1', '20', '15'])){
if(in_array($category_id, ['11', '17'])){
    $orientation = json_encode(['horizontal'=>true, 'vertical'=>true]);
}else{
    //портрет
    $orientation = json_encode(['horizontal'=>false, 'vertical'=>true]);
}

$this->registerJs("var orientation = {$orientation};", \yii\web\View::POS_END);

//orientation

//$category = app\models\DivaMedia::getBooksId(1);
//unset($category[0])
?>



<div class="register_wrap">
    <?php
    $form = ActiveForm::begin([
                'options' => ['enctype'=>'multipart/form-data'],
                'id' => 'form-registration',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['showErrors' => true],
    ]);
    ?>
<div class="form_wrap">
        <div class="form_title">Personal info</div>
        <?php echo $info->getErrors() ? $form->errorSummary($info) : null; ?>
        <?php echo $user->getErrors() ? $form->errorSummary($user) : null; ?>
        <?php // echo $userMedia->getErrors() ? $form->errorSummary($userMedia) : null; ?>

        <?php // = $form->field($info, 'user_id')->hiddenInput()->label(false) ?>

        <div class="form_content">
            <?php
            
            if($info['isAdmin']){
                echo "<div class='admin-dev'>";
                
                echo $form->field($info, 'availability')->radioButtonGroup(User::getAvailability(), [
                    'itemOptions'=>[
                        'labelOptions'=>[
                            'class' => 'btn btn-default'
                        ],
                    ]
                ]);
                
                echo Html::a(
                        "<i class='fa fa-envelope-o' aria-hidden='true'></i>", 
                        null, 
                        [
                            'data-toggle'=>"modal",
                            'data-target'=>"#email-send-profile",
                            'class'=>"btn btn-default send-email-profile",
                            'title'=>'Send Email',
                            
                        ]
                    );
                echo "</div>";
            };
            
            if(in_array('categorySlug', $fields) || $info['isAdmin']){
                echo ($info->isNewRecord || $info['isAdmin']) ? $form->field($info, 'categorySlug', [
                    'template' => "<label class='main_label col-md-2'>" .
                    $info->getAttributeLabel('type') .
                    "</label>" .
                    "<div class='field col-sm-9 col-md-10'>" .
                    "{input}" .
                    "</div>" .
                    "{error}",
                    'options' => ['class' => 'form-group field_select clearfix'],
                    'horizontalCssClasses' => ['label' => 'main_label']
                ])->dropDownList($category) : null;
            }
            ?>

            <?php if ($info['user_id'] == '') : ?>
                <div class="form-group clearfix">
                    <label class="main_label col-md-2"><?= $user->getAttributeLabel('username') ?> *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $user, 'username', ['required' => true, 'class' => 'form_text form-control']) ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($info['user_id'] == '') : ?>
                <div class="form-group field_name clearfix">
                    <label class="main_label col-md-2"><?= $user->getAttributeLabel('password') ?> *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('password', $user, 'password', ['required' => true, 'id'=>"password", 'class' => 'form_text form-control', 'placeholder' => $user->getAttributeLabel('password')]) ?>
                        <?= Html::activeInput('password', $user, '_password', ['required' => true, 'id'=>"password_again", 'class' => 'form_text form-control', 'placeholder' => $user->getAttributeLabel('_password')]) ?>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if(in_array('location_name', $fields) || in_array('full_name', $fields) || in_array('name', $fields) || in_array('last_name', $fields)): ?>
                <div class="form-group field_name clearfix">
                    <label class="main_label col-md-2">Name *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?php 
                            if(in_array('location_name', $fields)){
                                echo Html::activeInput('text', $info, 'name', ['required' => true, 'class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('location_name')]);
                            }
                            
                            if(in_array('full_name', $fields)){
                                echo Html::activeInput('text', $info, 'name', ['required' => true, 'class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('full_name')]);
                            }
                            
                            if(in_array('name', $fields)){
                                echo Html::activeInput('text', $info, 'name', ['required' => true, 'class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('name')]);
                            }
                        ?>
                        <?php 
                            if(in_array('last_name', $fields)){
                                echo Html::activeInput('text', $info, 'last_name', ['required' => true, 'class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('last_name')]);
                            }
                        ?>
                    </div>
                </div>
            <?php endif; ?>

                <?php if(in_array('gender', $fields)): ?>
                    <?php if(in_array('city', $fields)): ?>
                        <?= $form->field($info, 'city', [
                            'template' => "<label class='main_label col-md-2'>{$info->getAttributeLabel('gender')} *</label>{input}{error}",
                            'options' => ['class' => 'form-group clearfix'],
                        ])->checkboxList(UserInfo::itemGenderFromCategory($category_id), [
                            'class'=>"field col-sm-9 col-md-10 form_checkboxes"
                        ]);  ?> 
                <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('birth', $fields)): ?>
                <div class="form-group field_birth clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('birth') ?> *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $info, 'birth', ['required' => true, 'class' => 'form_text form-control', 'placeholder' => 'mm/dd/yy']) ?>
                    </div>
                </div>
            <?php endif; ?>


            <?php if(in_array('phone', $fields)): ?>
                <div class="form-group field-userinfo-phone required">
                    <label class="main_label col-md-2" for="userinfo-phone"><?= $info->getAttributeLabel('phone') ?> *</label>
                    <div class="input-group field col-md-10">
                        <span class="input-group-btn">
                            <div class="form-group field-userinfo-prepend_phone required">
                                <label class="control-label" for="userinfo-prepend_phone"><?= $info->getAttributeLabel('phone') ?></label>
                                <?= Html::activeDropDownList($info, 'prepend_phone', Countries::getPrependPhones(), ['class' => 'form-control']) ?>
                                <div class="help-block"></div>
                            </div>
                        </span>
                        <?= Html::activeInput('tel', $info, 'phone', ['required' => true, 'maxlength'=>'14', 'class' => 'form-control form_text', 'placeholder' => $info->getAttributeLabel('phone')]) ?>
                    </div>
                    <div class="help-block"></div>
                </div>
            <?php endif; ?>
            
            
            <?php if(in_array('phone2', $fields)): ?>
                <div class="form-group field-userinfo-phone">
                        <?= $form->field($info, 'phone2', [
                            'template' => "<label class=\"main_label col-md-2\" for=\"userinfo-phone\">" .
                            $info->getAttributeLabel('phone2') .
                            "</label>" .
                            "<div class='input-group field col-md-10'>" .
                                "<span class='input-group-btn'>".
                                    "<div class='form-group field-userinfo-prepend_phone required'>".
                                        Html::activeDropDownList($info, 'prepend_phone2', Countries::getPrependPhones(), ['class' => 'form-control']).
                                        "<div class='help-block'></div>".
                                    "</div>".
                                "</span>".
                                "{input}" .
                            "</div>", 
                            'options' => ['class' => 'form-group field_select clearfix'],
                        ])->input('tel', ['maxlength'=>'14', 'class' => 'form-control form_text'])
                            
                            
                        ?>
                </div>
                <div class="help-block"></div>
            <?php endif; ?>

            <?php // if (in_array('email', $fields) && $info['user_id'] == '') : ?>
                <div class="form-group clearfix">
                    <label class="main_label col-md-2"><?= $user->getAttributeLabel('email') ?> *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('email', $info, 'email', ['required' => true, 'class' => 'form_text form-control', 'placeholder' => $user->getAttributeLabel('email')]) ?>
                    </div>
                </div>
            <?php // endif; ?>
            
            <?php if(in_array('address', $fields)): ?>
                <div class="form-group field_address clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('address') ?> *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $info, 'address', ['required' => true, 'class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('address')]) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('nationality', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('nationality') ?> *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'nationality', Countries::getNationalities(), ['required' => true, 'class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('country', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('country') ?> *</label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'country', Countries::getCountries(), ['required' => true, 'class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(in_array('city', $fields)): ?>
                    <?= $form->field($info, 'city', [
                        'template' => "<label class='main_label col-md-2'>{$info->getAttributeLabel('city')} *</label>{input}{error}",
                        'options' => ['class' => 'form-group clearfix'],
                    ])->checkboxList(UserInfo::itemAlias('city'), [
                        'class'=>"field col-sm-9 col-md-10 form_checkboxes"
                    ]);  ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="form_wrap">
        <div class="form_title">Basic specifications</div>
        <div class="form_content">
            <?php if(in_array('bio', $fields)): ?>
                <div class="form-group field_address clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('bio') ?> *</label>
                    <div class="field col-sm-9">
                        <?= $form->field($info, 'bio', ['options'=>['style'=>'margin-left: -15px;']])->textarea(['rows'=>"4"])->label(false);?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('facebook', $fields)): ?>
                <div class="form-group field_address clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('facebook') ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $info, 'facebook', ['class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('facebook')]) ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(in_array('twitter', $fields)): ?>
                <div class="form-group field_address clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('twitter') ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $info, 'twitter', ['class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('twitter')]) ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(in_array('instagram', $fields)): ?>
                <div class="form-group field_address clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('instagram') ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $info, 'instagram', ['class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('instagram')]) ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(in_array('youtube', $fields)): ?>
                <div class="form-group field_address clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('youtube') ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $info, 'youtube', ['class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('youtube')]) ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if(in_array('snapchat', $fields)): ?>
                <div class="form-group field_address clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('snapchat') ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeInput('text', $info, 'snapchat', ['class' => 'form_text form-control', 'placeholder' => $info->getAttributeLabel('snapchat')]) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('ethnicity', $fields)): ?>
                <?= $form->field($info, 'ethnicity', [
                    'template' => "<label class='main_label col-md-2'>{$info->getAttributeLabel('ethnicity')} *</label>{input}{error}",
                    'options' => ['class' => 'form-group clearfix'],
                ])->checkboxList(UserInfo::itemAlias('ethnicity'), [
                    'class'=>"field col-sm-9 col-md-10 form_checkboxes"
                ]);  ?> 
            <?php endif; ?>
            
            <?php if(in_array('height', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('height') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'height', UserInfo::itemAlias('height'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('weight', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('weight') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'weight', UserInfo::itemAlias('weight'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('collar', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('collar') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'collar', UserInfo::itemAlias('collar'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('chest', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('chest') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'chest', UserInfo::itemAlias('chest'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('waist', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('waist') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'waist', UserInfo::itemAlias('chest'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('hips', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('hips') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'hips', UserInfo::itemAlias('chest'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('shoe', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('shoe') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'shoe', UserInfo::itemAlias('shoe'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('suit', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('suit') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'suit', UserInfo::itemAlias('suit'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('pant', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('pant') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'pant', UserInfo::itemAlias('suit'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('hair', $fields)): ?>
                <?= $form->field($info, 'hair', [
                    'template' => "<label class='main_label col-md-2'>{$info->getAttributeLabel('hair')} *</label>{input}{error}",
                    'options' => ['class' => 'form-group clearfix'],
                ])->checkboxList(UserInfo::itemAlias('hair'), [
                    'class'=>"field col-sm-9 col-md-10 form_checkboxes"
                ]);  ?> 
            <?php endif; ?>
            
            <?php if(in_array('hair_length', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('hair_length') ?>, <sub>cms</sub></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'hair_length', UserInfo::itemAlias('hair_length'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('eye', $fields)): ?>
                <?= $form->field($info, 'eye', [
                    'template' => "<label class='main_label col-md-2'>{$info->getAttributeLabel('eye')} *</label>{input}{error}",
                    'options' => ['class' => 'form-group clearfix'],
                ])->checkboxList(UserInfo::itemAlias('eye'), [
                    'class'=>"field col-sm-9 col-md-10 form_checkboxes"
                ]);  ?> 
            <?php endif; ?>
            
            <?php if(in_array('language', $fields)): ?>
                <div class="form-group clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('language') ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <div class="form_checkboxes">
                            <?=
                            Html::activeCheckboxList($info, 'language', UserInfo::itemAlias('language'), [
                                'item' => function($index, $label, $name, $checked, $value) {
                                    $checkedLabel = $checked ? 'checked' : '';
                                    $inputId = str_replace(['[', ']'], ['', ''], $name) . '_' . $index;

                                    return "<div class = 'form_checkbox'><input type='checkbox' name=$name value=$value id=$inputId $checkedLabel>"
                                            . "<label for=$inputId>$label</label></div>";
                                }
                            ])
                            ?>
                        </div>
                        <?= Html::input('text', 'UserInfo[language][]', $info['language_other'], ['class' => 'form-control form_text', 'placeholder' => 'Other']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(in_array('visa_status', $fields)): ?>
                <div class="form-group field_select clearfix">
                    <label class="main_label col-md-2"><?= $info->getAttributeLabel('visa_status') ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <?= Html::activeDropDownList($info, 'visa_status', UserInfo::itemAlias('visa_status'), ['class' => 'form-control', 'prompt' => 'Select...']) ?>
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    
    <?php if(in_array('subcategory', $fields) || in_array('specialization', $fields)): ?>
        <div class="form_wrap">
            <div class="form_title">Specific Info</div>
            <div class="form_content">
                
                <?php if(in_array('specialization', $fields)): ?>
                    <div class="form-group clearfix">
                        <label class="main_label col-md-2"><?= $info->getAttributeLabel('specialization') ?></label>
                        <div class="field col-sm-9 col-md-10">
                            <div class="form_checkboxes">
                                <?=
                                Html::activeCheckboxList($info, 'specialization', UserInfo::itemAlias('specialization'), [
                                    'item' => function($index, $label, $name, $checked, $value) {
                                        $checkedLabel = $checked ? 'checked' : '';

                                        $inputId = str_replace(['[', ']'], ['', ''], $name) . '_' . $index;

                                        return "<div class = 'form_checkbox'><input type='checkbox' name=$name value=$value id=$inputId $checkedLabel>"
                                                . "<label for=$inputId>$label</label></div>";
                                    }
                                ])
                                ?>
                            </div>
                        </div>
                    </div>	
                <?php endif; ?>

                <?php if($info['isAdmin'] && in_array('subcategory', $fields)) : ?>
                    <?php foreach ($subcategory as $key => $sub) : ?>
                        <div class="form-group clearfix">
                            <label class="main_label main_label_check"><?= $key ?></label>
                            <div class="field col-sm-9 col-md-10">
                                <div class="form_checkboxes">
                                    <div class="userinfo-subcategory">
                                        <?php foreach ($sub as $key => $value) : ?>
                                            <div class="form_checkbox col-sm-3">
                                                <?php 
                                                    if(in_array($key, array_keys($userSubcat))){
                                                        echo "<input type='checkbox' checked='checked' name='UserSubcategory[subcategory_id][{$key}]' id='{$key}'>";
                                                    }else{
                                                        echo "<input type='checkbox' name='UserSubcategory[subcategory_id][{$key}]' id='{$key}'>";
                                                    }
//                                                    if($filter['ethnicity']){
//                                                    }else{
//                                                        echo "<input type='checkbox' name='FilterForm[ethnicity][{$key}]' id='{$key}'>";
//                                                    }
                                                    echo "<label for='{$key}'>{$value}</label>";
                                                ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>                        
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="form_wrap">
        <div class="form_title">Upload portfolio</div>
        <div class="form_content clearfix" id="group_parent">
            <div class="row">
                <div class="col-md-6 col-lg-5 col">
                    <?php 
                        $countImg = count($medias['image']);
                        $rows = ($countImg > 10) ? $countImg : 10;
                    ?>
                    <?php for ($i = 1; $i<= $rows; $i++) : ?>
                        <div class="form-group photo_upload base_field">
                            <label class="main_label col-sm-4">Image <?= $i ?> *</label>
                            <div class="fl_upld field">
                                <div class="field_text"><?= isset($medias['image'][$i]) ? $medias['image'][$i]['src'] : null ?></div>
                                <label for="file_<?= $i ?>">
                                    Select
                                </label>
                                <?php if(isset($medias['image'][$i])) : ?>
                                    <input type="file"  name="UserMedia[src][image][<?= $i ?>]" id="file_<?= $i ?>"  class="form-control"  data-name="file_<?= $i ?>" onchange="previewFile(this)" accept="image/*">
                                    <input type="hidden" class="image-name" value="<?= $medias['image'][$i]['src'] ?>"  name="UserMedia[src][image][<?= $medias['image'][$i]['id'] ?>][]">
                                    <input type="hidden" value="<?= $medias['image'][$i]['id'] ?>"  name="UserMedia[id][image][<?= $i ?>]">
                                <?php else : ?>
                                    <input required="required" type="file" class="form-control" id="file_<?= $i ?>" name="UserMedia[src][image][<?= $i ?>]" data-name="file_<?= $i ?>" onchange="previewFile(this)" accept="image/*">
                                    <input type="hidden" class="image-name" name="UserMedia[src][image][<?= $i ?>]">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <div class="add_image">Add image</div>
                </div>
                
                
                <div class="col-lg-offset-1 col-md-6 images_wrap">
                    <div class="row">
                        <div class="col-sm-6 main_image">
                            <div class="big_image" data-name="file_1">
                                <?php 
                                    if(isset($medias['image'][1])){
                                        echo "<img src='/images/user-media/{$medias['image'][1]['src']}'>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="image_group col-sm-6">
                            <?php for ($i = 2; $i<=10; $i++) : ?>
                                <div class="col-sm-4 image_col">
                                    <div class="image" data-name="file_<?= $i ?>">
                                        <?php 
                                            if(isset($medias['image'][$i])){
                                                echo "<img src='/images/user-media/{$medias['image'][$i]['src']}'>";
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="crop_popup">
                        <div class="crop_content">
                            <div class="close_icon">Close</div>
                            <div class="image_crop"></div>
                            <div class="crop_wrap">
                                <button id="crop" class="btn btn-default">Crop</button>
                            </div>
                        </div>											
                    </div>
                </div>
            </div>
        </div>
        
       <?php if(!in_array($category_id, ['18', '19', '15', '20', '12', '11', '17'])) : ?>
           <?php if( in_array('polaroid', $fields)) : ?>
                <div class="form_title form_title_upload">Polaroid</div>
                <div class="row">
                    <div class="col-md-6 col-lg-5 col">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <div class="form-group photo_upload polaroid_upload">
                                    <label class="main_label col-sm-4">Image <?= $i ?></label>
                                    <div class="fl_upld field">
                                        <div class="field_text">
                                            <?= isset($medias['polaroid'][$i]) ? $medias['polaroid'][$i]['src'] : null ?>
                                        </div>
                                        <label>
                                            <input class="form-control" type="file" name="UserMedia[src][polaroid][<?= $i ?>]" accept="image/*">

                                            <?php if(isset($medias['polaroid'][$i])) : ?>
                                                <input type="hidden" class="image-name" name="UserMedia[src][polaroid][<?= $medias['polaroid'][$i]['id'] ?>][<?= $i ?>]" value="<?= $medias['polaroid'][$i]['src'] ?>">
                                                <!--<input type="hidden" value="<?php // = $medias['polaroid'][$i]['id'] ?>"  name="UserMedia[id][polaroid][<?= $i ?>]">-->
                                            <?php else : ?>
                                                <input type="hidden" class="image-name" name="UserMedia[src][polaroid][<?= $i ?>]">
                                            <?php endif; ?>
                                            Select
                                        </label>
                                    </div>
                                </div>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(in_array('catwalk', $fields)) : ?>
                <div class="form_title form_title_upload">Catwalk</div>
                <div class="row">
                    <div class="col-md-6 col-lg-5 col">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <div class="form-group video_upload">
                                <label class="main_label col-sm-4">Video <?= $i ?></label>
                                <div class="field">
                                    <?php if(isset($medias['catwalk'][$i])) : ?>
                                        <input type="text"   value="<?= $medias['catwalk'][$i]['src'] ?>" name="UserMedia[src][catwalk][<?= $medias['catwalk'][$i]['id'] ?>][]" id="field_<?= $i ?>" class="form-control form_text">
                                        <!--<input type="hidden" value="<?= $medias['catwalk'][$i]['id'] ?>"  name="UserMedia[id][catwalk][<?= $i ?>]">-->
                                    <?php else : ?>
                                        <input type="text" id="field_<?= $i ?>" class="form-control form_text" name="UserMedia[src][catwalk][<?= $i ?>]">
                                    <?php endif; ?>
                                    <div class="field_suffix">Add link</div>
                                </div>
                            </div>
                        <?php endfor; ?>
                        <div class="description col-sm-offset-4">You can add only youtube/ vimeo video</div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="form_title form_title_upload">Showreel</div>
        <div class="row showreel_row">
            <div class="col-md-6 col-lg-5 col">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <div class="form-group video_upload">
                        <label class="main_label col-sm-4">Video <?= $i ?></label>
                        <div class="field">
                            <?php if(isset($medias['showreel'][$i])) : ?>
                                <input type="text" value="<?= $medias['showreel'][$i]['src'] ?>" name="UserMedia[src][showreel][<?= $medias['showreel'][$i]['id']?>][]" class="form-control form_text">
                                <!--<input type="hidden" value="<?= $medias['showreel'][$i]['id']?>" name="UserMedia[id][showreel][<?= $i ?>]">-->
                            <?php else : ?>
                                <input type="text" class="form-control form_text" name="UserMedia[src][showreel][<?= $i ?>]">
                            <?php endif; ?>
                            
                            <div class="field_suffix">Add link</div>
                        </div>
                    </div>
                <?php endfor; ?>
                <div class="description col-sm-offset-4">You can add only youtube/ vimeo video</div>
            </div>
        </div>
        
        <?php if($info['isAdmin']) :?>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?= $form->field($info, 'booker_name')->textInput() ?>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?= $form->field($info, 'date')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <?= $form->field($info, 'remark')->textarea() ?>
            </div>
        <?php endif; ?> 
    </div>
    <div class="form_actions clearfix">
        <input type="submit" class="btn btn-default" value="<?= $info->isNewRecord ? 'Add talent' : 'Change' ?>">
        <div class="description">Note: If you have regsitration issues email at contact@divadubai.com</div>
    </div>
    <!-- </div> -->
    <?php ActiveForm::end(); ?>
</div>


<?php if($info['isAdmin']) :?>
    <div class="modal fade" id="email-send-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-width: 100%;">
                <div class="modal-body">
                    <?= $this->render('@app/modules/admin/views/email/send-profile', ['model'=> new app\models\Email(), 'id'=>isset($info['id']) ? $info['id'] : null  ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!--UserMedia[src][image][1]-->
<!--UserMedia[src][polaroid][1]-->
<!--UserMedia[src][catwalk][1]-->
<!--UserMedia[src][showreel][2]-->