<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FaqAsk */
?>
<div class="faq-ask-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'email:email',
            'question:ntext',
//            'view',
        ],
    ]) ?>

</div>
