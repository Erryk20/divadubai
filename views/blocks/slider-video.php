<div class="ajax-progress"><div class="throbber"></div></div>
<div class="row">
    <?php foreach ($list as $item) : ?>
        <div class="col col-md-4">
            <?php if ($item['type'] == 'vimeo') : ?>
                <iframe src="https://player.vimeo.com/video/<?= $item['id'] ?>"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            <?php else : ?>
                <iframe  src="https://www.youtube.com/embed/<?= $item['id'] ?>?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>