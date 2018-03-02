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
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'updated_at',
        'vAlign'=>'middle',
        'filter'=>false,
        'value'=>function($model){
            return  Yii::$app->formatter->asDate($model->updated_at);
        }
     ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'username',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
        'vAlign'=>'middle',
    ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'category_id',
//        'filter'=>false,
//        'vAlign'=>'middle',
//    ],
//    [
//        'class' => kartik\grid\EditableColumn::className(),
//        'options' => ['style' => 'width: 120px'],
//        'attribute'=>'type',
//        'vAlign'=>'middle',
//        'filter'=> app\models\UserInfo::itemAlias('type'),
//        'editableOptions' => function ($model, $key, $index) {
//            return [
//                'formOptions' => ['action' => ['/admin/user-info']],
//                'name'=>'status', 
//                'value' => 0,
//                'asPopover' => true,
//                'header' => 'Status',
//                'inputType' => Editable::INPUT_DROPDOWN_LIST,
//                'data' => app\models\UserInfo::itemAlias('type'),
//                'options' => ['class'=>'form-control', 'prompt'=>'Select type...'],
//                'displayValueConfig'=> [
//                    'female'=> 'Female',
//                    'male'  => 'Male',
//                    'boy'   => 'Boy',
//                    'girl'  => 'Girl',
//                ],
//            ];
//        }
//    ],
    [
        'class' => kartik\grid\EditableColumn::className(),
        'options' => ['style' => 'width: 120px'],
        'attribute'=>'status',
        'vAlign'=>'middle',
        'filter'=> app\models\User::itemAlias('status'),
        'editableOptions' => function ($model, $key, $index) {
            return [
                'name'=>'status', 
                'value' => 0,
                'asPopover' => true,
                'header' => 'Status',
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => app\models\User::itemAlias('status'),
                'options' => ['class'=>'form-control', 'prompt'=>'Select role...'],
                'displayValueConfig'=> [
                    '0' => '<i class="fa fa-ban"></i> Deleted',
                    '5' => '<i class="fa fa-cogs"></i> Moderation',
                    '10' => '<i class="fa fa-trophy"></i> Active',
                ],
            ];
        }
    ],
    [
        'class' => kartik\grid\EditableColumn::className(),
        'options' => ['style' => 'width: 100px'],
        'attribute'=>'role',
        'label'=>'Access',
        'vAlign'=>'middle',
        'filter'=> app\models\User::itemAlias('role'),
        'editableOptions' => function ($model, $key, $index) {
            return [
                'name'=>'role', 
                'value' => 0,
                'asPopover' => true,
                'header' => 'Role',
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => app\models\User::itemAlias('role'),
                'options' => ['class'=>'form-control', 'prompt'=>'Select access...'],
                'displayValueConfig'=> [
                    'user' => '<i class="fa fa-user"></i> Standard User',
                    'admin' => '<i class="fa fa-user-md"></i> Super User',
                    'limited' => '<i class="fa fa-user-times"></i> Limited User',
                ],
            ];
        }
    ],
//    [
//        'attribute' => 'logo',
//        'format' => 'html',
//        'value' => function($model){
//            return $model->logo ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/users/{$model->logo}"), 'width' => 50, 'height' => 60]): null;
//        },
//        'filter'=>false
//    ],
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
                
//        'template' => '{view} {update} {delete}',
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