<?php

use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'status',
                'value' => User::itemAlias('status', $model->status),
            ],
            [
                'label' => 'role',
                'value' => User::itemAlias('role', $model->role),
            ],
            [
                'label' => 'created_at',
                'value' => $model->created_at ? date('d.m.y H:i', $model->created_at) : null,
            ],
            [
                'label' => 'updated_at',
                'value' => $model->updated_at ? date('d.m.y H:i', $model->updated_at) : null,
            ],
            'username',
            'email:email',
        ],
    ]) ?>

</div>
