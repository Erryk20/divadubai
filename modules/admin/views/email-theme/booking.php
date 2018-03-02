<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use vova07\imperavi\Widget;
use yii\helpers\Url;
USE zyx\widgets\Redactor;
use dosamigos\ckeditor\CKEditor;


/* @var $this yii\web\View */
/* @var $model app\models\EmailTheme */
/* @var $form yii\widgets\ActiveForm */

//$this->registerJs("CKEDITOR.plugins.addExternal('tabletoolstoolbar', '/js/ck-editor/tabletoolstoolbar/plugin.js', '');");
//{domen} {link} {fulllName}
?>

<div class="email-theme-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'subject')->textInput(); ?>
    
    <p>{domen} - Domen </br>{link} - Site link </br>{fulllName} - Full name user</br>{category} - Category</p>
    
    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
                'options' => [
                    'rows' => 3,
                    'id'=>'description-content',
                ],
                'preset' => 'standard',
                'clientOptions' => [
                    'allowedContent' => true,
                    'tabindex' => false,
                    'filebrowserUploadUrl' => "/ajax/image-ck-editor?_csrf=" . Yii::$app->request->getCsrfToken(),
                ],
            ])->label('Content')
        ?>
    
    <?php
//    echo $form->field($model, 'content')->widget(
//        Redactor::className(), [
//            'options' => [
//                'style' => 'height: 300px;'
//            ],
//            'clientOptions' => [
//                'observeLinks'      => true,
//                'convertVideoLinks' => true,
//                'autoresize'        => true,
//                'placeholder'       => Yii::t('app', 'Redactor placeholder text'),
//                'plugins'           => ['table', 'video', 'fontcolor', 'fontfamily', 'fontsize', 'mailto'],
//                'buttons'           => ['html', 'formatting', 'bold', 'italic', 'deleted', 'underline', 'horizontalrule',
//                                        'alignment', 'unorderedlist', 'orderedlist', 'outdent', 'indent',
//                                        'link', 'image', 'file', 'mailto'],
//                'imageUpload'       => Url::toRoute(['/admin/email-theme/upload']),
//            ],
//        ]
//    );
    
//    = Widget::widget([
//            'name' => 'test',
//            'settings' => [
//                'lang' => 'ru',
//                'minHeight' => 200,
//                'fileManagerJson' => Url::to(['/default/files-get']),
//                'plugins' => [
//                    'filemanager'
//                ]
//            ]
//        ]);
        
    ?>


    <?php //  = $form->field($model, 'content')->widget(Widget::className(), [
//                    'settings' => [
//                        'minHeight' => 200,
////                        'imageManagerJson' => Url::to(['/default/images-get']),
//                        
//                        'fileManagerJson' => Url::to(['/default/files-get']),
//                        'plugins' => [
//                            'filemanager'
//                        ]
////                        'plugins' => [
////                            'table',
////                            'imagemanager',
//////                            'clips',
////                            'fullscreen'
////                        ]
//                    ]
//        ]);?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
