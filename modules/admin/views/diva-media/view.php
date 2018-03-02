<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DivaMedia */
?>
<div class="diva-media-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'url:html',
            [
                'label' => 'Img',
                'format' => 'html',
                'value' => $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/diva-media/{$model->img}"), 'width' => 200, 'height' => 200]),
            ],
        ],
    ]) ?>

</div>
