<?php

use yii\widgets\DetailView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EmailTheme */
//

echo 'Back'
?>
<div class="email-theme-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'subject',
            'content:raw',
        ],
    ]) ?>
</div>
<?=  Html::a('Booking Form',['/admin/booking-form'],['class'=>'btn btn-default', 'style'=>"margin-right: 10px;"]) ?>
<?=  Html::a('Update',['/admin/email-theme/booking', 'id'=>4],['class'=>'btn btn-primary']) ?>
