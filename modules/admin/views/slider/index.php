<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sliders');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);



?>
<style>
    .property-sider span{
        margin-left: 5px;
    }
    
</style>

<div class="slider-index">
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
//                    <div class="btn-group">
//                      <a id="crud-datatable-togdata-page" class="btn btn-default" href="/admin/slider/index?_togc9414601=all" title="Show all data" data-pjax="true">
//                          <i class="glyphicon glyphicon-resize-full"></i> All
//                      </a>
//                    </div>
                    
                    Html::a('<div class="property-sider btn-group">Property</div>', ['property'],
                    ['role'=>'modal-remote','title'=> 'Update speed','class'=>'btn btn-default']).
                    
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Sliders','class'=>'btn btn-default']).
                    
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Sliders listing'
//                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em></br>'
//                    Editable::widget([
//                        'name'=>'speed', 
//                        'id'=>'speed-slider',
//                        'asPopover' => false,
//                        'displayValue' => "Speed :".$sliderCont->speed,
//                        'inputType' => Editable::INPUT_TEXT,
//                        'value' => $sliderCont->speed,
//                        'header' => 'Notes',
//                        'submitOnEnter' => false,
//                        'options' => [
//                            'class'=>'form-control', 
//                            'rows'=>7, 
//                            'style'=>'width:500px', 
//                            'placeholder'=>'Set time from SLIDER...'
//                        ]
//                    ])."</br>".
//                    Editable::widget([
//                        'name'=>'pause', 
//                        'id'=>'pause-slider',
//                        'asPopover' => false,
//                        'displayValue' => "Pause :".$sliderCont->pause,
//                        'inputType' => Editable::INPUT_TEXT,
//                        'value' => $sliderCont->pause,
//                        'header' => 'Notes',
//                        'submitOnEnter' => false,
//                        'options' => [
//                            'class'=>'form-control', 
//                            'rows'=>7, 
//                            'style'=>'width:500px', 
//                            'placeholder'=>'Set time from SLIDER...'
//                        ]
//                    ])."</br>".
//                    Editable::widget([
//                        'name'=>'notes', 
//                        'id'=>'text-slider',
//                        'asPopover' => false,
//                        'displayValue' => $sliderCont->content,
//                        'inputType' => Editable::INPUT_TEXTAREA,
//                        'value' => $sliderCont->content,
//                        'header' => 'Notes',
//                        'submitOnEnter' => false,
//                        'options' => [
//                            'class'=>'form-control', 
//                            'rows'=>7, 
//                            'style'=>'width:500px', 
//                            'placeholder'=>'Enter notes...'
//                        ]
//                    ])
                    ,
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulk-delete"] ,
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
<?php 

Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",
    'options' => [
        'tabindex' => false,
    ],
]);

Modal::end();

$this->registerCss("
    #text-slider-cont .panel-default{
        margin-top: 15px;
        margin-bottom: 0;
    }

    #text-slider-cont {
        width: 100%;
        text-align: center;
        font-size: 32px;
        margin: 15p
    }
");
?>