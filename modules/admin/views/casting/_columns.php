<?php
use yii\helpers\Url;
use yii\bootstrap\Html;

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
        'class' => \kotchuprik\sortable\grid\Column::className(),
        'contentOptions' => ['style' => 'vertical-align: middle;'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'category_id',
        'vAlign'=>'middle',
        'value'=>function($model){
            return $model->category;
        },
        'filter'=>\app\models\ModelCategory::listCategoriesForCasting()
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'title',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gender',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'fee',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'casting_date',
        'vAlign'=>'middle',
        'value'=>function($model){
            return $model->casting_date;
        },
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'time_from',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'time_to',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'job_date',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'location',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'booker_name',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'bookers_number',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'details',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'order',
    // ],
    [
        'attribute' => 'src',
        'format' => 'html',
        'value' => function($model){
            return $model->src ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/casting/{$model->src}"), 'width' => 200, 'height' => 100]): null;
        },
        'filter'=>false
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view} {update} {user} {delete}',

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
            'user' => function ($url, $model) {
                return $model->id ? Html::a('<span class="fa fa-user"></span>', 
                    ['/admin/casting-user', 'CastingUserSearch[casting_name]'=>$model->id],
                    [
                        'title'=>"Job Application",
                        'data-pjax'=>"0",
                        'class'=>'btn btn-xs btn-info btn-detail',
                        'data-original-title'=>"Job Application",
                        'style'=> 'height: 22px;',
                    ]) : null;
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