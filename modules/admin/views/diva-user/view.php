<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DivaUser */
?>
<div class="diva-user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'diva_media_id',
            'type',
            'user_id',
        ],
    ]) ?>

</div>
