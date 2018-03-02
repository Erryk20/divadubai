<?php

use yii\widgets\DetailView;
use app\common\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */
?>
<div class="posts-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'img',
                'format' => 'raw',
                'value' => $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/posts/{$model->img}"), 'width' => 200, 'height' => 200]),
            ],
            'id',
            'created_at:date',
            'updated_at:date',
            'language',
            'name',
            [
                'label' => 'Username',
                'value' => User::getUserForId($model->user_id),
            ],
            'short_description:html',
//            'description:html',
        ],
    ]) ?>

</div>
