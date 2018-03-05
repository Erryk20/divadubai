<?php 
use yii\helpers\Html;


$filter = Yii::$app->controller->filter;
if(isset($_GET['t'])){
    
    vd($filter);
}
?>

<div class="all_parameters">
    <form>
        <div class="col_group clearfix">
            <div class="form_col">
                <div class="form-group">
                    <?php 
                        echo "<label class='main_label'>Name</label>";
                        if($filter['name']){
                            echo "<input type='text' value='{$filter['name']}' class='form-control form_text' name='FilterForm[name]'>";
                        }else{
                            echo "<input type='text' class='form-control form_text' name='FilterForm[name]'>";
                        }
                    ?>
                </div>
                
                <?php if(isset($filter['_gender'])) : ?>
                    <div class="form-group clearfix">
                        <label class="main_label col-md-2" style="margin-top: 9px;">Gender</label>
                        <div class="field col-sm-9 col-md-10" style="padding: 0;">
                            <?= Html::dropDownList('FilterForm[gender]', null, $filter['_gender'], [
                                'class' => 'form-control', 
                                'prompt' => 'Select...',
                                'style'=>'border-radius: 0;'

                            ]); ?>
                        </div>
                    </div>
                <?php endif; ?> 

                <?php if(isset($filter['_ethnicity'])) : ?>
                    <div class="form-group clearfix">
                        <label class="main_label">Ethnicity</label>
                        <div class="field">
                            <div class="form_checkboxes">
                                <?php foreach ($filter['_ethnicity'] as $key => $value) : ?>
                                    <div class="form_checkbox">
                                        <?php 
                                            if($filter['ethnicity']){
                                                if(in_array($key, array_keys($filter['ethnicity']))){
                                                    echo "<input type='checkbox' checked='checked' name='FilterForm[ethnicity][{$key}]' id='{$key}'>";
                                                }else{
                                                    echo "<input type='checkbox' name='FilterForm[ethnicity][{$key}]' id='{$key}'>";
                                                }
                                            }else{
                                                echo "<input type='checkbox' name='FilterForm[ethnicity][{$key}]' id='{$key}'>";
                                            }
                                            echo "<label for='{$key}'>{$value}</label>";
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <!--length-->
            <?php if($filter['_category']) : ?>
                    <?php if(true || in_array($filter['action'], ['our-works', 'photographers'])) : ?>
            
                        <div class="form_col <?= ($filter['length'] == 1) ? "form_col_photo" : null ?>">
                            
                        <?php foreach ($filter['_category'] as $key => $value) : ?>
                                <div class="form-group clearfix">
                                    <label class="main_label"><?= $key ?></label>
                                    <div class="field">
                                        <div class="form_checkboxes">
                                            <?php foreach ($value as $k => $item) : ?>
                                                <?php if(!in_array($item, ['New face','Hair and Make', 'Hair & make'])) : ?> 
                                                    <div class="form_checkbox">
                                                        <?php 
                                                            if($filter['subcategory']){
                                                                if(in_array($k, array_keys($filter['subcategory']))){
                                                                    echo "<input type='checkbox' checked='checked' name='FilterForm[subcategory][{$k}]' id='{$k}'>";
                                                                }else{
                                                                    echo "<input type='checkbox' name='FilterForm[subcategory][{$k}]' id='{$k}'>";
                                                                }
                                                            }else{
                                                                echo "<input type='checkbox' name='FilterForm[subcategory][{$k}]' id='{$k}'>";
                                                            }
                                                            echo "<label for='{$k}'>{$item}</label>";
                                                        ?>
                                                    </div>
                                                <?php endif; ?> 
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                        <?php endforeach; ?>
                            
                        <?php if(isset($filter['_AGE'])) : ?>
                            <?php foreach ($filter['_AGE'] as $key => $value) : ?>
                                <div class="form-group clearfix">
                                    <label class="main_label"><?= $key ?></label>
                                    <div class="field">
                                        <div class="form_checkboxes">
                                            <?php foreach ($value as $k => $name) : ?>

                                                <div class="form_checkbox">
                                                    <?php 
                                                        if($filter['age']){
                                                            if($filter['age'] == $k){
                                                                echo "<input type='radio' checked='checked' name='FilterForm[age]' value='$k' id='{$k}'>";
                                                            }else{
                                                                echo "<input type='radio' name='FilterForm[age]' value='$k' id='{$k}'>";
                                                            }
                                                        }else{
                                                            echo "<input type='radio' name='FilterForm[age]' value='$k' id='{$k}'>";
                                                        }
                                                        echo "<label for='{$k}'>{$name}</label>";
                                                    ?>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif ?>
            
            <?php if(isset($filter['_language'])) : ?>
            <div class="form_col">
                <div class="form-group clearfix">
                    <label class="main_label">Language</label>
                    <div class="field">
                        <div class="form_checkboxes">
                            <?php foreach ($filter['_language'] as $key => $value) : ?>
                                <div class="form_checkbox">
                                    <?php 
                                        if($filter['language']){
                                            if(in_array($key, array_keys($filter['language']))){
                                                echo "<input type='checkbox' checked='checked' name='FilterForm[language][{$key}]' id='{$key}-lang'>";
                                            }else{
                                                echo "<input type='checkbox' name='FilterForm[language][{$key}]' id='{$key}-lang'>";
                                            }
                                        }else{
                                            echo "<input type='checkbox' name='FilterForm[language][{$key}]' id='{$key}-lang'>";
                                        }
                                        echo "<label for='{$key}-lang'>{$value}</label>";
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif ?>
                            
            <?php if(isset($filter['_specialization'])) : ?>
            <div class="form_col">
                <div class="form-group clearfix">
                    <label class="main_label">Specialization</label>
                    <div class="field">
                        <div class="form_checkboxes">
                            <?php foreach ($filter['_specialization'] as $key => $value) : ?>
                                <div class="form_checkbox">
                                    <?php 
                                        if($filter['specialization']){
                                            if(in_array($key, array_keys($filter['specialization']))){
                                                echo "<input type='checkbox' checked='checked' name='FilterForm[specialization][{$key}]' id='{$key}'>";
                                            }else{
                                                echo "<input type='checkbox' name='FilterForm[specialization][{$key}]' id='{$key}'>";
                                            }
                                        }else{
                                            echo "<input type='checkbox' name='FilterForm[specialization][{$key}]' id='{$key}'>";
                                        }
                                        echo "<label for='{$key}'>{$value}</label>";
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif ?>

            <div class="form_col submit_col">
                <div class="form_actions clearfix">
                    <input type="submit" class="btn btn-default" value="Search">
                    <a href="#" class="close_form">Close parameters</a>
                </div>
            </div>
        </div>
    </form>
</div>