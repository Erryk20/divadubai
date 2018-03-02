<?php

use yii\widgets\DetailView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Slider */
?>
<div class="slider-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'title:html',
            'description:html',
            [
                'label' => 'img',
                'format' => 'raw',
                'value' => Html::img("/images/slider/{$model->img}", ["style"=>"width: 100%;"]),
            ],
//            'published',
        ],
    ]) ?>

</div>
