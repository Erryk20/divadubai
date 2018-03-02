<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use kartik\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Reset password';
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
        
        <?= $form->field($model, 'email', [
            'options'=>['class'=>'form-group clearfix'],
            'template' =>   "<label class='main_label'>".
                                $model->getAttributeLabel('email').
                            "</label>".
                            "{input}".
                            "{error}",
        ])->textInput(['maxlength' => true, 'class' => 'form_text form-control']) ?>
    </div>

    <div class="form_actions">
        <?= Html::submitButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>
<?php ActiveForm::end(); ?>