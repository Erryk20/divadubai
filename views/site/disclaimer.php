<?php 
use kartik\helpers\Html;

$this->title = $content['name'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view_disclaimer">
    <div class="view_content">
        <div class="description">
            <?= $content['description'] ?>
        </div>
        <div class="field_note clearfix">
            <div class="field_label">Please note:</div>
            <div class="field_content">
                <p><?= $content['block_1'] ?></p>
            </div>
        </div>
        <div class="remind_field"><h3><?= $content['block_2'] ?></h3></div>
    </div>
</div>