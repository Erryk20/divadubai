<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ModelCategory;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\ModelCategory */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="model-category-form">

    <?php $form = ActiveForm::begin(); ?>

    
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'category')->checkbox() ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'specialization')->checkbox() ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'ethnicity')->checkbox() ?>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'age')->checkbox() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'gender')->checkbox() ?>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'language')->checkbox() ?>
        </div>
    </div>
            
    
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Select a category',
                ],
                'data' => ModelCategory::listCategories(),
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
            ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'type')->dropDownList(['site'=>'site & admin','admin'=>'admin']) ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'menu')->dropDownList(app\models\MenuCategory::listMenu(), ['prompt' => '']) ?>
        </div>
    </div>



  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>