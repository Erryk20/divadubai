<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model app\models\Blogs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blogs-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?php 
        $preview = $model->src ? $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/blog/{$model->src}"), 'width' => 200, 'height' => 140]) : false;
    ?>
    
    <?= $form->field($model, 'file')->widget(FileInput::className(), [
        'options' => [
            'accept' => 'image/*',
            'multiple'=> false
        ],
        'pluginOptions' => [
            'initialPreview'=>$preview,
            'previewFileType' => 'image',
            'initialPreviewAsData'=>true,
            'overwriteInitial'=>true,
            'showPreview' => !$model->isNewRecord,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false
        ]
    ]) ?>
    
    
    <?= $form->field($model, 'description')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 300,
                        'plugins' => [
                            'clips',
                            'fullscreen'
                        ]
                    ]
        ])->label('Top Content');?>



    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
