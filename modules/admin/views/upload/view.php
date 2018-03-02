<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Upload */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Uploads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id_vimeo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_vimeo',
            [
                'label' => 'preview',
                'format' => 'html',
                'value' => $model->preview ? $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/upload/{$model->preview}"), 'width' => 200, 'height' => 100]): null,
            ],
            'duration',
            [                      // the owner name of the model
              'label' => 'status',
              'value' => app\models\Upload::itemAlias('status', $model->status),
            ],
            'name',
            'description:ntext',
            
//            'stream',
            'privacy',
            'created_time',
//            'created_at',
//            'updated_at',
//            'download:ntext',
        ],
    ]) ?>

</div>
