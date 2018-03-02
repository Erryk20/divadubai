<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Share */
?>
<div class="share-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'url:url',
        ],
    ]) ?>

</div>
