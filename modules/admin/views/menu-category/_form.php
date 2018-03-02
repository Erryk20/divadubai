<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\MenuCategory;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\MenuCategory */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="menu-category-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'menu')->dropDownList(MenuCategory::listMenu(), ['prompt' => '']) ?>

    
    <?=  $form->field($model, 'categories')->widget(Select2::classname(), [
        'data' => \app\models\ModelCategory::liatAll(),
        'options' => ['placeholder' => 'Select a category ...', 'multiple' => true],
        'data' => app\models\ModelCategory::listCategories(),
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
        ],
    ])->label('Categories');
    ?>


  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
