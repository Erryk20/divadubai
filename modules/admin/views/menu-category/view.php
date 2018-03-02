<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MenuCategory */
?>
<div class="menu-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'menu',
            [                  
                'label' => 'Categories',
                'format' => 'html',
                'value'=>function ($model){
                    $result = '<ul>';
                    foreach ($model->categories AS $value){
                        $result .= "<li class='sub-block'>{$value}</li>";
                    }
                    $result .= '</ul>';
                    return $result;
                },
            ],
        ],
    ]) ?>

</div>
