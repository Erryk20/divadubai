<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CastingUser */
?>
<div class="casting-user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'casting_id',
                'value' => $model->casting ? $model->casting->title : NULL,
            ],
            'name',
            'email:email',
            'phone',
            'message',
        ],
    ]) ?>

</div>
