<?php

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserInfo */
$this->title = 'View User Info';
$this->params['breadcrumbs'][] = ['label' => 'User Info' , 'url' => ['/admin/user-info']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-info-view">
<?php 
    $attributes = [
            [
                'attribute' => 'visa_status',
                'valueColOptions'=>['style'=>'width:60%'],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'category_id',
                        'valueColOptions'=>['style'=>'width:20%'],
                        'value'=> $model->category ? $model->category->name : null,
                    ],
                    [
                        'attribute' => 'gender',
                        'valueColOptions'=>['style'=>'width:20%'],
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'name',
                        'valueColOptions'=>['style'=>'width:20%'],
                    ],
                    [
                        'attribute' => 'last_name',
                        'valueColOptions'=>['style'=>'width:20%'],
                    ],
                ],
            ],
        [
            'columns' => [
                    [
                        'attribute' => 'birth',
                        'valueColOptions'=>['style'=>'width:20%'],
                    ],
                    [                      
                        'attribute' => 'phone',
                        'valueColOptions'=>['style'=>'width:20%'],
                        'value' => "+{$model->prepend_phone}{$model->phone}",
                    ],
            ]
        ],
        [
            'columns' => [
                [
                    'attribute' => 'height',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [
                    'attribute' => 'weight',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],      
        [
            'columns' => [
                [                      
                    'attribute' => 'phone2',
                    'value' => "+{$model->prepend_phone2}{$model->phone2}",
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [
                    'attribute' => 'address',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ], 
        [
            'columns' => [
                [                      
                    'attribute' => 'nationality',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [
                    'attribute' => 'country',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],
        [
            'columns' => [
                [         
                    'label' => 'City',
                    'format' => 'html',
                    'value' => function ($view, $detalView){
                        $city = '';
                        if($detalView->model['city']){
                            $city = '<ul>';
                            foreach ($detalView->model['city'] as $value) {
                                $city  .= "<li>".ucfirst($value)."</li>";
                            }
                            $city .="</ul>";
                        };
                        return $city;
                    },
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [         
                    'label' => 'language',
                    'format' => 'html',
                    'value' => function ($view, $detalView){
                        $language = '';
                        if($detalView->model['language']){
                            $language = '<ul>';
                            foreach ($detalView->model['language'] as $value) {
                                $language  .= "<li>".ucfirst($value)."</li>";
                            }
                            $language .="</ul>";
                        };
                        return $language;
                    },
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],  
        [
            'columns' => [
                [         
                    'attribute' => 'collar',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [         
                    'attribute' => 'chest',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],
        [
            'columns' => [
                [         
                    'attribute' => 'waist',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [         
                    'attribute' => 'hips',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],
        [
            'columns' => [
                [         
                    'attribute' => 'shoe',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [         
                    'attribute' => 'suit',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],
        [
            'columns' => [
                [         
                    'attribute' => 'pant',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [         
                    'attribute' => 'hair',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],
        [
            'columns' => [
                [         
                    'attribute' => 'hair_length',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [         
                    'attribute' => 'eye',
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],
        [
            'columns' => [
                [         
                    'label' => 'Ethnicity',
                    'format' => 'html',
                    'value' => function ($view, $detalView){
                        $ethnicity = '';
                        if($detalView->model['ethnicity']){
                            $ethnicity = '<ul>';
                            foreach ($detalView->model['ethnicity'] as $value) {
                                $ethnicity  .= "<li>".ucfirst($value)."</li>";
                            }
                            $ethnicity .="</ul>";
                        };
                        return $ethnicity;
                    },
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
                [         
                    'label' => 'specialization',
                    'format' => 'html',
                    'value' => function ($view, $detalView){
                        $specialization = '';
                        if($detalView->model['specialization']){
                            $specialization = '<ul>';
                            foreach ($detalView->model['specialization'] as $value) {
                                $specialization  .= "<li>".ucfirst($value)."</li>";
                            }
                            $specialization .="</ul>";
                        };
                        return $specialization;
                    },
                    'valueColOptions'=>['style'=>'width:20%'],
                ],
            ]
        ],
    ];
?>
    
    
<?= DetailView::widget([
    'model' => $model,
    'attributes' => $attributes,
    'mode' => 'view',
//    'bordered' => $bordered,
//    'striped' => $striped,
//    'condensed' => $condensed,
//    'responsive' => $responsive,
//    'hover' => $hover,
//    'hAlign'=>$hAlign,
//    'vAlign'=>$vAlign,
//    'fadeDelay'=>$fadeDelay,
    'deleteOptions'=>[ // your ajax delete parameters
        'params' => ['id' => 1000, 'kvdelete'=>true],
    ],
    'container' => ['id'=>'kv-demo'],
]);
    
?>



</div>
