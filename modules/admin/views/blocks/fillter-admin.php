<?php 
use kartik\helpers\Html;
use kartik\select2\Select2;
use kartik\form\ActiveForm;
use app\models\ModelCategory;

?>


<div class="row fillter-admin">
    <?php
    $form = ActiveForm::begin([
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'method' => 'GET'
    ]);
    ?>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="wrap-grey">
            <span class="main-title">INDEX-SEARCH</span>

        <?= $form->field($filter, 'category_id')->widget(Select2::classname(), [
            'options' => [
                'multiple' => false,
                'placeholder' => Yii::t('app', 'Select a category'),
                'data-url' => '/' . Yii::$app->request->pathInfo
            ],
            'data' => ModelCategory::listCategories(),
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]) ?>


<?= $form->field($filter, 'name')->textInput() ?>
            <?= $form->field($filter, 'id')->textInput() ?>


            <?php // = $form->field($filter, 'gender')->dropDownList(UserInfo::itemAlias('gender'), ['prompt' => 'Select Gender']) ?>

            <?=
            $form->field($filter, 'phone', [
                'addon' => [
                    'prepend' => [
                        'content' => $form->field($filter, 'prepend_phone', ['options' => ['class' => 'prep-input']])
                                ->dropDownList(\app\models\Countries::getPrependPhones(), ['prompt' => ''])->label(false),
                        'asButton' => true
                    ]
                ]
                    ]
            )->textInput(['maxlength' => 14, 'placeholder' => $filter->getAttributeLabel('phone')])
            ?>

<?= $form->field($filter, 'email')->textInput(['maxlength' => true]) ?>
            <div class="form-group">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
        <?php ActiveForm::end(); ?>

    <div class="col-md-6 col-sm-12 col-xs-12" id="advance-block">
<?= $this->render('@app/modules/admin/views/blocks/advance-block', ['filter' => $filter]) ?>
    </div>

</div>