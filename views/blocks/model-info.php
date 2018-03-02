<?php

use app\models\UserInfo;
?>

<tbody>
    <tr>
        <?php if ($model['height']) : ?>
            <td class="item col-sm-2 col-xs-6">
                <div class="item_content">
                    <div class="value"><?= UserInfo::itemAlias('height', $model['height']) ?></div>
                    <div class="title">Height</div>
                </div>
            </td>
        <?php endif; ?>
            
        <?php if ($model['chest']) : ?>
            <td class="item col-sm-2 col-xs-6">
                <div class="item_content">
                    <div class="value"><?= UserInfo::itemAlias('chest', $model['chest']) ?></div>
                    <div class="title">Chest</div>
                </div>
            </td>
        <?php endif; ?>
            
        <?php if ($model['waist']) : ?>
            <td class="item col-sm-2 col-xs-6">
                <div class="item_content">
                    <div class="value"><?= UserInfo::itemAlias('chest', $model['waist']) ?></div>
                    <div class="title">Waist</div>
                </div>
            </td>
        <?php endif; ?>
            
        <?php if ($model['hips']) : ?>
            <td class="item col-sm-2 col-xs-6">
                <div class="item_content">
                    <div class="value"><?= UserInfo::itemAlias('chest', $model['hips']) ?></div>
                    <div class="title">Hips</div>
                </div>
            </td>
        <?php endif; ?>


        <?php if ($model['shoe']) : ?>
            <td class="item col-sm-2 col-xs-6">
                <div class="item_content">
                    <div class="value"><?= UserInfo::itemAlias('shoe', $model['shoe']) ?></div>
                    <div class="title">Shoes</div>
                </div>
            </td>
        <?php endif; ?>
            
        <?php if (!in_array($model['hair'], ['', '[]']) || !in_array($model['eye'], ['', '[]'])) : ?>
            <td class="item col-sm-2 col-xs-6">
                <div class="item_content">
                    <?php if (!in_array($model['hair'], ['', '[]'])) : ?>
                        <div class="title"><b><?= UserInfo::itemAlias('hair', trim($model['hair'], '"')) ?></b> Hair</div>
                    <?php endif; ?>
                    <?php if (!in_array($model['eye'], ['', '[]'])) : ?>
                        <div class="title"><b><?= UserInfo::itemAlias('eye', trim($model['eye'], '"')) ?></b> Eyes</div>
                    <?php endif; ?>
                </div>
            </td>
        <?php endif; ?>

    </tr>
</tbody>
