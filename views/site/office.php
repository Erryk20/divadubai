<?php 

$this->title = 'Office';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="view_office">
    <div class="view_content">
        <?php foreach ($list as $value) : ?>
        <div class="image">
            <a href="<?= $value['slug'] ?>" target="_blank">
                <img src="/images/office/<?= $value['src'] ?>" alt="<?= $value['title'] ?>">
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>