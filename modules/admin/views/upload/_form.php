<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;

/* @var $this yii\web\View */
/* @var $model app\models\Upload */
/* @var $form yii\widgets\ActiveForm */

?>
<style>
    html {position: relative;min-height: 100%;}
    body {margin-bottom: 60px;color: #505662;}
    .help {font-size: smaller;}
    .page-header {padding-bottom: 18px;margin: 40px 0 12px;}
    .logo {width: 100%;margin-bottom: 20px;}
    .lead {font-size: 18px; margin-bottom: 12px;}

    /* Custom page CSS */
    .container .text-muted {margin: 20px 0;}
    #progress-container {background-color: #1abb9c;}
    #progress-container {-webkit-box-shadow: none; box-shadow: inset none; display:none;}
    #drop_zone {border: 2px dashed #bbb;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        padding-top: 60px;
        text-align: center;
        font: 20pt bold 'Helvetica';
        color: #bbb;
        height:140px;
    }

    #video-data {margin-top: 1em; font-size: 1.1em; font-weight: 500;}

    /* Bragit buttons, http://websemantics.github.io/bragit/ */
    .ui.bragit.button, .ui.bragit.buttons .button {background-color: #676f7e; color: #fff!important;}

    .ui.bragit.label {color: #505662!important;
        border-color: #676f7e!important;
        background-color: #ffffff;
    }

    .ui.bragit.button:focus,
    .ui.bragit.buttons .button:focus,
    .ui.bragit.button:hover,
    .ui.bragit.buttons .button:hover {background-color: #505662;}

    .ui.bragit.labels .label:focus,
    .ui.bragit.label:focus,
    .ui.bragit.labels .label:hover,
    .ui.bragit.label:hover {color: #505662!important; border-color: #505662!important;}
    .ui.labeled .ui.button .star.icon {color: #F5CC7A!important;}
</style>


<div class="upload-form">
    <div id="progress-container" class="progress">
        <div id="progress" class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="46" aria-valuemin="0" aria-valuemax="100" style="width: 0%">&nbsp;0%
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="results"></div>
        </div>
    </div>

    <?php $form = ActiveForm::begin(['id'=>'vimeo']); ?>
    
    <?= $form->field($model, 'upgrade_to_1080')->hiddenInput()->label(false); //->checkbox() ?>
    <?= $form->field($model, 'make_private')->hiddenInput()->label(false); // ->checkbox() ?>
    <!--is_webinar-->
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['placeholder' => "Video name"]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoriesId(), ['prompt' => $model->getAttributeLabel('category_id')]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'language_id')->dropDownList(\app\models\Language::getLanguageId(), ['prompt' => $model->getAttributeLabel('language_id')]) ?>
        </div>
        <div style="padding: 24px 0 0 0;" class="col-md-2">
            <?= $form->field($model, 'is_webinar')->radioList([0=>'video', 1=>'webinar'],['label' => 'yes', 'value' => 1])->label(false)?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder'=>"Video description"]);?>
        </div>
    </div>

    
    
    <?= $form->field($model, 'access_token')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'id_vimeo')->hiddenInput()->label(false) ?>
    
    <?php if (!Yii::$app->request->isAjax){ ?>
        <div class="form-group" style="margin-top: 60px;">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
    
    <?= $form->field($model, 'videoFile', [
        'template' => "<label class='btn btn-block btn-info' style='position: relative; top: -104px;'>Browse&hellip; {input}</label>{error}"
    ])->fileInput([
        'style' => "display: none;",
        'accept' => 'video/*',
    ])->label(false);
    ?>
</div>

<script type="text/javascript">
    function getInfoVideo(id) {$.get("/admin/vimeo/video-for-id?vimeo_id=" + id, function (data) {    
            console.log(data);
        });
    }
    
    /**
     * Called when files are dropped on to the drop target or selected by the browse button.
     * For each file, uploads the content to Drive & displays the results when complete.
     */
    function handleFileSelect(evt) {
        if($('#upload-name').val() == ''){
            var field_name = $('.field-upload-name');
            field_name.addClass('has-error');
            field_name.find('p').text('Name cannot be blank.');
            return false; 
        }
      
        evt.stopPropagation();
        evt.preventDefault();
        var files = evt.dataTransfer ? evt.dataTransfer.files : $(this).get(0).files;
        var results = document.getElementById('results');
        
        /* Clear the results div */
        while (results.hasChildNodes())
            results.removeChild(results.firstChild);

        /* Rest the progress bar and show it */
        updateProgress(0);
        document.getElementById('progress-container').style.display = 'block';

                /* Instantiate Vimeo Uploader */
                ;
        (new VimeoUpload({
            name: document.getElementById('upload-name').value,
            description: document.getElementById('upload-description').value,
            private: document.getElementById('upload-make_private').checked,
            file: files[0],
            token: document.getElementById('upload-access_token').value,
            upgrade_to_1080: document.getElementById('upload-upgrade_to_1080').checked,
            onError: function (data) {       
                showMessage('<strong>Error</strong>: ' + JSON.parse(data).error, 'danger');
            },
            onProgress: function (data) {
                console.log(data.loaded+' '+data.total+' = '+ (data.loaded / data.total));
                updateProgress(data.loaded / data.total);
            },
            onComplete: function (videoId, index) {   
                $('#upload-id_vimeo').val(videoId);
                var url = 'https://vimeo.com/' + videoId;

                if (index > -1) {            /* The metadata contains all of the uploaded video(s) details see: https://developer.vimeo.com/api/endpoints/videos#/{video_id} */
                    url = this.metadata[index].link; //

                    /* add stringify the json object for displaying in a text area */
                    var pretty = JSON.stringify(this.metadata[index], null, 2);
                    
                    var iframe = this.metadata[index];
//                    $('form#vimeo').before(iframe.embed.html);
                };

                showMessage('<strong>Upload Successful</strong>: check uploaded video @ <a href="' + url + '">' + url + '</a>. Open the Console for the response details.');
            }
        })).upload();

        /* local function: show a user message */
        function showMessage(html, type) {    /* hide progress bar */
            document.getElementById('progress-container').style.display = 'none';

            /* display alert message */
            var element = document.createElement('div');
            element.setAttribute('class', 'alert alert-' + (type || 'success'));
            element.innerHTML = html;
            results.appendChild(element);
        };
    };

    /**
     * Dragover handler to set the drop effect.
     */
    function handleDragOver(evt) {evt.stopPropagation();
        evt.preventDefault();
        evt.dataTransfer.dropEffect = 'copy';
    };

    /**
     * Updat progress bar.
     */
    function updateProgress(progress) {progress = Math.floor(progress * 100);
        var element = document.getElementById('progress');
        element.setAttribute('style', 'width:' + progress + '%');
        element.innerHTML = '&nbsp;' + progress + '%';
    }
    /**
     * Wire up drag & drop listeners once page loads
     */
    document.addEventListener('DOMContentLoaded', function () {
//        var dropZone = document.getElementById('drop_zone');
        var browse = document.getElementById('upload-videofile');
//        dropZone.addEventListener('dragover', handleDragOver, false);
//        dropZone.addEventListener('drop', handleFileSelect, false);
        browse.addEventListener('change', handleFileSelect, false);
    });

</script>
