<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;

use budyaga\cropper\Widget;


/* @var $this yii\web\View */
/* @var $model backend\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="slider-form">
    <?php $form = ActiveForm::begin([
        'options'=>['enctype'=>"multipart/form-data"]
    ]); ?>
    
    <?= $form->field($model, 'published')->checkbox() ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>


    <?php echo $form->field($model, 'file')->widget(Widget::className(), [
        'uploadUrl' => Url::toRoute('/admin/slider/upload-photo'),
        'width'=> 1920,
        'height'=> 700,
    ]) ?>
    
    <?php 
//    = $form->field($model, 'file')->widget(FileInput::className(), [
//        'options' => [
//            'accept' => 'image/*',
//            'multiple'=> false
//        ],
//        'pluginOptions' => [
//            'initialPreview'=>[
//                $model->isNewRecord ? null : $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/slider/{$model->img}"), 'width' => 200, 'height' => 200]),
//            ],
//            'previewFileType' => 'image',
//            'initialPreviewAsData'=>true,
//            'overwriteInitial'=>true,
//            'showPreview' => !$model->isNewRecord,
//            'showCaption' => true,
//            'showRemove' => false,
//            'showUpload' => false,
//            'fileActionSettings'=>[
//                'showDrag'=>false,
//                'showDelete'=>false,
//                'showZoom'=>false,
//            ]
//        ]
//    ]) ?>

    
    <?php
//    = $form->field($model, 'text')->widget(CKEditor::className(), [
//            'options' => ['rows' => 3],
//            'preset' => 'full',
//            'clientOptions' => [
//                'language' => Yii::$app->language,
//                'allowedContent' => true,
//                'tabindex' => false,
//                'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
//            ],
//        ])
    ?>
    
    
    <?= $form->field($model, 'img')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'select_img')->hiddenInput()->label(false) ?>
    
    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
