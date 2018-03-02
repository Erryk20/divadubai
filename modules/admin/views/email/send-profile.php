<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;


$form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'form-registration',
            'type' => ActiveForm::TYPE_VERTICAL,
            'formConfig' => ['showErrors' => true],
            'action' => '/admin/email/send-email'
        ]);
?>

<?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

<?=
$form->field($model, 'message')->widget(dosamigos\ckeditor\CKEditor::className(), [
    'options' => [
        'rows' => 3,
        'id' => 'description-content',
    ],
    'preset' => 'standard',
    'clientOptions' => [
        'allowedContent' => true,
        'tabindex' => false,
        'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken(),
    ],
])
?>


<div class="modal-footer">
    <?=
    Html::button('Send', [
        'class' => 'btn btn-primary',
        'onclick' => "
            var block = $('.modal-body');

            $.ajax({
                type   :'POST',
                data: $(block).find('form').serialize(),
                url  : '/admin/email/send-email?id={$id}',
                success  : function(response) {
                    if(response['status'] === true){
                        $('#email-send-profile').modal('toggle')
                    }
                    
                    block.empty();
                    block.html(response['html']);
                }
            }); return false;"
    ]);
    ?>
</div>
<?php ActiveForm::end(); ?>