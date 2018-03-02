<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ContentMedia */
?>
<div class="content-media-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'target_id',
            'type',
            'image',
            'video',
            'source',
        ],
    ]) ?>

</div>
