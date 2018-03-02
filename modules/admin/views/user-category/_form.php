<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;

use app\models\UserInfo;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\UserCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-category-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?=  $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => \app\models\ModelCategory::liatAll(),
        'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label('Categories');
    
    ?>
    
    <?php // foreach ($model->activies as $value) : ?>
<!--    <div class="row">
        <div class="col-md-1 col-sm-12 col-xs-12 form-group">-->
            <?php 
//                echo SwitchInput::widget([
//                    'name' => 'UserCategory[active][]',
//                    'value' => $value['status'],
//                    'pluginOptions' => [
//                        'size' => 'mini',
//                        'onColor' => 'success',
//                        'offColor' => 'danger',
//                        'onText' => 'on',
//                        'offText' => 'off',
//                    ]
//                ]);
            ?>
<!--        </div>
        <div class="col-md-11 col-sm-12 col-xs-12 form-group">
            <?php // = "<label class='control-label'>{$value['category']}</label>"; ?>
        </div>
    </div>-->
    <?php // endforeach; ?>
    

    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
