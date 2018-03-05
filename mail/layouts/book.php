<?php
$domen = Yii::$app->getRequest()->hostInfo;

?>

<table bgcolor="#e1f3ff" width="100%" class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse: collapse; width:813px;">
    <tbody>
        <tr>
            <td valign="middle" class="center" style="font-size: 13px; padding: 25px;">
                <table bgcolor="#fff"  style="width:100%" class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" style="border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <td colspan="2" bgcolor="#FFFFFF" valign="middle" class="center" style="padding: 25px 25px 10px;text-align: center; background-color: rgba(191, 193, 193, 0.02);">
                                <img style="height:50%" src="<?= $domen ?>/images/ckeditor/diva-logo.png"/>
                            </td>
                        </tr>
                        <tr style="text-align: center; font-weight: bold;">
                            <td colspan="2" bgcolor="#FFFFFF" valign="middle" style="font-size: 15px; padding: 10px 25px 20px 25px; font-family: Arial, Helvetica, sans-serif; color: #444444; "> 
                                <p style="text-align:center;">hi&nbsp;Admin,</p>
                                <p style="text-align:center;">Here is the detail of Booking Form-PHOTOSHOOT :-</p>
                            </td>
                        </tr>
                        {{rows}}
                        <tr>
                            <td colspan="2" bgcolor="#FFFFFF" valign="middle" style="font-size: 15px; padding: 25px; font-family: Arial, Helvetica, sans-serif; color: #444444; line-height: 20px;">
                            </td>
                        </tr>
                        <tr><td valign="middle" style="padding: 25px;" align="center" bgcolor="#f9f9f9"></td></tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>