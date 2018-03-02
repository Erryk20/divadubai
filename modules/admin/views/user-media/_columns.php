<?php
use yii\helpers\Url;
use demi\cropper\Cropper;
use yii\web\JsExpression;

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
        // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'id',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'type',
        'vAlign'=>'middle',
        'filter'=> app\models\UserMedia::itemAlias('type'),
    ],
    
    [
        'attribute' => 'src',
        'format' => 'html',
        'value' => function($model){
            return $model->src ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/{$model->src}"), 'width' => 40, 'height' => 50]): null;
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
        'template' => '{view} {update} {delete}', //{crop}
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
//            'crop'=>function($url, $model){
//                return Cropper::widget([
//
//
//                    'modal' => true,
//                    'modalView' => '@app/modules/admin/views/user-media/modal',
//                    'cropUrl' => ['cropImage', 'id' => $model->id],
//                    'image' => Yii::$app->request->baseUrl . $model->src,
//                //    'aspectRatio' => 4 / 3, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
//                    'pluginOptions' => [
//                        // All possible options: https://github.com/fengyuanchen/cropper/blob/master/README.md#options
////                        'checkOrientation'=>true,
////                        'zoomable'=>true,
//                        'minCropBoxWidth' => 400, // minimal crop area width
//                        'minCropBoxHeight' => 300, // minimal crop area height
//                    ],
//                    // HTML-options for widget container
//                    'options' => [
//                        'class'=>'btn btn-xs btn-primary btn-detail',
//                        'style'=> 'height: 22px;',
//                        'id'=>'myImage',
//                    ],
//                    // HTML-options for cropper image tag
//                    'imageOptions' => [],
//                    // Additional ajax-options for send crop-request. See jQuery $.ajax() options
//                       'ajaxOptions' => [
//        'success' => new JsExpression(<<<JS
//            function(data) {
//                // data - your JSON response from [[cropUrl]]
//                $("#myImage").attr("src", data.croppedImageSrc);
//            }
//JS
//                ),
//            ],
//            ]);
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