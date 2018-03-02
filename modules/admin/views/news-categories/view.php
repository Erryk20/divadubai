<?php

use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
?>
<div class="page-view">
 
    <?=  DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
//            'parent_id',
            [
                'attribute'=>'published', 
                'format'=>'raw',
                'value'=>$model->published ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>',
                'type'=> DetailView::INPUT_SWITCH,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'onText' => 'Yes',
                        'offText' => 'No',
                    ]
                ],
                'valueColOptions'=>['style'=>'width:30%']
            ],
            'url:url',
            'name',
            'content:html',
        ],
    ]) ?>

</div>
