<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use vova07\imperavi\Widget;


/* @var $this yii\web\View */
/* @var $model app\models\Content */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($istView['is_top'] == '1') : ?>
        <?= $form->field($model, 'top')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 100,
                        'plugins' => [
                            'clips',
                            'fullscreen'
                        ]
                    ]
        ])->label('Top Content');?>
    <?php endif; ?>
    
        
    <?php // if($istView['is_blockquote'] == '1') : ?>
        <?php // = $form->field($model, 'blockquote')->textarea(['rows' => 4])->label('Quote');?>
    <?php // endif; ?>
    

    <?php if($istView['is_description'] == '1') : ?>
        <?= $form->field($model, 'description')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 100,
                        'plugins' => [
                            'clips',
                            'fullscreen'
                        ]
                    ]
        ])->label('Description');?>
    <?php endif; ?>
    
    
    <?php if($istView['is_blockquote'] == '1') : ?>
        <?= $form->field($model, 'blockquote')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 100,
                        'plugins' => [
                            'clips',
                            'fullscreen'
                        ]
                    ]
        ])->label('Description');?>
    <?php endif; ?>
    
    <?php if($istView['is_block_1'] == '1') : ?>
        <?= $form->field($model, 'block_1')->textarea(['rows' => 4])->label('Block 1');?>
    <?php endif; ?>
    
    <?php if($istView['is_block_2'] == '1') : ?>
        <?= $form->field($model, 'block_2')->widget(Widget::className(), [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 100,
                            'plugins' => [
                                'clips',
                                'fullscreen'
                            ]
                        ]
            ])->label('Block 2');?>
    <?php endif; ?>
    
    <?php if($istView['is_block_3'] == '1') : ?>
        <?= $form->field($model, 'block_3')->widget(Widget::className(), [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 100,
                            'plugins' => [
                                'clips',
                                'fullscreen'
                            ]
                        ]
            ])->label('Block 3');?>
    <?php endif; ?>
    
        <?php // = $form->field($model, 'description')->widget(CKEditor::className(), [
//                'options' => [
//                    'rows' => 3,
//                    'id'=>'description-content',
//                ],
//                'preset' => 'basic',
//                'clientOptions' => [
//                    'allowedContent' => true,
//                    'tabindex' => false,
//                    'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken()
//                ],
//            ])->label('Description')
        ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
