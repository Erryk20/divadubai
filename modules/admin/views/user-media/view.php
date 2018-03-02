<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserMedia */
?>
<div class="user-media-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'type',
            [
                'label' => 'src',
                'format'=>'raw',
                'value' => function ($model){
                    if(in_array($model->type, ['image', 'polaroid'])){
                        return $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/{$model->src}"), 'width' => 500, 'height' => 900]);
                    }else{
                        $result = app\models\UserMedia::getTypeVideo($model->src);
                        if($result['type'] == 'vimeo'){
                            return "<iframe src='https://player.vimeo.com/video/{$result['id']}'  frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
                        }else{
                            return "<iframe  src='https://www.youtube.com/embed/{$result['id']}?rel=0&amp;showinfo=0' frameborder='0' allowfullscreen></iframe>";
                        }
                    }
                }
            ],


        ],
    ]) ?>

</div>
