<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Awards */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="awards-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        $logo = ($model->img && !preg_match('/\.svg$/', $model->img)) ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/clients/{$model->img}"), 'width' => 200, 'height' => 200]) : false;
    
    ?>
    
    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'multiple'=> false
        ],
        'pluginOptions' => [
            'showUpload' => false,
            'browseLabel' => '',
            'removeLabel' => '',
            'initialPreview'=> $logo,
            'previewFileType' => 'image',
            'showPreview' => $model->img,
        ]
    ]) ?>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
