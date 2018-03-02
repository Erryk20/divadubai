<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserCategory */
?>
<div class="user-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'info_user_id',
            'active',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
