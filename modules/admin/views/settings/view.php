<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */
?>
<div class="settings-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'properties',
            'value',
        ],
    ]) ?>

</div>
