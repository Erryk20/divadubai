<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
?>
<div class="categories-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'published',
        ],
    ]) ?>

</div>
