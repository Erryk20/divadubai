<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Share */

?>
<div class="share-create">
    <?= $this->render('_form', [
        'model' => $model,
        'images' => $images,
    ]) ?>
</div>
