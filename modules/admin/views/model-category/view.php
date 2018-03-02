<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ModelCategory */
?>
<div class="model-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parent_id',
            'name',
            'slug',
        ],
    ]) ?>

</div>
