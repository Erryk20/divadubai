<?php
use yii\helpers\Url;
use yii\bootstrap\Html;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'checkboxOptions' => function($model, $key, $index, $column) {
            $bool = in_array($model->id,  explode(',', \Yii::$app->request->get('checked', '')));
            return ['checked' => $bool];
        },
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
        'attribute'=>'category_id',
        'vAlign'=>'middle',
        'value'=>function($model){
            return $model->category;
        },
        'filter'=>\app\models\ModelCategory::listCategoriesForCasting()
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_at',
        'vAlign'=>'middle',
        'value'=>function($model){
            return $model->created_at ? date('Y-m-d H:i', $model->created_at) : null;
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'casting_name',
        'filter'=> app\models\CastingUser::getListCastings(),
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'kartik\grid\BooleanColumn',
        'attribute'=>'viewed', 
        'vAlign'=>'middle',
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
                return Html::a( '<span class="fa fa-pencil"></span>', $url,
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
                return $model->info_user_id ? Html::a('<span class="fa fa-user"></span>', 
                    ['profile', 'id'=>$model->info_user_id],
                    [
                        'title'=>"Profile",
                        'data-pjax'=>"0",
                        'class'=>'btn btn-xs btn-info btn-detail',
                        'data-original-title'=>"Profile",
                        'style'=> 'height: 22px;',
                    ]) : null;
            },
            'delete'=>function ($url, $model) {
                return Html::a( '<span class="fa fa-trash"></span>', $url,
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