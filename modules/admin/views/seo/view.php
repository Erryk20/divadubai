<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Seo */
?>
<div class="seo-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'type',
            'title',
            'keywords',
            'description:ntext',
        ],
    ]) ?>

</div>
