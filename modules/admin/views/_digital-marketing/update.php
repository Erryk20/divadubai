<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserInfo */
$this->title = 'Update User Info';
$this->params['breadcrumbs'][] = ['label' => 'User Info' , 'url' => ['/admin/user-info']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-info-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
