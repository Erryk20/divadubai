<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="slider-form">
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'pause')->textInput(['maxlength' => true])->label('Pause') ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'speed')->textInput(['maxlength' => true])->label('Speed') ?>
        </div>
    </div>
    
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton(
                    $model->isNewRecord 
                        ? Yii::t('app', 'Create') 
                        : Yii::t('app', 'Update'), 
                        [
                            'class' => $model->isNewRecord 
                                ? 'btn btn-success' 
                                : 'btn btn-primary'
                        ]) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
