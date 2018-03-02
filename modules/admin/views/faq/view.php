<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Faq */
?>
<div class="faq-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'published',
        ],
    ]) ?>

</div>
