<?php
use yii\helpers\Url;
use kartik\builder\TabularForm;
use yii\helpers\Html;


return [
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'booked_as',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]booked_as", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'booker_name',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]booker_name", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]name", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'amount',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]amount", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'act_total',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]act_total", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'cheque',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]cheque", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'bank_name',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]bank_name", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'last_date',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]last_date", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'contact_number',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]contact_number", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'model_id',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]model_id", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'job_number',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]job_number", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'usage_for',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]usage_for", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'period',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]period", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'client_name',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]client_name", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'from_date',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]from_date", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'to_date',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]to_date", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'date_of_shoot',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]date_of_shoot", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'location',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]location", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'email',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]email", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'requirement',
        'format'=>'raw',
        'value'=>function($model) use ($form) {
            return $form->field($model, "[{$model->model_id}]requirement", ['options' => ['style'=>"width: 100px;"]])->textInput();
        }
    ],
];
