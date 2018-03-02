<?php
use kartik\form\ActiveForm;
use yii\helpers\Html;

?>

<?php  $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'block_1')->textInput()->label('Video');?>

<?php if (!Yii::$app->request->isAjax) { ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php } ?>

<?php ActiveForm::end(); ?>