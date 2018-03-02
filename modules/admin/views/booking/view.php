<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Booking */
?>
<div class="booking-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'client_name',
            'client_id',
            'requirement',
            'booked_as',
            'usage_for',
            'booker_name',
            'period',
            'contact_number',
            'date_of_shoot',
            'job_number',
            'location',
            'amount',
            'user_name',
            'ac_name',
            'ac_number',
            'bank_name',
            'signature',
            'last_date',
            'act_total',
            'cheque',
            'model_id',
            'type',
            'from_date',
            'to_date',
            'email:email',
            'status',
        ],
    ]) ?>

</div>
