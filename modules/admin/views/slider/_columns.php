<?php
use yii\helpers\Url;
use kartik\editable\Editable;


return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'vAlign'=>'middle',
    ],
    [
        'class' => \kotchuprik\sortable\grid\Column::className(),
        'contentOptions' => ['style' => 'vertical-align: middle;'],
    ],
//    [
//        'class' => 'kartik\grid\EditableColumn',
//        'options' => ['style' => 'width: 70px'],
//        'attribute' => 'sorting',
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
//    'id',
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'html',
        'attribute'=>'title',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'html',
        'attribute'=>'description',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'published', 
        'vAlign'=>'middle',
    ],
    [
        'attribute' => 'img',
        'format' => 'html',
        'value' => function($model){
            return $model->img ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/slider/{$model->img}"), 'width' => 200, 'height' => 100]): null;
        },
        'filter'=>false
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'width' => '100px',
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'buttons'=>[
            'view'=>function ($url, $model) {
                return \yii\helpers\Html::a( '<span class="fa fa-eye"></span>', $url,
                                        [
                                            'title' => Yii::t('yii', 'View'),
                                            'class'=>'btn btn-xs btn-primary btn-detail',
                                            'data-pjax'=>"0",
                                            'role'=>"modal-remote",
                                            'data-toggle'=>"tooltip",
                                            'data-original-title'=>"View",
                                            'style'=> 'height: 22px;',
                                        ]);
            },
            'update'=>function ($url, $model) {
                return \yii\helpers\Html::a( '<span class="fa fa-pencil"></span>', $url,
                                        [
                                            'title' => Yii::t('yii', 'Update'), 
                                            'class'=>'btn btn-xs btn-success btn-edit',
                                            'data-pjax'=>"0",
                                            'role'=>"modal-remote",
                                            'data-toggle'=>"tooltip",
                                            'data-original-title'=>"Update",
                                            'style'=> 'height: 22px;'
                                        ]);
            },
            'delete'=>function ($url, $model) {
                return \yii\helpers\Html::a( '<span class="fa fa-trash"></span>', $url,
                                        [
                                            'title' => Yii::t('yii', 'Delete'), 
                                            'class'=>'btn btn-xs btn-warning btn-delete',
                                            'data-pjax'=>"0",
                                            'role'=>"modal-remote",
                                            'data-toggle'=>"tooltip",
                                            'data-original-title'=>"Delete",
                                            'data-pjax-container'=>"crud-datatable-pjax",
                                            'data-request-method'=>"post",
                                            'data-confirm-title'=>"Are you sure?", 
                                            'data-confirm-message'=>"Are you sure want to delete this item", 
                                            'data-original-title'=>"Delete",
                                            'style'=> 'height: 22px;'
                                        ]);
            }
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