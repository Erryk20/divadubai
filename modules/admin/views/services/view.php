<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MainList */
?>
<div class="main-list-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'link',
            'name',
            [
                'label' => 'src',
                'format'=>'raw',
                'value' => $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/main-list/{$model->src}"), 'width' => 500, 'height' => 900])
            ]
        ],
    ]) ?>

</div>
