<?php 
use cics\widgets\VideoEmbed;
use kartik\helpers\Html;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\data\ArrayDataProvider;

use johnitvn\ajaxcrud\CrudAsset;

CrudAsset::register($this);

$this->title = 'About Us';

?>

<style>
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        padding-top: 30px; height: 0; overflow: hidden;
    }

    .video-container iframe,
    .video-container object,
    .video-container embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<div class="content-images-index">
    <div id="ajaxCrudDatatable">
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $provider,
            'pjax'=>true,
            'columns' => [
                [
                    'attribute' => 'video',
                    'format' => 'raw',
                    'vAlign'=>'middle',
                    'value' => function ($model) {
                        return VideoEmbed::widget([
                            'url' => $model['video'],
                            'container_class' => 'a-second-custom-class',
                        ]);
                    },
                ],
            ],
            'toolbar'=> [
                ['content'=>
                    Html::a('<div class="property-sider btn-group">Update Video</div>', ['/admin/about-us/update', 'target_id'=>1, 'type'=>'about-us'],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default']).
                    Html::a('<div class="property-sider btn-group">SEO</div>', ['/admin/seo/update', 'target_id'=>1, 'type'=>'about-us'],
                    ['role'=>'modal-remote','title'=> 'Update seo','class'=>'btn btn-default'])
                ],
            ],          
            'striped' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => ['type' => 'default']
        ])?>
    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>


<!--<div class="view_about clearfix">
    <div class="video_youtube pause" data-video="vvb65WGktoo">
        <img src="../images/about_us.jpg" alt="">
    </div>
</div>-->