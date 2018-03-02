<?php

use yii\widgets\DetailView;
use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Casting */
?>
<div class="casting-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'src',
                'format'=>'html',
                'value' => $model->src ? Html::img("/images/casting/{$model->src}", ['style'=>"max-width: 450px;"]) : null,
            ],
            'title',
            'gender',
            'fee',
            'casting_date',
            'time_from',
            'time_to',
            'job_date',
            'location',
            'booker_name',
            'bookers_number',
            'details:text',
        ],
    ]) ?>

</div>
