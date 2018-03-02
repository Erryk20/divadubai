<?php

use yii\widgets\DetailView;
use kartik\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DivaMedia */
?>
<div class="diva-media-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'slug:html',
            [
                'label' => 'img',
                'format' => 'raw',
                'value' => Html::img("/images/diva-media/{$model->img}", ["style"=>"width: 100%;"]),
            ],
        ],
    ]) ?>

</div>
