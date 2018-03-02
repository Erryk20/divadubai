<?php 
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\helpers\Html;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\BulkButtonWidget;

$this->title = $model->title;

?>

<?php $form = ActiveForm::begin(['options'=>['style'=>'position: relative;']]); ?>
<div style = 'position: absolute;top: -44px; right: 0;'>
    <?= 
        Html::a('<div class="property-sider btn-group">Title</div>', ['/admin/diva/update', 'id'=>1],
        ['role'=>'modal-remote','title'=> 'Update title','class'=>'btn btn-default']);
    ?>
    
    <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    <!--<?hph = Html::submitButton('Update', ['class' => 'btn btn-success']) ?>-->
    
</div>

<div class="view_category view_events view_production" style="margin-top: 10px;">
        <div class="view_header clearfix">
            <?= $form->field($model, 'block_1')->widget(Widget::className(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 100,
                    'plugins' => [
                        'clips',
                        'fullscreen'
                    ]
                ]
            ])->label(false);

            ?>
            <div class="col col-sm-5">
                 <?= $form->field($model, 'block_2')->widget(Widget::className(), [
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 100,
                            'plugins' => [
                                'clips',
                                'fullscreen'
                            ]
                        ]
                    ])->label(false);
                ?>
            </div>
            <div class="col col-sm-6 col-sm-offset-1 main_text">
                     <?= $form->field($model, 'block_3')->widget(Widget::className(), [
                            'settings' => [
                                'lang' => 'ru',
                                'minHeight' => 100,
                                'plugins' => [
                                    'clips',
                                    'fullscreen'
                                ]
                            ]
                        ])->label(false);
                    ?>
            </div>
        </div>
        <div class="view_content">
             <?= $form->field($model, 'block_4')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 100,
                        'plugins' => [
                            'clips',
                            'fullscreen'
                        ]
                    ]
                ])->label(false);
            ?>
            
            
            
            
            
            <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-sortable-id' => $model->id];
            },
            'options' => [
                'data' => [
                    'sortable-widget' => 1,
                    'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
                ]
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Contacts Infos','class'=>'btn btn-default']).
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    
                    Html::a('<div class="property-sider btn-group">Title</div>', ['title', 'id'=>1],
                    ['role'=>'modal-remote','title'=> 'Update title','class'=>'btn btn-default']).
                    
                    Html::a('<div class="property-sider btn-group">Content</div>', ['/admin/content/update', 'target_id'=>1, 'type'=>'contact'],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default']).
                    
                    Html::a('<div class="property-sider btn-group">SEO</div>', ['/admin/seo/update', 'target_id'=>1, 'type'=>'contact'],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Contacts Infos listing',
                'after'=>BulkButtonWidget::widget([
                            'buttons'=>Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All',
                                ["bulkdelete"] ,
                                [
                                    "class"=>"btn btn-danger btn-xs",
                                    'role'=>'modal-remote-bulk',
                                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                                    'data-request-method'=>'post',
                                    'data-confirm-title'=>'Are you sure?',
                                    'data-confirm-message'=>'Are you sure want to delete this item',
                                    'style'=> 'height: 22px;',
                                ]),
                        ]).                        
                        '<div class="clearfix"></div>',
            ]
        ])?>
            
            
            <div class="row">
                
                
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="/images/production_1.png" alt=""></a></div>
                    <div class="title"><a href="#">Photography</a></div>
                </div>
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="/images/production_2.png" alt=""></a></div>
                    <div class="title"><a href="#">Directors</a></div>
                </div>
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="/images/production_3.png" alt=""></a></div>
                    <div class="title"><a href="#">Locations</a></div>
                </div>
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="../images/production_4.png" alt=""></a></div>
                    <div class="title"><a href="#">Stylists</a></div>
                </div>
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="../images/production_5.png" alt=""></a></div>
                    <div class="title"><a href="#">Post Production</a></div>
                </div>
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="../images/production_6.png" alt=""></a></div>
                    <div class="title"><a href="#">Cast</a></div>
                </div>
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="../images/production_7.png" alt=""></a></div>
                    <div class="title"><a href="#">Permits</a></div>	
                </div>
                <div class="col col-xs-12 col-sm-6 col-md-3">
                    <div class="image"><a href="#"><img src="../images/production_8.png" alt=""></a></div>
                    <div class="title"><a href="#">Production</a></div>
                </div>
            </div>
            <div class="description">
                <?= $form->field($model, 'block_5')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'ru',
                        'minHeight' => 100,
                        'plugins' => [
                            'clips',
                            'fullscreen'
                        ]
                    ]
                    ])->label(false);
                ?>
            </div>
        </div>
    </div>

<?php ActiveForm::end(); ?>
