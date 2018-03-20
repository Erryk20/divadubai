<?php 
use kartik\helpers\Html;

?>

<!DOCTYPE html>
<html>
    <body>
        <table border="0" style="width: 1080px;padding-top:10px;margin: 0 auto;">
            <tr>
                <td style="width: 50%;">
                    <table>
                        <tr>
                            <td style="height: 640px; vertical-align: center;" >
                                <table>
                                    <tr>
                                        <td style="height: 640px; vertical-align: center;">
                                            <a href="<?= "{$domen}/profile/{$info['id']}" ?>">
                                                <?= Html::img(
                                                        "{$domen}/". $this->render('@app/views/blocks/thumbnail-url-resize', 
                                                            ['url' => Yii::getAlias("@webroot/{$list['logo']}"), 'width' => 510]),
                                                        ['height'=>"634"]
                                                    );
                                                
                                                
                        //                        echo  Html::img($this->render(
                        //                            '@app/views/blocks/thumbnail-url-resize-height', 
                        //                            [
                        //                                'url' => Yii::getAlias("@webroot/{$list['logo']}"), 
                        //                                'height' => 670
                        //                            ]));
                                                    
                                                ?>
                                                
                                                <?php //= Html::img(
                        //                            "{$domen}/". $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$list['logo']}"), 'width' => 652, 'height'=>500])
                        //                           ) 
                                                ?>
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                           <td>
                               <table style="width: 400px;margin: 0 auto;">
                                   <tr>
                                       <td style="text-align: center;">
                                           <a href="<?= "{$domen}/profile/{$info['id']}" ?>">
                                               <?= Html::img("{$domen}/images/diva-logo.png", ['width'=>"60"]) ?>
                                           </a>
                                           <br>*.<?= " {$info['id']}" ?>
                                       </td>
                                       <td style="text-align: center;">
                                           <?php if($info['height']) : ?>
                                               <b style="color: #c7c7c7; font-size: 20px;"><?= $info['height'] ?></b> <br>Height
                                           <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                           <?php if($info['chest']) : ?>
                                               <b style="color: #c7c7c7; font-size: 20px;"><?= $info['chest'] ?></b><br>Chest
                                           <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                           <?php if($info['chest']) : ?>
                                               <b style="color: #c7c7c7; font-size: 20px;"><?= $info['waist'] ?></b><br>Waist
                                           <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                           <?php if($info['chest']) : ?>
                                               <b style="color: #c7c7c7; font-size: 20px;"><?= $info['hips'] ?></b><br>Hips
                                           <?php endif; ?>
                                       </td>
                                       <td style="text-align: center;">
                                           <?php if($info['chest']) : ?>
                                               <b style="color: #c7c7c7; font-size: 20px;"><?= $info['shoe'] ?></b><br>Shoes
                                           <?php endif; ?>
                                       </td>
                                   </tr>
                               </table>
                           </td> 
                        </tr>
                        <tr>
                            <td>
                                <table border="0" style="width: 600px; font-size: 14px; text-align: center;">
                                    <tr><td>For Client Enquiries: +971 55 3421613</td></tr>
                                    <tr><td>Write to Us: enquiry@divadubai.com</td></tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top;">
                    <table>
                        <tr>
                            <td style="height: 640px; vertical-align: top;position: relative;">
                                <table style="position: absolute; left: 0;top: -30px;">
                                    <tr>
                                        <?php for($i = 1; $i <= 3; $i++) : ?>
                                            <?php
                                                if ($i == 1){
                                                    $padding = '60px';
                                                } else{
                                                    $padding = '0';
                                                }
                                            ?>
                                            <td align="center" style="height: 207px;padding-left: <?php echo $padding; ?>">
                                                <a href="<?= "{$domen}/profile/{$info['id']}" ?>">
                                                    <?php
                                                    if(isset($list['image'][$i])){
                                                        echo Html::img(
                                                            "{$domen}/". $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$list['image'][$i]}"), 'width' => 150, 'height'=>207])
                                                        );
                                                    }else{
                                                        echo Html::img(
                                                            "{$domen}/". $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/user-media/diva-logo.png"), 'width' => 150, 'height'=>207])
                                                        );
                                                    }
                                                    
                                                    ?>
                                                </a>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <?php for($i; $i <= 6; ++$i) : ?>
                                            <?php
                                                if ($i == 4){
                                                    $padding = '60px';
                                                } else{
                                                    $padding = '0';
                                                }
                                            ?>
                                            <td align="center" style="padding-left: <?php echo $padding; ?>">
                                                <a href="<?= "{$domen}/profile/{$info['id']}" ?>">
                                                    <?php
                                                    if(isset($list['image'][$i])){
                                                        echo Html::img(
                                                            "{$domen}/". $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$list['image'][$i]}"), 'width' => 150, 'height'=>207])
                                                        );
                                                    }else{
                                                        echo Html::img(
                                                            "{$domen}/". $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/user-media/diva-logo.png"), 'width' => 150, 'height'=>207])
                                                        );
                                                    }
                                                    
                                                    ?>
                                                </a>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <?php for($i; $i <= 9; ++$i) : ?>
                                             <?php
                                                if ($i == 7){
                                                    $padding = '60px';
                                                } else{
                                                    $padding = '0';
                                                }
                                            ?>
                                            <td align="center" style="padding-left: <?php echo $padding; ?>">
                                                <a href="<?= "{$domen}/profile/{$info['id']}" ?>">
                                                    <?php 
                                                        if(isset($list['image'][$i])){
                                                            echo Html::img(
                                                                "{$domen}/". $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/{$list['image'][$i]}"), 'width' => 150, 'height'=>207])
                                                            );
                                                        }else{
                                                            echo Html::img(
                                                                "{$domen}/". $this->render('@app/views/blocks/thumbnail-url', ['url' => Yii::getAlias("@webroot/images/user-media/diva-logo.png"), 'width' => 150, 'height'=>207])
                                                            );
                                                        }
                                                    ?>
                                                </a>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width: 400px;margin: 0 auto;padding-top: 10px;">
                                    <tr>
                                        <td style="text-align: center;color: #c7c7c7;">
                                            <?php if(!in_array($info['hair'], ['', '[]']) || !in_array($info['eye'], ['', '[]'])) : ?>
                                                <?= !in_array($info['hair'], ['', '[]']) ? $info['hair'] : null ?> Hair<br> <?= !in_array($info['eye'], ['', '[]']) ? $info['eye'] : null ?> Eyes
                                            <?php endif; ?>
                                        </td>
                                        <td style="font-size: 14px;text-align: left;color: #c7c7c7;">
                                            <?= ($info['nationality'] != '') ? "Nationality: {$info['nationality']}*" : null ?><br> 
                                            <?= ($info['ethnicity'] != '') ? "Ethinicity: {$info['ethnicity']}*" : null ?> 
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                
            </tr>
        </table>

    </body>
</html>