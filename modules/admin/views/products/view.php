<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
?>
<div class="products-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'label' => 'img',
                'format' => 'raw',
                'value' => $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/products/{$model->img}"), 'width' => 200, 'height' => 200]),
            ],
            'created_at:date',
            'updated_at:date',
            'price',
            'language_name',
            'name',
            'description:html',
        ],
    ]) ?>

</div>
