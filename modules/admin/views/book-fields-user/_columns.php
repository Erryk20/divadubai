<?php
use yii\helpers\Url;
use kartik\editable\Editable;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'checkboxOptions' => function($model, $key, $index, $column) {
            $bool = in_array($model['id'],  explode(',', \Yii::$app->request->get('checked', '')));
            return ['checked' => $bool, 'value'=>$model['id']];
        },
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'book',
        'filter'=> app\models\Book::getBooksId(),
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
        'label'=>'Email',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'label'=>'Name',
    ],
//    [
//        'class' => kartik\grid\EditableColumn::className(),
//        'options' => ['style' => 'width: 120px'],
//        'attribute'=>'viewed',
//        'vAlign'=>'middle',
//        'filter'=> ['0'=>'Inactive', '1'=>'Active'],
//        'editableOptions' => function ($model, $key, $index) {
//            return [
//                'ajaxSettings' => [
//                    'url'=>  Url::toRoute(['', 'id'=>$model['id']])
//                ],
//                'name'=>'status', 
//                'value' => $model['viewed'],
//                'asPopover' => true,
//                'header' => 'Status',
//                'inputType' => Editable::INPUT_DROPDOWN_LIST,
//                'data' => ['0'=>'Inactive', '1'=>'Active'],
//                'options' => ['class'=>'form-control', 'prompt'=>'Select type'],
//                'displayValueConfig'=> [
//                    '0' => '<i class="fa fa-ban"></i> Inactive',
//                    '1' => '<i class="fa fa-trophy"></i> Active',
//                ],
//            ];
//        }
//    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$model['id_field']]);
        },
        'template' => '{view} {delete}',
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