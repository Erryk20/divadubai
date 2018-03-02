<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Upload;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\UploadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Uploads');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
<?php // Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'toolbar'=> [
            ['content'=>
                "<p>".Html::a(Yii::t('app', 'Create Upload'), ['create'], ['class' => 'btn btn-success'])."</p>"
            ],
        ], 
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'panel' => [
            'type' => 'primary',
            'heading' => '<i class="glyphicon glyphicon-list"></i> Videos listing',
            'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_vimeo',
            [
                'attribute'=>'status',
                'value'=>function($model){
                    return Upload::itemAlias('status', $model->status);
                },
                'filter'=> Upload::itemAlias('status')
            ],
            'name',
            'description:ntext',
            [
                'attribute' => 'preview',
                'value' => function ($model) {
                    return $model->preview ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/upload/$model->preview"), 'width' => 200, 'height' => 100]): null;
                },
                'format' =>'html',
                'filter' => false
            ],
            // 'duration',
            // 'stream',
            // 'created_time',
            // 'created_at',
            // 'updated_at',
            // 'privacy',
            // 'download:ntext',

            [
                'class' => kartik\grid\ActionColumn::className(),
                'template' => '{view}{delete}',
//                'buttons'=>[
//                    'view' => function ($url, $model) {
//                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
//                            'title' => Yii::t('app', 'add video'),
//                            'data-pjax'=>"0",
//                            'role'=>"modal-remote",
//                            'data-toggle'=>"tooltip"
//                        ]);
//                    }
//                ],

                
                'dropdown' => false,
                'vAlign'=>'middle',
                'urlCreator' => function($action, $model, $key, $index) { 
                        return Url::to([$action,'id'=>$key]);
                },
                'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
                'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
                'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                    'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                    'data-request-method'=>'post',
                    'data-toggle'=>'tooltip',
                    'data-confirm-title'=>'Are you sure?',
                    'data-confirm-message'=>'Are you sure want to delete this item'], 
            ],
        ],
    ]); ?>
<?php // Pjax::end(); ?></div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
    'options' => [
        'tabindex' => false, // important for Select2 to work properly 
    ],
])?>
<?php Modal::end(); ?>
