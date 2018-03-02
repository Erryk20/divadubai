<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Booking */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="booking-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_id')->textInput() ?>

    <?= $form->field($model, 'requirement')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'booked_as')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usage_for')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'booker_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'period')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_shoot')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'job_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ac_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ac_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'signature')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'act_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cheque')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'from_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'to_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
          <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
