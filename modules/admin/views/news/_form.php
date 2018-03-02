<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;
use dosamigos\ckeditor\CKEditor;
use kartik\file\FileInput;
use app\models\NewsCategories;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'published')->checkbox() ?>

        <?= $form->field($model, 'language')->dropDownList(
            Language::getLanguageShort(), 
            [
                'options' => [Yii::$app->language => ['Selected'=>true]],  
                'prompt'=>'Select language',
            ]) ?>

        <?= $form->field($model, 'category_id')->dropDownList(
             NewsCategories::getCategories($model->language ? $model->language : Yii::$app->language ), 
            ['prompt'=>'Select category']
        ) ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'file')->widget(FileInput::className(), [
            'options' => [
                'accept' => 'image/*',
                'multiple'=> false
            ],
            'pluginOptions' => [
                'initialPreview'=>[
                    $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$model->img}"), 'width' => 200, 'height' => 200]),
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