<?php 
$options = isset($options) ? $options : [];

//vd($url);
echo  Yii::$app->thumbnail->img($url, [
    'thumbnail' => [
        'width' => $width,
        'height' => $height,
    ],
    'placeholder' => [
        'width' => $width,
        'height' => $height,
    ],
//    'resize' => [
//        'width' => $width,
//        'height' => $height
//    ],
    'quality' => 75,
], $options);