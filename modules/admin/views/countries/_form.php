<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Language;
use yii\web\JsExpression;
use yii\web\View;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="countries-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12"></div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <?= $form->field($model, 'language')->dropDownList(Language::getLanguageShort(), ['options' =>[Yii::$app->language=>['Selected'=>true]],  'prompt'=>'Select language']) ?>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12"></div>
    </div>

    
    <?php 
    $format = <<< SCRIPT
    var dataResult;
        
    function setCountry(short_name){
        $('#countries-country').val(short_name);
            
        $.each(dataResult.results, function(index, value){
            if(value.id == short_name){
                $('#countries-name').val(value.text);
            };
        })
            
    };
        
    function format(state) {
        if (!state.id) return state.text; // optgroup
            
        return '<i class="flag flag-'+ state.id +'"></i><span>'+ state.text +'</span>';
    }
SCRIPT;
    
$escape = new JsExpression("function(m) { return m; }");
$this->registerJs($format, View::POS_HEAD);
?>
    

    <?= $form->field($model, 'country')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'name')->hiddenInput()->label(false) ?>
    
        <div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?= $form->field($model, 'short_name')->widget(Select2::classname(), [
                                    'options' => [
                                        'name'=>'q', 
                                        'maxlength' => true, 
                                        'placeholder'=>  Yii::t('app', 'Select Cauntry')
                                    ],
                                    'changeOnReset'=> false,
                                    'pluginOptions' => [
                //                        'allowClear' => true,
                                        'minimumInputLength' => 1,
                                        'ajax' => [
                                            'url' => Url::toRoute(['/ajax/country-search']),
                                            'dataType' => 'json',
                                            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                            'success' => new JsExpression('function(data){dataResult = data;}'),
                                        ],
                                        'templateResult' => new JsExpression('format'),
                                        'escapeMarkup' => $escape,
                                    ],
                                    'pluginEvents'=>[
                //                        "change" => "function() {setCountry()}",
                                        "select2:select" => "function(e) {setCountry(e.target.value); }",
                                    ] 
                                ])
                    ?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <?= $form->field($model, 'talking')->textInput() ?>
            </div>
        </div>
    
     
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
