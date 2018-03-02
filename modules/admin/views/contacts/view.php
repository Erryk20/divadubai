<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Contacts */
?>
<div class="contacts-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'post',
            [
                'label' => 'mobile',
                'format' => 'raw',
                'value' => function($model){
                    $data = json_decode($model->mobile);
                    $result = '<ul>';
                    foreach ($data as $value) {
                        $result .= "<li>{$value}</li>";
                    }
                    $result .= "</ul>";
                    return $result;
                } 
            ],
            [
                'label' => 'email',
                'format' => 'raw',
                'value' => function($model){
                    $data = json_decode($model->email);
                    $result = '<ul>';
                    foreach ($data as $value) {
                        $result .= "<li>{$value}</li>";
                    }
                    $result .= "</ul>";
                    return $result;
                } 
            ],
        ],
    ]) ?>

</div>