<?php

use yii\widgets\DetailView;
use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Diva */
?>
<div class="diva-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Title',
                'format'=>'raw',
                'value' => Html::a($model->title, ["/site/{$model->url}"], ['target'=>"_blank"]),
            ],
            'block_1:html',
            'block_2:html',
            'block_3:html',
            'block_4:html',
            'block_5:html',
        ],
    ]) ?>

</div>
