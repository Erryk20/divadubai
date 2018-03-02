<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

//$email = '';
//if(!Yii::$app->user->isGuest){
//    $user = Yii::$app->user->identity;
//    $email = $user->email;
//}

?>

<?= Html::a('Download', ['/download/pdf-profile', 'id' => $model['id']], [
    'class' => "item item_download",
    'data'=>[
        'method' => 'post',
        'params'=>['main'=>$logo],
    ]
]) ?>

<?= Html::a('Email', '#', ['class' => "item item_email", 'data-toggle'=>"modal", 'data-target'=>"#castingModal"]) ?>
<?php // vd($model);  , 'data-email'=>$email?>
<!--<a href="mailto:enquiry@divadubai.com">enquiry@divadubai.com</a>-->

<?php // = Html::a('Print', ["/pdf/{$id}.pdf"], ['class' => "item item_print", 'target'=>"_blank"]) ?>
<?= Html::a('Print', ['/download/print-pdf-profile', 'id' => $model['id']], ['class' => "item item_print", 'target'=>"_blank"]) ?>

<?= Html::a('Cart', '#', ['class' => "item item_cart", 'data-url'=> Url::toRoute(['/ajax/add-favourite', 'id' => $model['id']])]) ?>