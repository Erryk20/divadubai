<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\UserInfo;
use app\models\Countries;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\UserInfo */
/* @var $form yii\widgets\ActiveForm */

?>

<style>
    .input-group-btn .form-control {
        width: 80px;
    }
</style>

<div class="user-info-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL
    ]); ?>
    
    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'ethnicity')->checkboxButtonGroup(
                    UserInfo::itemAlias('ethnicity') 
    //                    ['disabledItems'=>[0, 6]]
                    ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'language')->checkboxButtonGroup(UserInfo::itemAlias('language')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'city')->checkboxButtonGroup(UserInfo::itemAlias('city')); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'specialization')->checkboxButtonGroup(UserInfo::itemAlias('specialization')); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?php // = $form->field($model, 'user_id')->dropDownList(app\models\User::getUsersIdAll(), ['prompt' => '']) ?>
            <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
                    'options' => [
                        'class'=>"form_text search-user",
                        'maxlength' => true, 
                        'placeholder'=> 'Search user'
                    ],
                    'changeOnReset'=> true,
                    'initValueText'=> app\models\User::getUserForId($model->user_id),
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 1,
                        'ajax' => [
                            'url' => Url::toRoute(['/ajax/search-user']),
                            'dataType' => 'json',
                        ],
                    ],
                ])
                ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'birth')->widget(DatePicker::classname(), [
                    'pluginOptions' => ['autoclose'=>true]
                ]);
            ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'visa_status')->dropDownList(UserInfo::itemAlias('visa_status'), ['prompt' => '']) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'category_id')->dropDownList(\app\models\ModelCategory::liatAll()) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'gender')->dropDownList(UserInfo::itemAlias('gender'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'nationality')->dropDownList(Countries::getNationalities(), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'country')->dropDownList(Countries::getCountries(), ['prompt' => '']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?=
            $form->field($model, 'phone', [
                'addon' => [
                    'prepend' => [
                        'content' => $form->field($model, 'prepend_phone')
                                ->dropDownList(Countries::getPrependPhones(), ['prompt' => '']),
                        'asButton' => true
                    ]
                ]
                    ]
            )->textInput(['maxlength'=>14, 'placeholder' => $model->getAttributeLabel('phone')])
            ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?=
            $form->field($model, 'phone2', [
                'addon' => [
                    'prepend' => [
                        'content' => $form->field($model, 'prepend_phone2')
                                ->dropDownList(Countries::getPrependPhones(), ['prompt' => '']),
                        'asButton' => true
                    ]
                ]
                    ]
            )->textInput(['maxlength'=>14, 'type'=>'tel', 'placeholder' => $model->getAttributeLabel('phone2')])
            ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'height', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('height'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'weight', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> kgs</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('weight'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'collar', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('collar'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'chest', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('chest'), ['prompt' => '']) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'waist', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('chest'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'hips', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('chest'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'shoe', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('shoe'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'suit', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('suit'), ['prompt' => '']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'pant', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('suit'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'hair')->dropDownList(UserInfo::itemAlias('hair'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'hair_length', [
                    'template' => '{label}<sub style="text-transform: lowercase;"> cms</sub> {input}{error}{hint}'
                ])->dropDownList(UserInfo::itemAlias('hair_length'), ['prompt' => '']) ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'eye')->dropDownList(UserInfo::itemAlias('eye'), ['prompt' => '']) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'address')->textarea() ?>


	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
