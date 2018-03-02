<?php 
use yii\helpers\Url;
use yii\helpers\Html;

$book = app\models\Book::getBooksUrl();

?>

<ul class="menu clearfix">
    <li class="menu_item menu_item_1"><?= \kartik\helpers\Html::a('Casting', ['/site/casting']) ?></li>
    <li class="menu_item menu_item_2"><?= \kartik\helpers\Html::a('Newsletters', ['/site/blogs']) ?></li>
    <li class="menu_item menu_item_5">
        <a href="<?= Url::toRoute(['/']) ?>">Book</a>
        <div class="dropdown">
            <ul>
                <?php foreach ($book as $url => $value) : ?>
                    <li><?= Html::a($value, $url) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </li>
    <li class="menu_item menu_item_4">
        <a href="<?= Url::toRoute(['/register']) ?>">Register</a>
    </li>			
    <li class="menu_item menu_item_3">
        <?php if (Yii::$app->user->isGuest) : ?>
            <a href="<?= Url::toRoute(['/login']) ?>">Login</a>
        <?php else : ?>
            <a href="<?= Url::toRoute(['/logout']) ?>">Logout</a>
        <?php endif; ?>
    </li>
            <?php if(Yii::$app->user->isGuest) : ?>
                <li class="menu_item menu_item_6 not-register"></li>
            <?php else : ?>
                <li class="menu_item menu_item_6">
                    <?= Html::a("My profile", ['/site/dashboard', 'user_id'=> Yii::$app->user->id]) ?>
                </li>
            <?php endif; ?>
</ul>