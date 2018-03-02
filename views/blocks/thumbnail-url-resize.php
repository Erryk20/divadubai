<?php 
echo Yii::$app->thumbnail->url($url, [
    'resize' => [
        'width' => $width,
//        'height' => $height,
    ],
    'quality' => 70,
    'compress' => true
]);
