<?php
use yii\helpers\Url;
use kartik\select2\Select2;
use kartik\grid\GridView;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'language',
        'options'=>['width'=>'120px;'],
        'filter'=> app\models\Language::getLanguageShort(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'options'=>['width'=>'220px;'],
        'value'=> function($model){
            return $model->source->message;
        },
        'filterType'=>GridView::FILTER_SELECT2,
        'filterInputOptions'=>['placeholder'=>  Yii::t('app', 'Select source')],
        'filterWidgetOptions'=>[
            'initValueText' => $model->communications->name,
            'pluginOptions' => ['allowClear' => true],
            'data'=> \app\models\SourceMessage::getSourceId() ,
        ],
                
//        'filter' => Select2::widget([
//            'name' => 'MessageSearch[id]',
////            'value' => $searchModel->id_source,
//            'theme' => Select2::THEME_BOOTSTRAP,
//            'options' => ['multiple' => false, 'placeholder' => Yii::t('app', 'Select source')],
//            'pluginOptions' => [
//                'allowClear' => true,
//            ],
//        ])
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'translation',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
            return Url::to([$action, 'id'=>$key['id'], 'language'=>$key['language']]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   