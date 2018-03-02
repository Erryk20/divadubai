<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryFaqs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-faqs-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'language_id')->dropDownList(
                    \app\models\Language::getLanguageId(), 
                    [
                        'options' =>[Language::getId(Yii::$app->language) => ['Selected'=>true]],
                        'prompt'=> Yii::t('app', 'Select language')
                    ]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
