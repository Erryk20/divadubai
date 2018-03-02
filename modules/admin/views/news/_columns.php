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
        'class' => \kotchuprik\sortable\grid\Column::className(),
    ],
//    [
//        'class' => 'kartik\grid\SerialColumn',
//        'width' => '30px',
//    ],
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
//    [
//        'class'=>'\kartik\grid\DataColumn',
//        'attribute'=>'parent_id',
//    ],
    'updated_at:date',
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'language',
        'value'=>  function ($model){
            return $model->language;
        },
        'options'=>['width'=>'120px;'],
        'filter'=> app\models\Language::getLanguageShort(),
    ],
    'category',
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'url',
        'format'=>'raw',
        'value'=>  function ($model){
            return Html::a($model->url, "/{$model->url}", ['target'=>"_blank"]);
        },
        
    ],
    [
        'class' => kartik\grid\EditableColumn::className(),
        'options' => ['style' => 'width: 120px'],
        'attribute'=>'published',
        'filter'=> app\models\Pages::itemAlias('published'),
        'editableOptions' => function ($model, $key, $index) {
            return [
                'name'=>'published', 
                'value' => 1,
                'asPopover' => true,
                'header' => 'Published',
                'inputType' => Editable::INPUT_DROPDOWN_LIST,
                'data' => app\models\Pages::itemAlias('published'),
                'options' => ['class'=>'form-control', 'prompt'=>'Select ...'],
                'displayValueConfig'=> [
                    '0' => '<i class="fa fa-ban"></i> '. Yii::t('app', 'Inactive'),
                    '1' => '<i class="fa fa-trophy"></i> '.  Yii::t('app', 'Active'),
                ],
            ];
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template'=>'{update}{delete}',
        'dropdown' => false,
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'template' => '{update} {seo} {delete}',
        'buttons' => [
            'seo' => function ($url, $model) {
                return Html::a('<span class="btn-info seo">SEO</span>', $url.'&name='.$model->name, [
                    'title'=>"add & update SEO",
                    'data-pjax'=>"0",
                    'role'=>"modal-remote",
//                    'data-toggle' =>"tooltip"
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