<?php

use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ContentImages */
?>
<div class="content-images-view">
    <?= Html::img("/images/office/{$model->src}", ['style'=>'margin: 0 auto; display: inherit; width: 100%;']) ?>
</div>
