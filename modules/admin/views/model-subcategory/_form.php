<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ModelSubcategry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="model-subcategry-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

     <div class="row">
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                    'options' => [
                        'multiple' => false, 
                        'placeholder' => Yii::t('app', 'Select a category'),
                    ],
                    'data'=> \app\models\ModelCategory::liatAll(),
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])

                ?>
         </div>
         <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                    'options' => [
                        'multiple' => false, 
                        'placeholder' => '',
                    ],
                    'data'=> \app\models\ModelSubcategory::listSubcategory(),
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])

                ?>
         </div>
     </div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
