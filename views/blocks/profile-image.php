<?php 
use kartik\helpers\Html;


?>

<table class="photo_wrapper clearfix">
    <tbody>
        <tr>
            <td class="main_photos col">
                <div class="col">
                    <a href="#">
                        <?=
                        isset($list['logo']) ? Html::img(
                                        $this->render('@app/views/blocks/thumbnail-url-resize-height', ['url' => Yii::getAlias("@webroot/{$list['logo']}"), 'height' => 670]), ['data-src' => $list['logo']]
                                ) : null;
                        ?>
                    </a>
                </div>
            </td>
            <td class="thumb_photos">
                <table>
                    <tbody>
                        <tr>
                            <?php for ($i = 0; $i < 4; $i++) : ?>
                                <td class="col" style="padding-bottom: 30px;">
                                    <div class="photo">
                                        <a href="#">
                                            <?= Html::img($this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$list['list'][$i]}"), 'height' => 320, 'width' => 240]), ['data-src' => $list['list'][$i]]) ?>
                                        </a>
                                    </div>
                                </td>
                            <?php endfor ?>
                        </tr>
                        <tr>
                            <?php for ($i = 4; $i < 8; $i++) : ?>
                                <td class="col" style="padding-bottom: 30px;">
                                    <div class="photo">
                                        <a href="#">
                                            <?= Html::img($this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$list['list'][$i]}"), 'height' => 320, 'width' => 240]), ['data-src' => $list['list'][$i]]) ?>
                                        </a>
                                    </div>
                                </td>
                            <?php endfor ?>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>