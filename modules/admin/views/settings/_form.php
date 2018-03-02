<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <?= $form->field($model, 'properties')->textInput(['readonly' => true, 'maxlength' => true]) ?>
                </div>
                <div class="col-6">
                    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
