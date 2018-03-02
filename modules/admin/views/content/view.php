<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Content */
?>
<div class="content-view">
 
    <?php 
    $attributes = [];
    if($istView['is_top'] == '1')           $attributes[] = 'top:html';
    if($istView['is_blockquote'] == '1')    $attributes[] = 'blockquote:html';
    if($istView['is_description'] == '1')   $attributes[] = 'description:html';
    if($istView['is_block_1'] == '1')       $attributes[] = 'block_1:html';
    if($istView['is_block_2'] == '1')       $attributes[] = 'block_2:html';
    if($istView['is_block_3'] == '1')       $attributes[] = 'block_3:html';
    
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $attributes,
    ]) ?>

</div>
