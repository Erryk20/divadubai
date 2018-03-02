<?php 
echo Yii::$app->thumbnail->url($url, [
    'thumbnail' => [
        'width' => $width,
        'height' => $height,
    ],
//    'placeholder' => [
//        'width' => $width,
//        'height' => $height,
//    ],
    'resize' => [
        'width' => $width,
        'height' => $height
    ],
    'quality' => 70,
    'compress' => true
]);
