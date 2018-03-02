<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<?php if(empty($list)) : ?>
    <h2>Nothing found on your request</h2>
<?php else : ?>

<?php foreach ($list as $value) : ?>
    <div class="search__row clearfix <?= ($value['type'] == 'user') ? 'search-user' : null ?>">
        <div class="search__image col-sm-2">
            <a href="<?= Url::toRoute($value['slug']) ?>">
                    <?= Html::img(
                            $this->render('@app/views/blocks/thumbnail-url-resize-height', 
                            ['url' => Yii::getAlias("@webroot/{$value['logo']}"), 'height' => 193]
                        )) 
                    ?>
            </a>
        </div>
        <div class="search__wrap col-sm-9">
            <div class="search__name">
                <a href="<?= Url::toRoute($value['slug']) ?>"><?= $value['name'] ?></a>
            </div>
            <div class="search__type"><?= $value['field1'] ?></div>
            <div class="search__country">
                <?php if($value['type'] == 'user'){
                    echo $value['fied2'];
                }else{
                    echo date('F d, Y', $value['fied2']);
                }
             ?></div>
                <?php if($value['type'] != 'user') : ?>
                    <div class="search__description"><?= $value['description'] ?></div>
                <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
<div class="pagination-div">
    <?= LinkPager::widget(['pagination' => $pages]);?>
</div>
<?php endif; ?>


<!--<div class="search__row clearfix">
    <div class="search__image col-sm-2"><a href="#"><img src="/images/ blog/fda9ffc4c41f121350c98e25584279ab30813b94.jpg" alt=""></a></div>
    <div class="search__wrap col-sm-9">
        <div class="search__name"><a href="#">REESE WITHERSPOON WORE A BLAZER AS A DRESS ON THE EMMYS RED CARPET</a></div>
        <div class="search__date">By Admin on Oct 12, 2017</div>
    </div>
</div>-->