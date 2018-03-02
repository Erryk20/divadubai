<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use app\models\Language;
use app\models\CategoryFaqs;

/* @var $this yii\web\View */
/* @var $model app\models\Faqs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faqs-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'published')->checkbox() ?>

        <div class="row">
           <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <?= $form->field($model, 'language_id')->dropDownList(
                        \app\models\Language::getLanguageId(), 
                        [
                            'options' =>[Language::getId(Yii::$app->language) => ['Selected'=>true]],  
                            'prompt'=>'Select language',
                            'onchange'=> "setCategoryFaqs($(this).val())"
                        ]) ?>
           </div>
           <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <?= $form->field($model, 'category_faqs_id')->dropDownList(CategoryFaqs::getCategoryFaqsIdAll(), ['options' =>[$model->category_faqs_id => ['Selected'=>true]],  'prompt'=>'Select category FAQs', 'disabled' => !$model->isNewRecord]) ?>
           </div>
        </div>
    
    
    
<?php
$script = <<< JS
        function setCategoryFaqs(id){
            $.get( "/ajax/get-category-faqs?language_id="+id, function( data ) {
                var insert = $('#faqs-category_faqs_id'); 
                insert.html(data);
                insert.removeAttr( 'disabled' )
            });
        }
JS;
?>
<?php $this->registerJs($script, yii\web\View::POS_END); ?>



    <?= $form->field($model, 'questions')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'answer')->widget(CKEditor::className(), [
                'options' => ['rows' => 3],
                'preset' => 'full',
                'clientOptions' => [
                    'allowedContent' => true,
                    'tabindex' => false,
                    'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
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
