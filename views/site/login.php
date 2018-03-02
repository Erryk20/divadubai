<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use kartik\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'Login';
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
        
        <?= $form->field($model, 'usernameOrEmail', [
            'options'=>['class'=>'form-group clearfix'],
            'template' =>   "<label class='main_label'>".
                                $model->getAttributeLabel('username').
                            "</label>".
                            "{input}".
                            "{error}",
        ])->textInput(['maxlength' => true, 'class' => 'form_text form-control']) ?>
        
        
        
        <?= $form->field($model, 'password', [
            'options'=>['class'=>'form-group clearfix'],
            'template' =>   "<label class='main_label'>".
                                $model->getAttributeLabel('password').
                            "</label>".
                            "{input}".
                            "{error}",
        ])->passwordInput(['maxlength' => true, 'class' => 'form_text form-control']) ?>
        
        <!--$model, 'rememberMe',-->
        <div class="form_info clearfix">
            <div class="form-group">
                <div class="form_checkboxes">
                    <div class="form_checkbox">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                </div>
            </div>
            <?= Html::a('Reset Password', ['/site/request-password-reset'], ['class'=>"reset_pass"])  ?>
        </div>
    </div>
    <div class="form_actions">
        <?= Html::submitButton('Login', ['class' => 'btn btn-default']) ?>
    </div>
<?php ActiveForm::end(); ?>