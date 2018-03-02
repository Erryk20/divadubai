<?php
use yii\helpers\Url;
use app\models\Categories;
use kartik\grid\GridView;
use kartik\select2\Select2;
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
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'parent_id',
        'value'=>function($model){
            return $model->parent_id ? $model->parent->name : null;
        },

        'filterType'=>GridView::FILTER_SELECT2,
        'filterInputOptions'=>['placeholder'=>  Yii::t('app', 'Search...')],
        'filterWidgetOptions'=>[
            'initValueText' =>function($model){
                return $model->parent_id ? $model->parent->name : null;
            },
            'data' => Categories::getCategoriesId(),
            'theme' => Select2::THEME_BOOTSTRAP,
            'pluginOptions' => [
                'hideSearch' => false,
                'allowClear' => true,
            ],
        ],
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'contentOptions' => ['style' => 'vertical-align: middle;']
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'url',
        'contentOptions' => ['style' => 'vertical-align: middle;']
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
            return $model->img ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/{$model->src}"), 'width' => 100, 'height' => 50]): null;
        },
        'filter'=>false
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'width' => '120px',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{cont} {seo} {update} {delete}',
        'buttons'=>[
            'seo' => function ($url, $model) {
                return Html::a('<span class="fa fa-line-chart"></span>', 
                    [
                        "/admin/seo/update", 
                        'target_id'=>$model->id, 
                        'type'=>'SEO'
                    ] , 
                    [
                        'title'=>"SEO",
                        'data-pjax'=>"0",
                        'class'=>'btn btn-xs btn-info btn-detail',
                        'role'=>"modal-remote",
                        'data-toggle'=>"tooltip",
                        'data-original-title'=>"SEO",
                        'style'=> 'height: 22px;',
                    ]);
            },
            'cont' => function ($url, $model) {
                return Html::a('<span class="fa fa-bars"></span>', 
                    [
                        "/admin/content/update", 
                        'target_id'=>$model->id, 
                        'type'=>'contact'
                    ] , 
                    [
                        'title'=>"Add Content",
                        'data-pjax'=>"0",
                        'class'=>'btn btn-xs btn-info btn-detail',
                        'role'=>"modal-remote",
                        'data-toggle'=>"tooltip",
                        'data-original-title'=>"View",
                        'style'=> 'height: 22px;',
                    ]);
            },
//            'view'=>function ($url, $model) {
//                return \yii\helpers\Html::a( '<span class="fa fa-eye"></span>', $url,
//                                        [
//                                            'title' => Yii::t('yii', 'View'),
//                                            'class'=>'btn btn-xs btn-primary btn-detail',
//                                            'data-pjax'=>"0",
//                                            'role'=>"modal-remote",
//                                            'data-toggle'=>"tooltip",
//                                            'data-original-title'=>"View",
//                                            'style'=> 'height: 22px;',
//                                        ]);
//            },
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
//        'buttons' => [
//            'cont' => function ($url, $model) {
//                return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', 
//                    [
//                        "/admin/content/cont", 
//                        'id'=>$model->id, 
//                        'table'=>'category'
//                    ] , 
//                    [
//                        'title'=>"add content",
//                        'data-pjax'=>"0",
//                        'role'=>"modal-remote",
//    //                    'data-toggle' =>"tooltip"
//                    ]);
//            },
//        ],
                
                
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
