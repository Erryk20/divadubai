<?php
$this->title = $content['name'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="view_training clearfix">
    <div class="view_header">
        <?php foreach ($images as $value) : ?>
            <div class="item">
                <img src="<?= $value['src'] ?>" alt="<?= $value['title'] ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <div class="view_content container">
        <div class="col_group clearfix">
            <div class="col-sm-6 col">
                <div class="col_content">
                    <?= $content['block_2'] ?>
                    <a class="btn" data-title="Model Training Course" data-toggle="modal" data-target="#modal">Book now</a>
                </div>
            </div>
            <div class="col-sm-6 col">
                <div class="col_content">
                    <?= $content['block_3'] ?>
                    <a class="btn" data-title="Model Portfolio" data-toggle="modal" data-target="#modal">Book now</a>
                </div>
            </div>
        </div>
        <div class="question_wrap">
            <?= $content['description'] ?>
        </div>
    </div>
</div>


<div class="modals_wrap">
    <div id="modal" class="casting_modal modal fade">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Close</button>
                <div class="form_title">Send You email</div>
            </div>
            <div class="modal-content">
                <?= $this->render(
                        '@app/views/blocks/modal-email', 
                        [
                            'model'=> new app\models\Email(['scenario'=>'profile-send']), 
                            'action'=>'/ajax/send-email',
                        ]) ?>
            </div>
        </div>
    </div>
</div>