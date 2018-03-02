<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

$vertical = !in_array($action, ['locations', 'photographers']);
?>

<!--<div class="row">-->
    <?php foreach ($list as $value) : ?>
        <li class="col  col-xs-6 col-sm-2 col-lg-2 col-xl-6 col-xxl-10">
            <div class="col_content">
                <div class="image">
                    <a href="<?= Url::toRoute([$value['pre_url'], 'category' => $type, 'action' => $value['url'], 'info_user_id' => $value['info_user_id']]) ?>">
                        
                            <?php if($vertical) : ?> 
                                <?=  Html::img(
                                        $this->render('@app/views/blocks/thumbnail-url', 
                                        ['url' => Yii::getAlias("@webroot/images/user-media/{$value['src']}"), 'height' => 320, 'width' => 240]
                                    ),['data-src'=>$value]) 
                                ?>
                            <?php else : ?>
                                <?= Html::img(
                                            $this->render('@app/views/blocks/thumbnail-url-resize', 
                                                ['url' => Yii::getAlias("@webroot/images/user-media/{$value['src']}"), 'width' => 320])
                                            // ['height'=>"640"]
                                        );
                                ?>
                        
                               
                             <?php // =  Html::img(
//                                        $this->render('@app/views/blocks/thumbnail-url', 
//                                        ['url' => Yii::getAlias("@webroot/images/user-media/{$value['src']}"), 'height' => 240, 'width' => 320]
//                                    ),['data-src'=>$value]) 
                                ?>
                            <?php endif; ?>
                        
                    </a>
                </div>
                <div class="name">
                    <?=
                    Html::a("{$value['short']}**{$value['info_user_id']}", [
                        $value['pre_url'],
                        'category' => $type,
                        'action' => $value['url'],
                        'info_user_id' => $value['info_user_id']
                    ])
                    ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
<!--</div>-->
<a href="<?= $url ?>" class="pagination__next"></a>