<?php

use yii\widgets\DetailView;
use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Services */
?>
<div class="services-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'src',
                'format'=>'html',
                'value' => $model->src ? Html::img("/images/service/{$model->src}", ['style'=>"max-width: 450px;"]) : null,
            ],
            'name',
            'slug',
        ],
    ]) ?>

</div>
