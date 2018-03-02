<?php
use yii\helpers\Url;
use yii\helpers\Html;

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
        'attribute'=>'language',
        'options'=>['width'=>'120px;'],
        'filter'=> app\models\Language::getLanguageShort(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'username',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'format' => 'raw',
        'value'=> function($model){
            return Html::a(
                    $model->name, 
                    ['/site/post', 'url'=>$model->url], 
                    [
                        'data-pjax' => 0,
                        'target' => "_blank",
                    ]
            );
        },
        
//        
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'format'=>'raw',
//        'attribute'=>'short_description',
//    ],
    [
        'class' => 'kartik\grid\BooleanColumn',
        'attribute' => 'published',
        'vAlign' => 'middle',
    ],
    [
        'class' => 'kartik\grid\BooleanColumn',
        'attribute' => 'introduction',
        'vAlign' => 'middle',
    ],
    [
        'attribute' => 'img',
        'format' => 'html',
        'value' => function($model){
            return ($model->img && $model->type_file == 'image') ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/posts/{$model->img}"), 'width' => 200, 'height' => 100]): null;
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