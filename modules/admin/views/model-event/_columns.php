<?php
use yii\helpers\Url;
use kartik\editable\Editable;
use kartik\switchinput\SwitchInput;

$get = Yii::$app->request->get('DivaUserSearch');
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
        'attribute'=>'id',
        'vAlign'=>'middle',
    ],
    
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'vAlign'=>'middle',
        'format'=>'raw',
        'value'=>function ($model){
            return \app\models\UserInfo::htmlCategories($model->type);
        },
        'filter' => \app\models\ModelCategory::liatCategoryGroup(7),
    ],
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
        'attribute'=>'birth',
        'label'=>'Age',
        'filter'=> false,
        'width' => '120px',
        'value'=>function ($model){
            return (date('Y', time()) - (int)date('Y',$model->age)).' {'.date('Y-m-d',$model->age).'}';
        },
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
        'filter'=> \app\models\Countries::getNationalities(),
                
    ],
    [
        'class' => kartik\grid\EditableColumn::className(),
        'attribute' => 'subcategory_key',
        'width' => '150px',
        'format' => 'raw',
        'value' => function($model){
            return $model->getSubcategory();
        },
        'vAlign' => 'middle',
        'filter' => app\models\ModelSubcategory::listSubcategoryGroup(7),
        'editableOptions' => function ($model, $key, $index) {
            $key = $model->id;
            $data = app\models\ModelSubcategory::listSubcategoryGroup(7);
            return [
                'formOptions' => ['action' => ['/admin/promotions-activations', 'categories'=> \app\models\ModelCategory::getListIdCategoriesForCategory(7)] ],
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
        'format' => 'html',
        'vAlign'=>'middle',
        'value' => function($model){
            return $model->logo ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/user-media/{$model->logo}"), 'width' => 100, 'height' => 70]): null;
        },
        'filter'=>false

    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '120px',
        'urlCreator' => function($action, $model, $key, $index) { 
            return Url::to([$action,'id'=>$key]);
        },
        'template' => '{user}', //{view}
        'buttons'=>[
            'view'=>function ($url, $model) {
                return \yii\helpers\Html::a( '<span class="fa fa-eye"></span>', ['/admin/user-info/view', 'id'=>$model->id],
                                        [
                                            'title' => Yii::t('yii', 'View'),
                                            'class'=>'btn btn-xs btn-primary btn-detail',
                                            'data-pjax'=>"1",
                                            'data-original-title'=>"View",
                                            'style'=> 'height: 22px;',
                                        ]);
            },
            'user' => function ($url, $model) {
                return $model->id ? yii\bootstrap\Html::a('<span class="fa fa-user"></span>', 
                    ['profile', 'id'=>$model->id],
                    [
                        'title'=>"Profile",
                        'data-pjax'=>"0",
                        'class'=>'btn btn-xs btn-info btn-detail',
                        'data-original-title'=>"Profile",
                        'style'=> 'height: 22px;',
                    ]) : null;
            },
            'upload'=>function ($url, $model) {
                return \yii\helpers\Html::a( '<span class="fa fa-upload"></span>', ["/admin/user-media", 'info_user_id'=>$model->id],
                                        [
                                            'title' => Yii::t('yii', 'Upload'), 
                                            'class'=>'btn btn-xs btn-success btn-edit',
                                            'data-pjax'=>"1",
                                            'data-original-title'=>"Upload",
                                            'style'=> 'height: 22px;'
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