<?php
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = $model['name'];
$this->params['breadcrumbs'][] = ['label' => $model['parent'], 'url' => ['/site/parent', 'parent'=>$model['parent_url']]];
$this->params['breadcrumbs'][] = $this->title;


//vd();
?>

<?php if(empty($models)) : ?>


<?php else : ?>
    <?php Pjax::begin(); ?>
    <div class="filter_wrapper">
        <div class="row">
            <div class="male_filter col-sm-12 col-lg-10">
                <ul>
                    <li>
                        <a <?= $type == 'female' ? "class='active'" : null ?> href="<?= Url::toRoute(['/site/children',  
                            'children'=>$children, 
                            'parent'=>$parent, 
                            'type'=>'female'
                        ]) ?>">Female Models</a>
                    </li>
                    <li>
                        <a <?= $type == 'male' ? "class='active'" : null ?> href="<?= Url::toRoute(['/site/children',  
                            'children'=>$children, 
                            'parent'=>$parent, 
                            'type'=>'male'
                        ]) ?>">Male Models</a>
                    </li>
                    <li>
                        <a <?= $type == 'boy' ? "class='active'" : null ?> href="<?= Url::toRoute(['/site/children',  
                            'children'=>$children, 
                            'parent'=>$parent, 
                            'type'=>'boy'
                        ]) ?>">Boy Models</a>
                    </li>
                    <li>
                        <a <?= $type == 'girl' ? "class='active'" : null ?> href="<?= Url::toRoute(['/site/children',  
                            'children'=>$children, 
                            'parent'=>$parent, 
                            'type'=>'girl'
                        ]) ?>">Girl Models</a>
                    </li>
                    <li>
                        <a <?= $type == '' ? "class='active'" : null ?> href="<?= Url::toRoute(['/site/children',  
                            'children'=>$children, 
                            'parent'=>$parent, 
                            'type'=>''
                        ]) ?>">All Models</a>
                    </li>
                </ul>
            </div>
            <div class="parameters_wrap col-sm-12 col-lg-2">
                <div class="parameters_btn">Show parameters</div>
            </div>
        </div>
    </div>
    <div class="view_models">
        <ul class="view_content">
            <!--<div class="row">-->
                <?php foreach ($models as $value) : ?>
                    <li class="col col-xs-6 col-sm-2 col-lg-2 col-xl-8 col-xxl-10">
                        <div class="col_content">
                            <div class="image">
                                <a data-pjax = 0 href="<?= Url::toRoute([$value['pre_url'], 'parent'=>$value['parent'], 'children'=>$value['children'], 'user_id'=>$value['user_id']]) ?>">
                                    <?= $this->render('@app/views/blocks/thumbnail-img', [
                                        'url' => Yii::getAlias("@webroot/{$value['src']}"), 
                                        'width' => 220, 
                                        'height' => 254,
                                        'options'=>[
                                            'alt' => $value['name'],
                                        ]
                                    ]) ?>
                                </a>
                            </div>
                            <div class="name"><a data-pjax = 0 href="<?= Url::toRoute([$value['pre_url'], 'parent'=>$value['parent'], 'children'=>$value['children'], 'user_id'=>$value['user_id']]) ?>"><?= $value['name'] ?></a></div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <!--</div>-->
        </ul>
    </div>
    <?php Pjax::end(); ?>

<?php endif; ?>