<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Please choose your new password';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
        'id' => 'form_login',
        "options"=>[
            'class'=>"login_form"
        ],
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['showErrors' => true],
    ]); ?>

    <div class="form_content">
        <?= $form->errorSummary($model); ?>
        <?= $form->field($model, 'password', [
            'options'=>['class'=>'form-group clearfix'],
            'template' =>   "<label class='main_label'>".
                                $model->getAttributeLabel('password').
                            "</label>".
                            "{input}".
                            "{error}",
        ])->passwordInput(['maxlength' => true, 'class' => 'form_text form-control']) ?>
    </div>

    <div class="form_actions">
        <?= Html::submitButton('Save', ['class' => 'btn btn-default']) ?>
    </div>
<?php ActiveForm::end(); ?>