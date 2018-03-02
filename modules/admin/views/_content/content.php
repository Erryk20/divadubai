<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use app\models\Categories;
use dosamigos\ckeditor\CKEditor;
use kartik\editable\Editable;
use dosamigos\ckeditor\CKEditorInline;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="categories-form">
    
    
    

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($top); ?>
    <?= $form->field($top, 'top')->widget(CKEditor::className(), [
                'options' => [
                    'rows' => 3,
                    'id'=>'top-content',
                ],
                'preset' => 'basic',
                'clientOptions' => [
                    'allowedContent' => true,
                    'tabindex' => false,
                    'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
                ],
            ])->label('Top Content')
        ?>
    
    <?= $form->errorSummary($blockquote); ?>
    <?= $form->field($blockquote, 'blockquote')->textarea()->label('Quote');?>
    
    <?= $form->errorSummary($description); ?>
    <?= $form->field($description, 'description')->widget(CKEditor::className(), [
                'options' => [
                    'rows' => 3,
                    'id'=>'description-content',
                ],
                'preset' => 'basic',
                'clientOptions' => [
                    'allowedContent' => true,
                    'tabindex' => false,
                    'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
                ],
            ])->label('Description')
        ?>
    
    <?php if (!Yii::$app->request->isAjax){ ?>
          <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>
