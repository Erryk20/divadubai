<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Faqs */
?>
<div class="faqs-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [                      
              'attribute' => 'language_id',
              'value' => $model->language_id ? $model->language->name : null,
            ],
            [                      
              'attribute' => 'category_faqs_id',
              'value' => $model->category_faqs_id ? $model->category->name : null,
            ],
            'questions',
            'answer:html',
        ],
    ]) ?>

</div>
