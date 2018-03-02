<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
?>
<div class="message-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [                      
                'label' => 'language',
                'value' => $model->language,
            ],
            'translation',
        ],
    ]) ?>

</div>
