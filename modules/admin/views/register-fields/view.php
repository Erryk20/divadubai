<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RegisterFields */
?>
<div class="register-fields-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'label' => 'category_id',
              'value' =>function($model){
                    return $model->category ? $model->category->name : null;
              }
            ],
            [
                'label' => 'fields',
                'format'=>'html',
                 'value'=>function($model){
                    $result = "<ul class='fields'>";
                    $labels = Yii::$app->controller->labels;
                    foreach ($model->fields as $value) {
                        $result .=  "<li>{$labels[$value]}</li>";
                    }
                    $result .= "</ul>";
                    return $result;
                },
            ],
        ],
    ]) ?>

</div>
