<?php

use yii\widgets\DetailView;
use app\models\BookFieldsUser;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\BookFieldsUser */
?>
<div class="book-fields-user-view">
 
    <?= DetailView::widget([
        'model' => new BookFieldsUser(),
        'attributes' => $model,
    ]) ?>

</div>
