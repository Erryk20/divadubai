<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceCategories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'service_id')->dropDownList(app\models\Services::getList(), ['prompt'=>'Select Service']) ?>

    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
           <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
           <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
           <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
