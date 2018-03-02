<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;


/* @var $this yii\web\View */
/* @var $model app\models\Diva */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="diva-form">

    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>
    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'url')->textInput(['readonly' => !$model->isNewRecord, 'maxlength' => true]) ?>
        </div>
    </div>


    <?= $form->field($model, 'block_1')->textarea(['rows'=>"5"])->label(false);?>
    <?= $form->field($model, 'block_2')->textarea(['rows'=>"4"])->label(false);?>
    <?= $form->field($model, 'block_3')->textarea(['rows'=>"4"])->label(false);?>
    <?= $form->field($model, 'block_4')->textarea(['rows'=>"4"])->label(false);?>
    
    
    
    <?= $form->field($model, 'block_5')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 100,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ])->label(false);?>
    

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
