<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
?>

<?php
$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'form-registration',
            'type' => ActiveForm::TYPE_VERTICAL,
            'formConfig' => ['showErrors' => true],
            'action' => '/admin/email/send-email'
        ]);
?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'subject')->textInput() ?>

<?= $form->field($model, 'message')->textarea() ?>

<div class="form_actions">
    <?=
    Html::button('Send', [
        'class' => 'btn btn-primary',
        'style'=>"float: right;",
        'onclick' => "
                    var block = $('#castingModal .modal-content');

                    $.ajax({
                        type   :'POST',
                        data: $(block).find('form').serialize(),
                        url  : '/ajax/send-email-profile?id={$id}',
                        success  : function(response) {
                            if(response['status'] === true){
                                $('#castingModal').modal('toggle')
                            }

                            block.empty();
                            block.html(response['html']);
                        }
                    }); return false;"
    ]);
    ?>
</div>


<?php ActiveForm::end(); ?>
                


