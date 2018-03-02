<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EmailTheme */
//
?>
<div class="email-theme-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'subject',
            'content:raw',
        ],
    ]) ?>

</div>
