<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
?>
<div class="content-view">
 
    <?php 
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Youtube Video',
                'value' => $model->block_1,
            ],
        ],
    ]) ?>

</div>
