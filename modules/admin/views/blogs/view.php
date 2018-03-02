<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Blogs */
?>
<div class="blogs-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:html',
            'src',
            'slug',
            'created_at:date',
            'updated_at:date',
        ],
    ]) ?>

</div>
