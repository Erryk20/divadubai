<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Categories;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

     <?php // = $form->field($model, 'city_id')->widget(Select2::classname(), [
//            'initValueText' => $model->city ? $model->city->name : NULL,
//            'options' => [
//                'placeholder' => $model->getAttributeLabel('city_id'),
//                'multiple' => false
//            ],
//            'pluginOptions' => [
//                'allowClear' => false,
//                'minimumInputLength' => 2,
//                'language' => [
//                    'errorLoading' => new JsExpression("function () { return '".  Yii::t('app', 'Waiting for results...')."'; }"),
//                ],
//                'ajax' => [
//                    'url' => Url::to(["/ajax/list-city"]),
//                    'dataType' => 'json',
//                    'data' => new JsExpression('function(params) {return {q:params.term}; }'),
//                ],
//            ],
//        ])->label(false);
    ?>

    <?php // = $form->field($model, 'country_id')->widget(Select2::classname(), [
//            'initValueText' => $model->country ? $model->country->name : NULL,
//            'options' => [
//                'placeholder' => $model->getAttributeLabel('country_id'),
//                'multiple' => false
//            ],
//            'pluginOptions' => [
//                'allowClear' => false,
//                'minimumInputLength' => 2,
//                'language' => [
//                    'errorLoading' => new JsExpression("function () { return '".  Yii::t('app', 'Waiting for results...')."'; }"),
//                ],
//                'ajax' => [
//                    'url' => Url::to(["/ajax/list-country"]),
//                    'dataType' => 'json',
//                    'data' => new JsExpression('function(params) {return {q:params.term}; }'),
//                ],
//            ],
//        ])->label(false);
    ?>
    
    <?php 
//        $logo = $model->logo ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/users/{$model->logo}"), 'width' => 200, 'height' => 200]) : false;
    
    ?>
    
    <?php // = $form->field($model, 'file')->widget(FileInput::className(), [
//        'options' => [
//            'accept' => 'image/*',
//            'multiple'=> false
//        ],
//        'pluginOptions' => [
//            'showUpload' => false,
//            'browseLabel' => '',
//            'removeLabel' => '',
//            'initialPreview'=> $logo,
//            'previewFileType' => 'image',
//            'showPreview' => $model->logo,
//        ]
//    ]) ?>
    
<!--    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?php // = $form->field($model, 'role')->dropDownList(app\models\User::itemAlias('role')) ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?php // = $form->field($model, 'type')->dropDownList(app\models\UserInfo::itemAlias('type'),['prompt' => '']) ?>
        </div>
    </div>-->
    
    <?= $form->field($model, 'status')->dropDownList(app\models\User::itemAlias('status')) ?>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>


<!--    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <?php // = $form->field($model, 'category_id')->widget(Select2::classname(), [
//                'options' => ['multiple' => false, 'placeholder' => Yii::t('app', 'Select a category')],
//                'data'=> $categories,
//                'pluginOptions' => [
//                    'allowClear' => true,
//                ],
//            ])
                        
            ?>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        </div>
    </div>-->
    
    
    
    

    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
