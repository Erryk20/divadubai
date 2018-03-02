<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'language_id',
        'value'=>  function ($model){
            return $model->language_id ? $model->language->name : null;
        },
        'options'=>['width'=>'120px;'],
        'filter'=> app\models\Language::getLanguageId(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_faqs_id',
        'value'=>  function ($model){
            return $model->category_faqs_id ? $model->category->name : null;
        },
        'options'=>['width'=>'120px;'],
        'filter'=> false //app\models\Language::getLanguageId(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'questions',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'answer',
//    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
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