<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Countries */
?>
<div class="countries-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'language',
            'name',
            'url:url',
        ],
    ]) ?>

</div>
