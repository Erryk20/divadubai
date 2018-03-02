<?php 
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;
use kartik\form\ActiveForm;

if(Yii::$app->session->hasFlash('success')):
    $message = Yii::$app->session->getFlash('success'); 
    $this->registerJs("$.jGrowl('{$message}',  {theme:'bg-green'});", \yii\web\View::POS_END);
endif; 

$model = new \app\models\SearchForm();
$model->search = Yii::$app->request->get('q');

$format = <<< SCRIPT
    var dataResult;
        
    function redirect(){
        var id = $('#searchform-search').val();
        $.each(dataResult.results, function( index, value ) {
            console.log(value.url, id);
            if(id == value.id) window.location = value.url;
        });
    };
        
    function format(state) {
        if (!state.id) return state.text;
        return '<a href="' + state.url + '">' + state.text + '</a>';
    }
SCRIPT;
    
$escape = new JsExpression("function(m) { return m; }");
$this->registerJs($format, View::POS_HEAD);

?>
<div class="header_contacts">
    <div class="container">
        <div class="text">
            <span>Get In Touch: <a href="tel:+97144227272">+971 (4) 422 7272</a></span>
            <span>Model Registration: <a href="tel:+971 52 9185083">+971 52 9185083</a></span>
            <span>For Client Enquiries: <a href="tel:+971553421613">+971 55 3421613</a></span>
            <span>Write to Us: <a href="mailto:enquiry@divadubai.com">enquiry@divadubai.com</a></span>	
        </div>
    </div>
</div>
<nav class="main_menu">
    <?= $this->render('@app/views/blocks/menu-clearfix') ?>
</nav> 
<div class="header_content clearfix">
    <div class="dropdown_menu">
        <div class="menu_btn">
            <div class="item_1 item">-</div>
            <div class="item_2 item">-</div>
            <div class="item_3 item">-</div>		
        </div>
        <div class="menu_show">
            <?= $this->render('@app/views/blocks/menu-maine') ?>
        </div>
    </div>
    <div class="search_block">
        <a href="<?= Url::toRoute(['/site/favourite']) ?>" class="cart_btn">Cart</a>
        <div class="search_btn">Search</div>
        <div class="search_form">
            
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action'=>'/search',
                    'fieldConfig' => ['template' => "{input}"]]); ?>
                
                <?= $form->field($model, 'search')->textInput(
                    [
                        'class'=>"form_text search-user",
                        'name'=>'q',
                        'maxlength' => true, 
                        'placeholder'=> 'Search'
                    ])
//                (Select2::classname(), [
////                    'initValueText' => $cityDesc, // set the initial display text
//                    'options' => [
//                        'class'=>"form_text search-user",
//                        'name'=>'q',
//                        'maxlength' => true, 
//                        'placeholder'=> 'Search'
//                    ],
//                    'changeOnReset'=> true,
//                    'pluginOptions' => [
//                        'allowClear' => true,
//                        'minimumInputLength' => 2,
//                        'ajax' => [
//                            'url' => Url::toRoute(['/ajax/search']),
//                            'dataType' => 'json',
//                            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
//                            'success' => new JsExpression('function(data){dataResult = data;}'),
//                        ],
//                        'templateResult' => new JsExpression('format'),
//                        'escapeMarkup' => $escape,
//                    ],
//                    'pluginEvents'=>[
//                        "change" => "function() {redirect()}",
//                    ] 
//                ])
                ?>
                <!--<input type="text" class="form_text" placeholder="Search">-->
                <input type="submit" class="form_submit" value="Search">
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="logo"><a href="/"><img src="/images/logo_inner.png" alt="Diva | Modeling & Events FZ - LLC"></a></div>
</div>