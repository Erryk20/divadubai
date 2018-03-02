<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\Upload;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Videos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="videos-form">

    <?php $form = ActiveForm::begin(); ?>
        
        
        <?= $form->errorSummary($model); ?>
        
        <?= $form->field($model, 'published')->checkbox() ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
            'options' => ['rows' => 3],
            'preset' => 'full',
            'clientOptions' => [
                'allowedContent' => true,
                'tabindex' => false,
                'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
            ],
        ])
        ?>
    
        <?= $form->field($model, 'id_vimeo')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'preview')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'duration')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'stream')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'created_time')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'privacy')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'download')->hiddenInput()->label(false) ?>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
