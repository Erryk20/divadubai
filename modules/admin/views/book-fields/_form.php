<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Book;

/* @var $this yii\web\View */
/* @var $model app\models\BookFields */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-fields-form">

    
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'require')->checkbox() ?>
    
    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'book_id')->dropDownList(Book::getBooksId(), 
                    ['prompt'=>'Select book']) ?>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
            <?= $form->field($model, 'type')->dropDownList(\app\models\BookFields::itemAlias('type'), 
                    [
                        'options' =>['text'=>['Selected'=>true]],
                        'prompt'=>'Select type file']) ?>
        </div>
    </div>
    

    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
