<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use app\models\Categories;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'published')->checkbox() ?>

    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'multiple'=> false
        ],
        'pluginOptions' => [
            'initialPreview'=>[
                $model->isNewRecord ? null : $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$model->src}"), 'width' => 200, 'height' => 200]),
            ],
            'previewFileType' => 'image',
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>true,
            'showPreview' => !$model->isNewRecord,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false
        ]
    ]) ?>
    
     <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'options' => ['multiple' => false, 'placeholder' => Yii::t('app', 'Select a category')],
                'data'=> Categories::getCategoriesId(),
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
                        
            ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
     </div>
    

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
