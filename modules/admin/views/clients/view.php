<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Awards */
?>
<div class="awards-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'img',
                'format'=>'raw',
                'value' => $model->img ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/clients/{$model->img}"), 'width' => 200, 'height' => 200]): null,
            ],
            'url:url',
        ],
    ]) ?>

</div>
