<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


$this->registerJsFile('https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js');
?>

<?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
<div class="login_form bookingprocess">
    <section class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'name')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'client_id')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'booked_as')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'booker_name')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'contact_number')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'job_number')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'amount')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'client_name')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'requirement')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'usage_for')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'period')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'date_of_shoot')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
            <?= $form->field($model, 'location')->textInput(['disabled' => $disabled, 'class' => 'form_text']) ?>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <b><u>Rules to be followed by Model</u></b>
            <p style="text-align: justify;"><b>punctuality:</b> Should you foresee you will be arriving late to the job location/ venue, you are requested to call your booker a minimum of four hours in advance.<br /><br />
                <b>Conditions:</b> Remember, you are representing Diva Modeling & Events and the client at all times while on the job.</p>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <p>As requested under Diva regulations</p>
            <ol type="1" class="list_simple_point">
                <li>Canvassing the client for future jobs/getting contact details of clients/no show up for the jobs/re-negotiation of remuneration will lead to immediate termination and a penalty of AED 3,000.00</li>
                <li>Any forms of complaints or misconduct will lead to a warning from the agency.</li>
                <li>Should the client dismiss you thus will lead to no payment.</li>
                <li> If you encounter problems with the client please contact a Diva booker right away.</li>
                <li>Please, no smoking or drinking during your working hours.</li>
                <li>Please keep the Diva Representative aware of your whereabouts if you step out from shoot location.</li>
                <li>Enjoy yourself!  Be professional as you are representing yourself and Diva Modeling & Events.</li>

            </ol>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <b>Model Agreement:</b>
            <ul class="list_simple_point">
                <li>I understand that the compensation mentioned above will be accepted as full and final payment for my services rendered and rights granted and would be expected within a tenure of 60 days from day of job completion.</li>
                <li>  I also understand that the full aforementioned compensation would only be payable by the agency on satisfactory completion of the job.</li>
                <li>  I understand I will not receive any further compensation in connection with this production / event / promotion.</li>
                <li>  I hereby waive any right to use of my likeness.</li>
            </ul>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <b>Payment Terms:</b>
            <ul class="list_simple_point">
                <li>Cheque collection is every 1st, 2nd and 3rd Thursday of the month between 01pm to 5pm in Diva Office.</li>
                <li>For payment follow up please email at<u style="color:blue"> Office@divadubai.com </u> (please cc your booker for the job).</li>
                <li> Kindly bring a copy of the booking form upon collecting your payment</li>
                <li>Payment will be made after 30/60 days of job completion or whenever the client pays</li>
            </ul>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <p style="text-align: justify;">I hereby authorize Diva Modelling & Events and the client to use film/photography containing my likeness for the use of the above description. I understand that such copyright material shall be deemed to represent any character unless agreed in otherwise by my agent or myself. In connection therewith, I hereby release Diva Modeling & Events and the client from all liability.
                Please confirm all of the above. Reply with signed form via e-mail or fax (+971 4422 7422)
            </p>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'user_name')->textInput()->label('Name') ?>
            <?= $form->field($model, 'ac_number')->textInput()->label('Account Number') ?>
            <?= $form->field($model, 'last_date')->textInput()->label() ?>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="view_signing clearfix">
                <div class="view_content">
                    <div id="sign_1" class="tab-pane active">
                        <div id="signature-pad" class="signature-pad">
                                <div class="signature-pad--body">
                                    <?php if($model->scenario == 'site') : ?>
                                        <canvas></canvas>
                                        <div class="text">Sign your name using trackpad, mouse or touch device.</div>
                                    <?php else : ?>
                                        <?= Html::img("/images/bookingprocess/{$model->signature}"); ?>
                                    <?php endif; ?>
                                </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="form_actions clearfix">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-default', 'id'=>'signature-btn', 'data-url'=>Url::toRoute(['/ajax/bookingprocess', 'id'=>$model['id']])]) ?>
    </div>
</div>




<?php ActiveForm::end(); ?>
