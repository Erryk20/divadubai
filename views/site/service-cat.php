<?php 
use kartik\helpers\Html;
use yii\helpers\Url;

$this->title = $info_top['name'];

if($url) $this->params['breadcrumbs'][] = $info_top['cat_name']; // ['label' =>,  'url' => '#' ]; //['/site/service', 'service'=>$info_top['cat_url']]

$this->params['breadcrumbs'][] = $this->title;
?>

<?php 

?>
<div class="filter_wrapper">
    <div class="row">
        <div class="male_filter col-sm-12 col-lg-10">
            <ul>
                <?php foreach ($menu as $value) : ?>
                    <li>
                        <?= Html::a($value['name'], ['/site/service', 'service'=>$value['service'], 'url'=> $value['slug']], ['class'=> $value['is_active'] ? 'active' : null ]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="parameters_wrap col-sm-12 col-lg-2">
            <div class="parameters_btn">Show parameters</div>
            <?= $this->render('@app/views/blocks/filter-models', ['categories'=>$menu]) ?>
        </div>
    </div>
</div>
<ul class="view_locations">
    <?php foreach ($list as $value) : ?>
        <li class="col">
            <div class="col_content">
                <div class="image">
                    <a href="<?= Url::toRoute(['/site/service-profile', 'service'=>$value['service'], 'category'=>$value['slug'], 'info_user_id'=>$value['info_user_id'] ]) ?>">
                        <?= Html::img("/images/user-media/{$value['logo']}") ?>
                    </a>
                </div>
                <div class="name">
                    <?= Html::a("{$value['short']}*{$value['info_user_id']}", ['/site/service-profile', 'service'=>$value['service'], 'category'=>$value['slug'], 'info_user_id'=>$value['info_user_id'] ]) ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    
</ul>