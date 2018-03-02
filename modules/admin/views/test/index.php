<?php

echo \kartik\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $search->search(),
    'layout' => "{items}\n{pager}",
    'columns' => [
        'id',
        'key',
        'value',
        'description',
    ],
]);
