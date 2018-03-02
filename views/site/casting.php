<?php 
use kartik\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use himiklab\yii2\recaptcha\ReCaptcha;
use yii\widgets\LinkPager;

$this->title = 'Casting for production';
$this->params['breadcrumbs'][] = $this->title;

$user_id = Yii::$app->user->id;

?>

<div class="view_casting clearfix">
    <?php foreach ($list as $key => $value) : ?>
    <?= (($key%2) == 0) ? "<div class='row'>" : null ?> 
    <div class="col-sm-6 col" id="<?= "casting-id-{$value['id']}" ?>">
            <div class="image">
                <?= Html::img(
                            $this->render(
                                '@app/views/blocks/thumbnail-url-resize', 
                                [
                                    'url' => Yii::getAlias("@webroot/images/casting/{$value['src']}"), 
                                    'width' => 540
                                ]),
                            ['height'=>"276"]
                ); ?>
                                                            
                <?php // = $this->render(
//                        '@app/views/blocks/thumbnail-img', 
//                        [
//                            'url' => Yii::getAlias("@webroot/images/casting/{$value['src']}"), 
//                            'width' => 540, 
//                            'height' => 276
//                        ]
//                ) ?>
                <?php // = Html::img("/images/casting/{$value['src']}")  ?>
            </div>
            <div class="title"><?= $value['title'] ?></div>
            <div class="casting_info">
                <div class="item">
                    <div class="info_label">Gender:</div>
                    <div class="value"><?= $value['gender'] ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Fee:</div>
                    <div class="value"><?= $value['fee'] ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Casting Date:</div>
                    <div class="value"><?= date('Y-m-d', $value['casting_date']) ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Time from:</div>
                    <div class="value"><?= $value['time_from'] ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Time to:</div>
                    <div class="value"><?= $value['time_to'] ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Job Date:</div>
                    <div class="value"><?= date('Y-m-d', $value['job_date']) ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Location address:</div>
                    <div class="value"><?= $value['location'] ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Booker name:</div>
                    <div class="value"><?= $value['booker_name'] ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Booker's number:</div>
                    <div class="value"><?= $value['bookers_number'] ?></div>
                </div>
                <div class="item">
                    <div class="info_label">Casting details:</div>
                    <div class="value"><?= $value['details'] ?></div>
                </div>
            </div>
            <?= Html::a('Apply', null, [
                'data-id'=>$value['id'], 
                'class'=>"btn btn-default", 
                'data-toggle'=>"modal", 
                'data-target'=>"#castingModal"
            ]) ?>
            
            <?= Html::a('Add Favorite', null, [
                'class'=>"btn btn-default add-favorite-casting", 
                'data-url'=> Url::toRoute(['/ajax/add-favorite-casting', 'id'=>$value['id']]),
            ]) ?>
        </div>
        <?= ((($key%2) == 1) | ($key == $count)) ? "</div>" : null ?> 
    <?php endforeach; ?>
</div>
<div class="pagination-div">
    <?= LinkPager::widget(['pagination' => $pages]);?>
</div>

<!--$model-->
<div class="modals_wrap">
    <div id="castingModal" class="casting_modal modal fade">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">Close</button>
                <div class="form_title">Fill in your details for casting call</div>
            </div>
            <div class="modal-content">
                <?php $form = ActiveForm::begin(); ?>
                
                    <?= $form->field($model, 'casting_id')->hiddenInput(['class'=>"hide_input"])->label(false); ?>
                
                    <?= $form->field($model, 'name')->textInput(['placeholder'=>"Name *", 'class'=>'form-control form_text'])->label(false); ?>
                
                    <?= $form->field($model, 'email')->textInput(['placeholder'=>"Email ID *", 'class'=>'form-control form_text'])->label(false); ?>
                
                    <?= $form->field($model, 'phone')->textInput(['placeholder'=>"Phone NO", 'class'=>'form-control form_text'])->label(false); ?>
                
                    <?= $form->field($model, 'message')->textarea(['placeholder'=>"Message", 'class'=>"form-control form_textarea"])->label(false); ?>

                    <div class="form-group">
                        <div class="description">Note: Please add your ID number or register with Diva</div>
                    </div>
                   
                    <div class="form_actions">
                        <?= $form->field($model, 'reCaptcha')->widget(ReCaptcha::className())->label(false) ?>
                        <input type="submit" class="btn btn-default" value="Send">
                        <div class="cancel_btn" data-dismiss="modal">Cancel</div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>