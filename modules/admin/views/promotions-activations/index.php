<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Promotions Activations';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="user-info-index">
    <?= $this->render('@app/modules/admin/views/blocks/fillter-admin', ['filter' => $filter]) ?>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-sortable-id' => $model->du_id];
            },
            'options' => [
                'data' => [
                    'sortable-widget' => 1,
                    'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
                ]
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fa fa-envelope-o" aria-hidden="true"></i>', ['/admin/email/send', 'type'=>'user'],
                    ['role'=>'modal-remote','title'=> 'Send Email','class'=>'btn btn-default'])
                ],
            ],         
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'default',
                'heading' => '<i class="glyphicon glyphicon-list"></i> User Infos listing',
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
