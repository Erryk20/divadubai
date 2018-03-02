<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ContactsInfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contacts-info-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'published')->checkbox() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'post')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'mobile')->widget(Select2::classname(), [
                    'maintainOrder' => true,
                    'options' => ['multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 13
                    ],
                ])->label('Mobiles');
            ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'email')->widget(Select2::classname(), [
                    'maintainOrder' => true,
                    'options' => ['multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                        'tokenSeparators' => [',', ' '],
                        'maximumInputLength' => 30
                    ],
                ])->label('Emails');
            ?>
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
