<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserMedia;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\UserMedia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-media-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
    
    <?= $form->field($model, 'type')->dropDownList(UserMedia::itemAlias('photo'), ['prompt' => '']) ?>
    
    <?php 
        $photo = $model->src ? $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/user-media/{$model->src}"), 'width' => 200, 'height' => 200]) : false;
    ?>

    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'multiple'=> false
        ],
        'pluginOptions' => [
            'initialPreview'=> $photo,
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
