<?php
$this->title = $content['name'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="view_public clearfix">
    <div class="view_content <?= $action ?>">
        <?= $content['description'] ?>
    </div>
</div>

