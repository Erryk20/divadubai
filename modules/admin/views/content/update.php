<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
?>
<div class="content-update">

    <?= $this->render('_form', [
        'model' => $model,
        'istView'=>$istView
    ]) ?>

</div>
