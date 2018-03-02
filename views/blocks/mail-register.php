<?php 
use kartik\helpers\Html;

?>

<!DOCTYPE html>
<html>
    <body>
        <table border="0" style="width: 860px;margin: 0 auto;">
            <tr>
                <td>
                    <?= Html::img("{$domen}/images/diva-logo.png", ['width'=>"300", 'style'=>'display: table; margin: 0 auto;']) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <p>"You are registered on the website <?= $domen ?>. Wait until the admin gets in touch with you and approve your registration</p>
                </td>
            </tr>
        </table>
        <table border="0" style="width: 860px;margin: 0 auto; font-size: 14px; text-align: center;">
            <tr>
                <td>For Client Enquiries: +971 55 3421613</td>
            </tr>
            <tr>
                <td>Write to Us: enquiry@divadubai.com</td>
            </tr>
        </table>
    </body>
</html>