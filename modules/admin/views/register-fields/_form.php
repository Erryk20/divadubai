<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\RegisterFields */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="register-fields-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
                'options' => [
                    'multiple' => false,
                    'placeholder' => 'Select a category',
                ],
                'data' => \app\models\ModelCategory::listCategories(),
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])
            ?>

    <?=  $form->field($model, 'fields')->widget(Select2::classname(), [
        'data' => Yii::$app->controller->labels,
        'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label('Fields');
    
    ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
