<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BookFields */
?>
<div class="book-fields-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'book_id',
            'label',
        ],
    ]) ?>

</div>
