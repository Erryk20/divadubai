<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use app\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'published')->checkbox() ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'language')->dropDownList(Language::getLanguageShort(), ['options' =>[Yii::$app->language=>['Selected'=>true]],  'prompt'=>'Select language']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'category_id')->dropDownList(\app\models\Categories::getCategoriesId($model->language), ['prompt'=>'Select category']) ?>
        </div>
    </div>
    
    
    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'multiple'=> false
        ],
        'pluginOptions' => [
            'initialPreview'=>[
                $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/products/{$model->img}"), 'width' => 200, 'height' => 200]),
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
    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
