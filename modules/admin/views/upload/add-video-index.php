<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\VideosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Videos');
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

//vd($dataProvider, false);
//die_my();
?>
<div class="videos-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'pjax'=>true,
            'columns' => require(__DIR__.'/_add-video-columns.php'),
            'toolbar'=> [
                ['content'=> \yii\widgets\LinkPager::widget(['pagination' => $pages])]
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'primary', 
                'heading' => '<i class="glyphicon glyphicon-list"></i> Videos listing',
                'before'=>'<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
                'after'=>\yii\widgets\LinkPager::widget(['pagination' => $pages])
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
