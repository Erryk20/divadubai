<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\ContentImages */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-images-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
    
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'title')->textInput() ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'slug')->textInput() ?>
        </div>
    </div>
        
    <?php 
        $preview = $model->src ? $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/office/{$model->src}"), 'width' => 200, 'height' => 140]) : false;
    ?>
    
    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'multiple'=> false
        ],
        'pluginOptions' => [
            'initialPreview'=>$preview,
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
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
