<?php

use kartik\helpers\Html;

?>


<?= yii\helpers\Html::a('Dashboard', ['/dashboard'], ['class'=>'link-site'.(($this->context->action->id == 'dashboard') ? ' active' : null)]) ?>
<?= yii\helpers\Html::a('My Castings', ['site/my-castings'], ['class'=>'link-site'.(($this->context->action->id == 'my-castings') ? ' active' : null)]) ?>
<?= yii\helpers\Html::a('Favorite Castings', ['site/favorite-castings'.(($this->context->action->id == 'favorite-castings') ? ' active' : null)], ['class'=>'link-site']) ?>
<?= yii\helpers\Html::a('Book', ['site/my-book'.(($this->context->action->id == 'my-book') ? ' active' : null)], ['class'=>'link-site']) ?>