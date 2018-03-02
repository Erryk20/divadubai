<?php 
use yii\helpers\Url;
use kartik\helpers\Html;

//$shares = \app\models\Share::getAllShare();

//vd($shares);
//vd($shares);


?>
<div class="footer_content container">
    <div class="row">
        <div class="col-sm-2"><div class="logo_footer"><a href="/"><img src="/images/logo_footer.png" alt=""></a></div></div>
        <div class="menu_wrapper">
            <ul class="menu col col-xs-6 col-sm-1 col-sm-offset-1">
                <li><a href="<?= Url::toRoute(['site/about-us']) ?>">About Us</a></li>			
                <li><?= Html::a('Services', ['site/services']) ?></li>			
                <li><a href="<?= Url::toRoute(['site/our-work', 'url'=>'ourwork']) ?>">Our Work</a></li>			
                <li><a href="<?= Url::toRoute(['/site/training']) ?>">Training</a></li>			
            </ul>
            <ul class="menu col col-xs-6 col-sm-1 col-sm-offset-1">
                <li><a href="<?= Url::toRoute(['/register']) ?>">Register</a></li>			
                <li><a href="<?= Url::toRoute(['/site/office']) ?>">Office</a></li>			
                <li><a href="<?= Url::toRoute(['/clients']) ?>">clients</a></li>			
                <li><a href="<?= Url::toRoute(['/frequentlyaskedquestions']) ?>">FAQ</a></li>			
            </ul>
        </div>
        <div class="col-sm-3 col-sm-offset-3 info_footer">
            <div class="info_text">
                <p>
                    Get In Touch: <a href="tel:97144227272">+971 (4) 422 7272</a> <br>
                </p>
                <p>
                    For Model Registration: <a href="tel:971529185083">+971 52 9185083</a> <br>
                </p>
                <p>
                    For Client Enquiries: <a href="tel:971553421613">+971 55 3421613</a> <br>
                </p>
                <p>Write to Us: <a href="mailto:enquiry@divadubai.com">enquiry@divadubai.com</a></p>
            </div>
            <div class="social_wrapper">
                <div class="social_wrapper">
                    <div class="social social_0">
                        <a href="https://www.linkedin.com/company/diva-modelling-and-events/" target="_blank"></a>                    
                    </div>
                    <div class="social social_1">
                        <a href="https://www.linkedin.com/company/diva-modelling-and-events/" target="_blank"></a>                    
                    </div>
                    <div class="social social_2">
                        <a href="https://www.facebook.com/divadubaimodels" target="_blank"></a>                    
                    </div>
                    <div class="social social_3">
                        <a href="https://www.instagram.com/divadubaimodels/" target="_blank"></a>                   
                    </div>
                    <div class="social social_4">
                        <a href="https://twitter.com/Diva_Dubai" target="_blank"></a>                    
                    </div>
                    <div class="social social_5">
                        <a href="https://www.youtube.com/user/divamodelling" target="_blank"></a>                    
                    </div>
                    <div class="social social_6">
                        <a href="https://vimeo.com/user29488302/videos" target="_blank"></a>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>