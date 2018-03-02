<?php 
use yii\helpers\Html;

?>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="/images/favicon.png" type="image/png">

<?= Html::csrfMetaTags() ?>

<title><?= Html::encode(Yii::$app->controller->seo['title']) ?></title>
<title>Diva | Modeling & Events FZ - LLC</title>

<?= $this->registerMetaTag(['keywords' => Yii::$app->controller->seo['keywords']]); ?>
<?= $this->registerMetaTag(['description' => Yii::$app->controller->seo['description']]); ?>

<?php 
    if(Yii::$app->session->hasFlash('success')){
        $message =  Yii::$app->session->getFlash('success');
        $this->registerJs("$.jGrowl('{$message}',{theme:'bg-green'});", \yii\web\View::POS_END);
    }
?>
<?php $this->head() ?>