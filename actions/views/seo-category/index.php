<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\DivaMediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Diva Media';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="diva-media-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
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
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create-media', 'target_id'=>$category_id, 'type'=>$type],
                    ['role'=>'modal-remote','title'=> 'Create new Diva Media','class'=>'btn btn-default']).
                    
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''],
                    ['data-pjax'=>1, 'class'=>'btn btn-default', 'title'=>'Reset Grid']).
                     
                    Html::a('<div class="property-sider btn-group">Content</div>', ['/admin/diva/update', 'id'=>$category_id, 'type'=>$type],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default']).
                    
                    Html::a('<div class="property-sider btn-group">SEO</div>', ['/admin/seo/update', 'target_id'=>$category_id, 'type'=>$type],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default']).
                    
                     Html::a('<i class="fa fa-eye"></i>', ["/{$type}"],
                    ['data-pjax'=>0, "target"=>"_blank", 'title'=> 'Create new Diva Media','class'=>'btn btn-default'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Diva Media listing',
                'after'=>'<div class="clearfix"></div>',
            ]
        ])?>
    </div>
</div>
<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>
