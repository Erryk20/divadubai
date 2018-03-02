<?php
use yii\helpers\Url;
use kartik\editable\Editable;
use yii\bootstrap\Html;
use app\models\User;
use kartik\switchinput\SwitchInput;



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
    [
        'class' => kartik\grid\EditableColumn::className(),
        'attribute' => 'categories_key',
        'width' => '150px',
        'format' => 'raw',
        'value' => function($model){
            return  $model->getHtmlCategories();
        },
        'vAlign' => 'middle',
        'filter' => \app\models\ModelCategory::liatAll(),
                
        'editableOptions' => function ($model, $key, $index) {
            $key = $model->id;
            $data = \app\models\ModelCategory::liatAll();
            return [
                'name' => 'subcategory',
                'asPopover' => true,
                'header' => 'Subcategory',
                'inputType' => Editable::INPUT_WIDGET,
                'widgetClass'=> 'kartik\select2\Select2',
                'data' => $data, 
                'options' => [
                    'data' => $data,
                    'options' => ['placeholder' => 'Select a Subcategory ...', 'multiple' => true],
                    'pluginOptions' => [
                        'tags' => true,
                    ],
                ],
            ];
        }
    ],   
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'width' => '250px',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'old_id',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'gender',
        'vAlign'=>'middle',
        'format'=>'raw',
        'filter'=> app\models\UserInfo::itemAlias('gender'),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'birth',
        'label'=>'Age',
        'filter'=> false,
        'width' => '120px',
        'value'=>function ($model){
            return (date('Y', time()) - (int)date('Y',$model->age));
        },
        'vAlign'=>'middle',
        'filter' => \app\models\UserInfo::itemAliasChildren(),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'height',
        'filter'=> false,
        'width' => '120px',
        'vAlign'=>'middle',
        'filter' => \app\models\UserInfo::itemAlias('height-gorup'),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'waist',
        'filter'=> false,
        'width' => '120px',
        'vAlign'=>'middle',
        'filter' => \app\models\UserInfo::itemAlias('waist-gorup'),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'hips',
        'filter'=> false,
        'width' => '120px',
        'vAlign'=>'middle',
        'filter' => \app\models\UserInfo::itemAlias('hips-gorup'),
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'shoe',
        'filter'=> false,
        'width' => '120px',
        'vAlign'=>'middle',
        'filter' => \app\models\UserInfo::itemAlias('shoe-group'),
    ],
                
                
//    [
//        'class' => kartik\grid\EditableColumn::className(),
//        'attribute' => 'categories',
//        'width' => '150px',
//        'format' => 'raw',
//        'value' => function($model){
//            return !empty($model->categories) ? implode(", </br>", $model->categories) : null;
//        },
//        'vAlign' => 'middle',
//        'filter' => app\models\UserInfo::itemAdminAliasType(),
                
//        
//    ],
                
                
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'last_name',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'phone',
        'value'=>function($model){
           return $model->phone ? "+$model->prepend_phone"."$model->phone" : null;
        },
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nationality',
        'value'=>function($model){
           return $model->nationality ? $model->nationality : null;
        },
        'vAlign'=>'middle',
    ],
//    [
//        'class' => kartik\grid\EditableColumn::className(),
//        'options' => ['style' => 'width: 120px'],
//        'attribute'=>'status',
//        'vAlign'=>'middle',
//        'filter'=> app\models\UserInfo::itemAlias('status'),
//        'editableOptions' => function ($model, $key, $index) {
//            return [
//                'name'=>'status', 
//                'value' => 0,
//                'asPopover' => true,
//                'header' => 'Status',
//                'inputType' => Editable::INPUT_DROPDOWN_LIST,
//                'data' => app\models\UserInfo::itemAlias('status'),
//                'options' => ['class'=>'form-control', 'prompt'=>'Select role...'],
//                'displayValueConfig'=> [
//                    '-1' => 'Deleted',
//                    '1' => 'Registration',
//                    '0' => 'Modernize',
//                ],
//            ];
//        }
//    ],
                
    [
        'attribute' => 'active',
        'format' => 'raw',
        'vAlign'=>'middle',
        'width' => '100px',
        'filter'=> [
                    "1"=>'Active',
                    "0"=>'Inactive',
                ],
        'value' => function ($model) {
            return SwitchInput::widget([
                        'name' => 'active',
                        'id' => $model->active . $model->id,
                        'value' => ($model->active),
                        'options'=>['data-uid'=>$model->id],
                        'pluginEvents' => [
                            "switchChange.bootstrapSwitch" => "function() {
                                var id = $(this).attr('data-uid'); 
                                $.ajax({
                                    type: 'GET',
                                    url: '/admin/model-event/active',
                                    data: {id:id},
                                });
                            }",
                        ],
                        'pluginOptions' => [
                            'size' => 'mini',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'onText' => 'on',
                            'offText' => 'off',
                        ]
            ]);
        },
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'logo',
        'format' => 'raw',
        'vAlign' => 'middle',
        'value' => function($model){
            $src = $model->logo ? $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/user-media/{$model->logo}"), 'width' => 100, 'height' => 70]): null;
            return "<a data-pjax='0' target='_blank' href='". Url::toRoute(['/site/profile', 'id'=>$model['id']])."'>".(Html::img($src))."</a>" ;
        },
        'filter'=>false
    ],
    [
        'attribute' => 'availability',
        'format' => 'raw',
        'vAlign'=>'middle',
        'width' => '100px',
        'filter'=> User::getAvailability(),
        'value' => function ($model) {
            $result = "<ul class='userinfo-availability'>";
            foreach (User::getAvailability() as $key => $value) {
                $active = ($key == $model->availability) ? 'active' : null;
                $result .= "<li class='color-{$key} $active'></li>";
            }
            $result .= "</ul>";
            return $result;
        },
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '120px',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{user} {delete}', //{view}
        'buttons'=>[
            'view'=>function ($url, $model) {
                return \yii\helpers\Html::a( '<span class="fa fa-eye"></span>', $url,
                                        [
                                            'title' => Yii::t('yii', 'View'),
                                            'class'=>'btn btn-xs btn-primary btn-detail',
                                            'data-pjax'=>"0",
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
                                            'data-original-title'=>"Update",
                                            'style'=> 'height: 22px;'
                                        ]);
            },
            'upload'=>function ($url, $model) {
                return \yii\helpers\Html::a( '<span class="fa fa-upload"></span>', ["/admin/user-media", 'info_user_id'=>$model->id],
                                        [
                                            'title' => Yii::t('yii', 'Upload'), 
                                            'class'=>'btn btn-xs btn-success btn-edit',
                                            'data-pjax'=>"0",
                                            'data-original-title'=>"Upload",
                                            'style'=> 'height: 22px;'
                                        ]);
            },
            'user' => function ($url, $model) {
                return $model->id ? Html::a('<span class="fa fa-user"></span>', 
                    ['profile', 'id'=>$model->id],
                    [
                        'title'=>"Profile",
                        'data-pjax'=>"0",
                        'class'=>'btn btn-xs btn-info btn-detail',
                        'data-original-title'=>"Profile",
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