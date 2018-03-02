<?php
use yii\helpers\Url;
use yii\helpers\Html;

//p.created_at, p.updated_at, '#', pl.`language`, pl.`name`, pl.description

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'checkboxOptions' => function($model, $key, $index, $column) {
            return ['value' => "{$model['id']}-{$model['language']}"];
        }
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
        'attribute'=>'category_id',
        'options'=>['width'=>'120px;'],
        'value'=> 'category_name',
        'filter'=> app\models\Categories::getCategoriesId($language),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format'=>'raw',
        'attribute'=>'description',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'price',
    ],
    [
        'class' => 'kartik\grid\BooleanColumn',
        'attribute' => 'published',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'img',
        'format' => 'html',
        'value' => function($model){
            return $model['src'] ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/{$model['src']}"), 'width' => 200, 'height' => 100]): null;
        },
        'filter'=>false
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'updated_at',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
            return Url::to([$action,'id'=>$model['id'], 'language'=>$model['language']]);
        },
                
        'template' => '{view} {update} {create-lan} {delete}',
        'buttons' => [
            'create-lan' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                    'title'=>"Create product for language",
                    'data-pjax'=>"0",
                    'role'=>"modal-remote",
                    'data-toggle' =>"tooltip"
                ]);
            },
        ],
        
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