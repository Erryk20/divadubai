<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ModelSubcategry */
?>
<div class="model-subcategry-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'name',
            'slug',
        ],
    ]) ?>

</div>
