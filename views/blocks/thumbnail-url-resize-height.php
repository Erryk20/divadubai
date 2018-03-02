<?php 
echo Yii::$app->thumbnail->url($url, [
    'resize' => [
        'height' => $height,
    ],
    'quality' => 70,
    'compress' => true
]);
