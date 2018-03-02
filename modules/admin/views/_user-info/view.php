<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserInfo */
?>
<div class="user-info-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_id',
            'type',
        ],
    ]) ?>

</div>
