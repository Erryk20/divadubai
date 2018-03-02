<?php
use yii\helpers\Url;
use kartik\grid\EditableColumn; 
use kartik\editable\Editable;

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
        'class' => \kotchuprik\sortable\grid\Column::className(),
        'contentOptions' => ['style' => 'vertical-align: middle;'],
        'visible'=> ($get['divaTitle'] != '' && $get['divaTitle'] != '0')
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
        'attribute'=>'gender',
        'vAlign'=>'middle',
        'filter'=> app\models\UserInfo::itemAlias('gender'),
        'value'=>function($model){
            return ucfirst($model->gender);
        },
    ],
     [
         'class'=>'\kartik\grid\DataColumn',
         'attribute'=>'phone',
     ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'address',
    // ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'nationality',
            'vAlign'=>'middle',

        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'country',
            'vAlign'=>'middle',

        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'city',
            'vAlign'=>'middle',

            'format'=>'html',
            'value'=>function ($model){
                $city = '';
                if ($model->city) {
                    $city = '<ul>';
                    foreach ($model->city as $value) {
                        $city .= "<li>" . ucfirst($value) . "</li>";
                    }
                    $city .= "</ul>";
                };
                return $city;
            },
        ],
        [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'ethnicity',
            'format'=>'html',
            'vAlign'=>'middle',
            'value'=>function ($model){
                $ethnicity = '';
                if ($model->ethnicity) {
                    $ethnicity = '<ul>';
                    foreach ($model->ethnicity as $value) {
                        $ethnicity .= "<li>" . ucfirst($value) . "</li>";
                    }
                    $ethnicity .= "</ul>";
                };
                return $ethnicity;
            },
        ],
        [
        'class' => kartik\grid\EditableColumn::className(),
        'label' => 'Servises',
        'attribute' => 'servCatName',
        'vAlign' => 'middle',
        'filter' => app\models\ServiceCategories::getList(false),
        'editableOptions' => function ($model, $key, $index) {
            $key = $model->id;
            return [
                'name' => 'divaTitle',
                'value' => $model['divaTitle'],
                'asPopover' => true,
                'header' => 'Secrvice Category',
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => app\models\ServiceCategories::getList(true),
                'options' => [
                    'class' => 'form-control', 
                    'prompt' => 'Select Service...',
                    'name'=>'service_cat_id',
                ],
            ];
        }],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'weight',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'collar',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'chest',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'waist',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'hips',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'shoe',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'suit',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'pant',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'hair',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'hair_length',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'eye',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'language',
    // ],
//     [
//         'class'=>'\kartik\grid\DataColumn',
//         'attribute'=>'visa_status',
//        'vAlign'=>'middle',
//
//     ],
//        [
//            'class'=>'\kartik\grid\DataColumn',
//            'attribute'=>'specialization',
//        ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'width' => '120px',
        'urlCreator' => function($action, $model, $key, $index) { 
            return Url::to([$action,'id'=>$key]);
        },
        'template' => '{view} {upload}',
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