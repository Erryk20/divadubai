<?php
use yii\helpers\Url;
use kartik\editable\Editable;
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
//    [
//        'class' => 'kartik\grid\EditableColumn',
//        'options' => ['style' => 'width: 70px'],
//        'attribute' => 'update_date',
//        'pageSummary' => 'Page Total',
//        'vAlign' => 'middle',
//        'headerOptions' => ['class' => 'kv-sticky-column'],
//        'contentOptions' => ['class' => 'kv-sticky-column'],
//        'editableOptions' => function ($model, $key, $index) {
//            return [
//                'options'=>['pluginOptions'=>['format'=>'yyyy-mm-dd']], // javascript format
//                'header' => '&nbsp;',
//                'size' => 'md',
//                'inputType' => Editable::INPUT_DATE,
//                'pluginEvents' => [],
//            ];
//        }
//    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id_vimeo',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_time',
        'value'=>function($model){
            return preg_replace("/^(\d{4}\-\d{1,2}-\d{1,2}).+(.*)\+.*/", "$1", $model->created_time);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'privacy',
    ],
    [
        'attribute'=>'status',
        'value'=>function($model){
            return app\models\Upload::itemAlias('status', $model->status);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'duration',
        'value'=>function($model){
            return date("H:i:s", mktime(0, 0, $model->duration));
        }
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'format' => 'html',
//        'attribute'=>'embed',
////        'attribute'=>function($model){
////            return $model->embed;
////        }
//    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'stream',
//        'format' => 'html',
//        'value'=>function($model){
//            return Html::a('play', ['/admin/upload/stream', 'url'=>$model->stream], ['calss'=>'temp', 'data-pjax'=>"0", 'role'=>"modal-remote", 'data-toggle'=>"tooltip"]);
//        }
//    ],
    [
        'attribute' => 'preview',
        'format' => 'html',
        'value' => function($model){
            return Html::img($model->preview,['width' => 200, 'height' => 100]);
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'description',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'published',
    // ],
    [
        'class' => kartik\grid\ActionColumn::className(),
        'template' => "{add-for-vimeo}",
        'dropdown' => false,
        'vAlign'=>'middle',
        'visibleButtons' => [
            'add-for-vimeo' => function ($model, $key, $index) {
                return !$model->is_added;
            }
        ],
        'buttons'=>[
            'add-for-vimeo' => function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', $url, [
                    'title' => Yii::t('app', 'View'),
                    'ata-pjax'=>"0",
                    'role'=>"modal-remote",
                    'data-toggle'=>"tooltip"
                ]);
            }
        ],
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