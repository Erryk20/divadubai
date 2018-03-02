<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Casting */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="casting-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'category_id')->dropDownList(\app\models\ModelCategory::listCategoriesForCasting(), ['prompt' => 'Seect Category']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php 
        $preview = $model->src ? $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/casting/{$model->src}"), 'width' => 200, 'height' => 140]) : false;
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
            'showUpload' => false
        ]
    ]) ?>

     <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
           <?= $form->field($model, 'gender')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'fee')->textInput(['maxlength' => true]) ?>
        </div>
     </div>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'casting_date')->widget(DatePicker::classname(), [
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'mm/dd/yyyy',
                        'todayHighlight' => true
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'job_date')->widget(DatePicker::classname(), [
                    'pluginOptions' => ['autoclose'=>true]
                ]);
            ?>
        </div>
    </div>
             

     <div class="row">
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'time_from')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '99:99',
            ]) ?>
         </div>
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'time_to')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '99:99',
            ]) ?>
         </div>
     </div>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'booker_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'bookers_number')->widget(\yii\widgets\MaskedInput::className(), [
                'mask' => '+999 99 999 9999',
            ]) ?>
        </div>
    </div>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'details')->textarea(['rows' => 6]) ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
