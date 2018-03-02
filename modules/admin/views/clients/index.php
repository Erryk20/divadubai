<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\AwardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Awards';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="awards-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-sortable-id' => $model->id];
            }, 
            'options' => [
                'data' => [
                    'sortable-widget' => 1,
                    'sortable-url' => Url::toRoute(['sorting']),
                ]
             ],
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'],
                    ['role'=>'modal-remote','title'=> 'Create new Awards','class'=>'btn btn-default']).
                    
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                    
                    Html::a('<div class="property-sider btn-group">Title</div>', ['title'],
                    ['role'=>'modal-remote','title'=> 'Update title','class'=>'btn btn-default']).
                    
                    Html::a('<div class="property-sider btn-group">SEO</div>', ['/admin/seo/update', 'target_id'=>1, 'type'=>'clients'],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default'])
                    
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Awards listing',
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
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
