<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Introduction */
?>
<div class="introduction-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'target_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
