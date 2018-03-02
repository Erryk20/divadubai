<?php 
$shares = \app\models\Share::getAllShare();
?>

<div class="container block_content">
    <div class="row">
        <div class="block_title">Follow us</div>
        <?php foreach ($shares as $value) : ?>
            <div class="col col-xs-6 col-sm-1-5  col-md-1-5  col-lg-1-5">
                <div class="image">
                    <a href="<?= $value['url'] ?>" target="_blank">
                        <img src="<?= $value['img'] ?>" alt="">
                    </a>
                </div>
                <div class="title">
                    <a href="<?= $value['url'] ?>" target="_blank"><?= $value['name'] ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>