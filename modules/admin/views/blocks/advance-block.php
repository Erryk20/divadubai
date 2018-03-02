<?php 
use app\models\UserInfo;
use app\models\ModelCategory;
use app\models\Countries;
use kartik\helpers\Html;
use kartik\select2\Select2;
use kartik\form\ActiveForm;

use app\models\ModelSubcategory;

?>
  <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'method' => 'POST',
            'id' => 'advance-search',
        ]); ?>

    <div class="wrap-grey">
        <span class="main-title">ADVANCE-SEARCH</span>
        <?php if(true || in_array('category_id', $filter['fields'])) : ?>
            <?= $form->field($filter, 'category2_id')->widget(Select2::classname(), [
                            'options' => [
                                'multiple' => false, 
                                'placeholder' => Yii::t('app', 'Select a category'),
                                'data-url'=>'/'.Yii::$app->request->pathInfo
                            ],
                            'data'=> ModelCategory::listChildCategories(),
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])
            ?>
        <?php endif; ?>
        

        <?php if(true || in_array('name', $filter['fields'])) : ?>
            <?= $form->field($filter, 'name2')->textInput() ?>
        <?php endif; ?>
        
        <?php if(true || in_array('id', $filter['fields'])) : ?>
            <?= $form->field($filter, 'id2')->textInput() ?>
        <?php endif; ?>
        
        <?= $form->field($filter, 'gender2')->dropDownList(UserInfo::itemAlias('gender'), ['prompt' => 'Select Gender']) ?>

        <?php if(true || in_array('visa_status', $filter['fields'])) : ?>
            <?= $form->field($filter, 'visa_status')->dropDownList(UserInfo::itemAlias('visa_status'), ['prompt' => '']) ?>
        <?php endif; ?>

        <?php if(true || in_array('nationality', $filter['fields'])) : ?>
            <?= $form->field($filter, 'nationality')->widget(Select2::classname(), [
                            'options' => [
                                'multiple' => false, 
                                'placeholder' => Yii::t('app', 'Select a nationality'),
                                'data-url'=>'/'.Yii::$app->request->pathInfo
                            ],
                            'data'=> Countries::getNationalities(),
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])
            ?>
        <?php endif; ?>
        
        <?php if(true || in_array('city', $filter['fields'])) : ?>
            <?= $form->field($filter, 'city')->checkboxButtonGroup(UserInfo::itemAlias('city')); ?>
        <?php endif; ?>
        
        <?php if(in_array('ethnicity', $filter['fields'])) : ?>
            <?= $form->field($filter, 'ethnicity')->checkboxButtonGroup(UserInfo::itemAlias('ethnicity')); ?>
        <?php endif; ?>
        
        <?php if(false && in_array('address', $filter['fields'])) : ?>
            <?= $form->field($filter, 'address')->textInput() ?>
        <?php endif; ?>
        
        <?php if(in_array(false && 'country', $filter['fields'])): ?>
                <?= $form->field($filter, 'country')->widget(Select2::classname(), [
                            'options' => [
                                'multiple' => false, 
                                'placeholder' => Yii::t('app', 'Select a country'),
                            ],
                            'data'=> Countries::getCountries(),
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])
            ?>
        <?php endif; ?>
        
        
        <?php if(false && in_array('bio', $filter['fields'])): ?>
                <?= $form->field($filter, 'bio')->textInput() ?>
        <?php endif; ?>
        
        <?php if(false && in_array('facebook', $filter['fields'])): ?>
                <?= $form->field($filter, 'facebook')->textInput() ?>
        <?php endif; ?>
        
        <?php if(false && in_array('twitter', $filter['fields'])): ?>
                <?= $form->field($filter, 'twitter')->textInput() ?>
        <?php endif; ?>
        
        <?php if(false && in_array('instagram', $filter['fields'])): ?>
                <?= $form->field($filter, 'instagram')->textInput() ?>
        <?php endif; ?>
        
        <?php if(false && in_array('youtube', $filter['fields'])): ?>
                <?= $form->field($filter, 'youtube')->textInput() ?>
        <?php endif; ?>
        
        <?php if(false && in_array('snapchat', $filter['fields'])): ?>
                <?= $form->field($filter, 'snapchat')->textInput() ?>
        <?php endif; ?>
        
        
        <?php if(false && in_array('collar', $filter['fields'])): ?>
            <?= $form->field($filter, 'collar')->dropDownList(UserInfo::itemAlias('collar'), ['prompt' => '']);  ?>
        <?php endif; ?>
        
        <?php if(false && in_array('chest', $filter['fields'])): ?>
            <?= $form->field($filter, 'chest')->dropDownList(UserInfo::itemAlias('chest'), ['prompt' => '']);  ?>
        <?php endif; ?>
        
        <?php if(false && in_array('waist', $filter['fields'])): ?>
            <?= $form->field($filter, 'waist')->dropDownList(UserInfo::itemAlias('chest'), ['prompt' => '']);  ?>
        <?php endif; ?>
        
        <?php if(false && in_array('suit', $filter['fields'])): ?>
            <?= $form->field($filter, 'suit')->dropDownList(UserInfo::itemAlias('suit'), ['prompt' => '']);  ?>
        <?php endif; ?>
        
        <?php if(false && in_array('pant', $filter['fields'])): ?>
            <?= $form->field($filter, 'pant')->dropDownList(UserInfo::itemAlias('suit'), ['prompt' => '']);  ?>
        <?php endif; ?>
        
        <?php if(false && in_array('hair', $filter['fields'])): ?>
            <?= $form->field($filter, 'hair')->checkboxButtonGroup(UserInfo::itemAlias('hair')); ?>
        <?php endif; ?>
        
        <?php if(false && in_array('hair_length', $filter['fields'])): ?>
            <?= $form->field($filter, 'hair_length')->checkboxButtonGroup(UserInfo::itemAlias('hair_length')); ?>
        <?php endif; ?>
        
        <?php if(false && in_array('eye', $filter['fields'])): ?>
            <?= $form->field($filter, 'eye')->checkboxButtonGroup(UserInfo::itemAlias('eye')); ?>
        <?php endif; ?>
        
        <?php if(in_array('language', $filter['fields'])): ?>
            <?= $form->field($filter, 'language')->checkboxButtonGroup(UserInfo::itemAlias('language')); ?>
        <?php endif; ?>
        
        <?php // vd($filter['_category'], false); ?>
        
        <?php if(in_array('subcategory', $filter['fields'])): ?>
            <?php foreach ($filter['_category'] as $key => $sub) : ?>
                <div class="form-group field-filterformadmin-category">
                    <label class="control-label col-md-2"><?= $key ?></label>
                    <div class="field col-sm-9 col-md-10">
                        <div class="form_checkboxes">
                            <div class="userinfo-subcategory">
                                <?php foreach ($sub as $key => $value) : ?>
                                    <div class="form_checkbox col-sm-6">
                                        <?php 
                                            if(in_array($key, array_keys($filter['subcategory_id']))){
                                                echo "<input type='checkbox' checked='checked' name='FilterFormAdmin[subcategory_id][{$key}]' id='{$key}'>";
                                            }else{
                                                echo "<input type='checkbox' name='FilterFormAdmin[subcategory_id][{$key}]' id='{$key}'>";
                                            }
                                            echo "<label for='{$key}'>{$value}</label>";
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>                        
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        
        
        <?php if(in_array('specialization', $filter['fields'])): ?>
            <div class="form-group field-filterformadmin-category">
                <label class="main_label col-md-2"><?= $filter->getAttributeLabel('specialization') ?></label>
                <div class="field col-sm-9 col-md-10">
                    <div class="form_checkboxes">
                        <div class="userinfo-subcategory">
                            <?php foreach (UserInfo::itemAlias('specialization') as $key => $value) : ?>
                                <div class="form_checkbox col-sm-6">
                                    <?php 
                                        if(in_array($key, array_keys($filter['specialization']))){
                                            echo "<input type='checkbox' checked='checked' name='FilterFormAdmin[specialization][{$key}]' id='{$key}'>";
                                        }else{
                                            echo "<input type='checkbox' name='FilterFormAdmin[specialization][{$key}]' id='{$key}'>";
                                        }
                                        echo "<label for='{$key}'>{$value}</label>";
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div> 
                    </div>
                </div>
            </div>	
        <?php endif; ?>
        
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
