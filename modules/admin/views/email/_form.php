<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\web\JsExpression;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */


$this->registerJs(new JsExpression("CollectID()"), View::POS_HEAD);
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

     
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'itemsID')->hiddenInput()->label(false) ?>
    
    <?= $form->field($model, 'message')->widget(CKEditor::className(), [
            'options' => [
                'rows' => 3,
                'id'=>'description-content',
            ],
            'preset' => 'standard',
            'clientOptions' => [
                'allowedContent' => true,
                'tabindex' => false,
                'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken(),
            ],
        ])
    ?>
    

    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
