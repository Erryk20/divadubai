<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'language')->dropDownList(\app\models\Language::getLanguageShort(), ['options' =>[Yii::$app->language=>['Selected'=>true]],  'prompt'=>'Select language']) ?>
        <?= $form->field($model, 'id')->widget(Select2::classname(), [
            'disabled'=> !$model->isNewRecord,
            'options' => ['multiple' => false, 'placeholder' => Yii::t('app', 'Select source')],
            'data'=> \app\models\SourceMessage::getSourceId(),
//            'value'=>Yii::$app->language,
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])
        ?>
        <?= $form->field($model, 'translation')->textarea(['maxlength' => true, 'rows'=>5]) ?>
    
    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
