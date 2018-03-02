<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="error_view">
    <div class="error_title"><?= $exception->statusCode ?></div>
    <div class="title">Sorry...</div>
    <div class="subtitle"><?= nl2br(Html::encode($message)) ?></div>
    <div class="description">
        Maybe it’s moved, or maybe the URL is incorrect.
        Please check the URL and try your luck again.
    </div>
</div>
