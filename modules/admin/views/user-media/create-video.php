<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\UserMedia;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\UserMedia */
?>

<div class="user-media-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>
    
    
    <?= $form->field($model, 'type')->dropDownList(UserMedia::itemAlias('video'), ['prompt' => '']) ?>

    <?= $form->field($model, 'link', ['addon' => ['prepend' => ['content'=>'www']]]); ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
