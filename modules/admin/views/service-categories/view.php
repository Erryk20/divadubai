<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceCategories */
?>
<div class="service-categories-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                   
              'label' => 'service_id',
              'value' => $model->service ? $model->service->name : null,
            ],
            'short',
            'name',
            'slug',
        ],
    ]) ?>

</div>
