<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use kartik\sortable\Sortable;
use app\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin(); ?>

        <?php // = $form->field($model, 'parent_id')->textInput() ?>


        <?= $form->field($model, 'published')->checkbox() ?>
        <?= $form->field($model, 'main')->checkbox() ?>


        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <?= $form->field($model, 'language')->dropDownList(
                    \app\models\Language::getLanguageShort(), 
                    [
                        'options' => [Yii::$app->language => ['Selected'=>true]],  
                        'prompt'=>'Select language',
                    ]) ?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        
        <?= $form->field($model, 'content')->widget(CKEditor::className(), [
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