<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use app\models\Language;
use app\common\models\User;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'published')->checkbox() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'introduction')->checkbox() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'language')->dropDownList(Language::getLanguageShort(), ['options' =>[Yii::$app->language=>['Selected'=>true]],  'prompt'=>'Select language']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'user_id')->dropDownList(User::getUsersIdAll(), ['prompt'=>'Select username']) ?>
        </div>
    </div>
    
    
    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'multiple'=> false
        ],
        'pluginOptions' => [
            'initialPreview'=>[
                $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/posts/{$model->img}"), 'width' => 200, 'height' => 200]),
            ],
            'previewFileType' => 'image',
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>true,
            'showPreview' => !$model->isNewRecord,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'fileActionSettings'=>[
                'showDrag'=>false,
                'showDelete'=>false,
                'showZoom'=>false,
            ]
        ]
    ]) ?>
    <?= $form->field($model, 'img')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'full',
                'clientOptions' => [
                    'language' => Yii::$app->language,
                    'allowedContent' => true,
                    'tabindex' => false,
                    'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
                ],
            ])
        ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
