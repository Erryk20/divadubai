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
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'target_id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'top',
        'format'=>'html',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'blockquote',
        'format'=>'html',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'description',
        'format'=>'html',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action, 'target_id'=>$model->target_id, 'type'=>$model->type]);
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