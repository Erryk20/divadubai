<?php

use kartik\detail\DetailView;
use kartik\helpers\Html;
use app\models\UserInfo;

/* @var $this yii\web\View */
/* @var $model app\models\UserInfo */
$this->title = 'View User Info';
$this->params['breadcrumbs'][] = ['label' => 'User Info' , 'url' => ['/admin/user-info']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
    #w1 {
        margin-bottom: 0px;
    }
</style>

<div class="user-info-view">
<?php 
    $attributes = [
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
                        'attribute' => 'gender',
                        'valueColOptions'=>['style'=>'width:20%'],
                        'value'=> UserInfo::itemAlias('gender', $model->gender)
                    ],
                    [                      
                        'attribute' => 'visa_status',
                        'valueColOptions'=>['style'=>'width:20%'],
                        'value'=> UserInfo::itemAlias('visa_status', $model->visa_status),
                    ],
            ]
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
                                if($value != '')
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
    
    <?php 
    
//vd($attributes);
    ?>
    
    <table style="width: 100%;">
        <tr>
            <td style="width: 66%;">
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
            </td>
            <td style="background-image:url(<?= "/images/user-media/{$model->logo}"?>); background-size: contain; background-repeat:no-repeat;">
                <?php // = Html::img("/images/user-media/{$model->logo}") ?>
            </td>
        </tr>
    </table>
   
    
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12 form-group">
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <?php // = $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/user-media/{$model->logo}"), 'width' => 370, 'height' => 540]); ?>
        </div>
    </div>
    



</div>
