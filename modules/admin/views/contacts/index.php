<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

CrudAsset::register($this);


$script = <<< JS
    function setTerm(term, val) {
        $.ajax({
            url: '/admin/contacts/set',
            data: {value : val, term : term},
            success: function (result){
                console.log(result);
            },
        });
    }
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
<style>
    .pac-container {
        z-index: 99999;
    }
</style>


<div class="contacts-info-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-sortable-id' => $model->id];
            },
            'options' => [
                'data' => [
                    'sortable-widget' => 1,
                    'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
                ]
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Contacts Infos','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    
                    Html::a('<div class="property-sider btn-group">Title</div>', ['title', 'id'=>1],
                    ['role'=>'modal-remote','title'=> 'Update title','class'=>'btn btn-default']).
                    
                    Html::a('<div class="property-sider btn-group">Content</div>', ['/admin/content/update', 'target_id'=>1, 'type'=>'contact'],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default']).
                    
                    Html::a('<div class="property-sider btn-group">SEO</div>', ['/admin/seo/update', 'target_id'=>1, 'type'=>'contact'],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Contacts Infos listing',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulkdelete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item',
                                    'style'=> 'height: 22px;',
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>

<div class="contacts-form">

    <?php $form = ActiveForm::begin(); ?>
  
    <?php // = $form->field($model, 'addres')->textarea(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'latitude')->hiddenInput(['id'=>"lat"])->label(false);?>
    <?= $form->field($model, 'longitude')->hiddenInput(['id'=>"lon"])->label(false);?>
    
    <div class="row">
        <div class="col-md-1">
              <?= $form->field($model, 'zoom')->textInput();?>
        </div>
        <div class="col-md-11">
            <?= $form->field($model, 'localisation')->textInput(['id'=>'address','class'=>"form-control"]);?>
        </div>
    </div>
    
    
    <div id="us3" style="width: 100; height: 400px;"></div>
    <?php if (!Yii::$app->request->isAjax){ ?>
            <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

<?php ActiveForm::end(); ?>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",
    'options' => [
        'tabindex' => false,
    ],
])?>
<?php Modal::end(); ?>

<?php 
$script = <<< JS
    $(document).ready(function() {
        $('#us3').locationpicker({
            key:"AIzaSyAUTvqT9d5ibHqRXZLNjxOA6fxdCI06i4U",
            location: {
                latitude: $model->latitude,
                longitude: $model->longitude
            },
            zoom: $model->zoom,
            radius: false,
            inputBinding: {
                latitudeInput: $('#lat'),
                longitudeInput: $('#lon'),
                locationNameInput: $('#address')
            },
            enableAutocomplete: true
        });
    });
JS;
?>
<?php $this->registerJs($script, yii\web\View::POS_END); ?>

<?php $this->registerJsFile('http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAUTvqT9d5ibHqRXZLNjxOA6fxdCI06i4U', ['depends' => [yii\web\JqueryAsset::className()]]); ?> 
<?php $this->registerJsFile('js/locationpicker.jquery.js', ['depends' => [yii\web\JqueryAsset::className()]]); ?> 

