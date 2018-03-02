<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CategoryFaqs */
?>
<div class="category-faqs-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [                      // the owner name of the model
                'label' => 'language_id',
                'value' => $model->language_id ? $model->language->name : null,
            ],
            'name',
        ],
]) ?>

</div>
