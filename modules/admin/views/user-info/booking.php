<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UserInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Info';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>

<div class="user-info-index">
    <?= $this->render('@app/modules/admin/views/blocks/fillter-admin', ['filter' => $filter]) ?>

    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'pager' => [
                'class' => 'app\components\PagerCostomer',
            ],
            'floatHeaderOptions'=>['scrollingTop'=>'50'],
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar'=> [
                ['content'=>
                    Html::a('<i class="fa fa-envelope-o" aria-hidden="true"></i>', ['sent-mail', 'checked'=>Yii::$app->request->get('checked')],
                    ['role'=>'modal-remote','title'=> 'Send Email','class'=>'btn btn-default add-checked']).
                    
                    Html::a('Theme for email', ['/admin/email-theme/booking', 'id'=>5],
                    ['title'=> 'Theme for email','class'=>'btn btn-default', 'role'=>'modal-remote'])
                    
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
    'options' => [
        'tabindex' => false, // important for Select2 to work properly 
    ],
])?>
<?php Modal::end(); ?>
