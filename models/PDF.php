<?php
namespace app\models;

use Yii;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class PDF
{
    
    
    public static function getUserInfo($id){
        $query = "
            SELECT
                CONCAT(COALESCE(ui.last_name, ''), ' ', COALESCE(ui.`name`, '')) AS fulllName,
                mc.`name` AS 'category',
                ui.email,
                ui.name,
                ui.nationality, 
                ui.ethnicity,
                ui.id, 
                ui.height, 
                ui.chest, 
                ui.waist, 
                ui.hips, 
                ui.shoe, 
                ui.hair, 
                ui.eye
            FROM user_info ui
            LEFT JOIN `user` u ON u.id = ui.user_id
            LEFT JOIN model_category mc ON mc.id = ui.category_id
            WHERE ui.id = :id
        ";
        
        $result = Yii::$app->db->createCommand($query, [':id'=>$id])->queryOne();
        
        $result['hair'] = preg_replace('/\["([a-z]*)"\]?/', '$1', $result['hair']);
        $result['eye'] = preg_replace('/\["([a-z]*)"\]?/', '$1', $result['eye']);
        
        $ethnicity  = $result['ethnicity'] ? json_decode($result['ethnicity']) : [];
        $result['ethnicity'] = implode(", ",$ethnicity);
        
        return $result;
    }
    
    public static function savePdf($id){
        $domen = Yii::$app->getRequest()->hostInfo;

        $info = self::getUserInfo($id);
        $list = \app\models\UserMedia::getListMediaFromUser($id);

        $content = Yii::$app->controller->renderPartial('@app/views/download/pdf-html', [
            'info' => $info,
            'list' => $list,
            'domen' => $domen,
        ]);
        
        $pdf = Yii::$app->pdf;
        $pdf->methods = [ 
            'SetHeader'=>['www.divadubai.com'], 
            'SetFooter'=>['{PAGENO}'],
        ];
        $pdf->destination = \kartik\mpdf\Pdf::DEST_FILE;
        $pdf->content = $content;
        $pdf->filename = Yii::getAlias("@webroot/pdf/{$info['id']}.pdf");
        $pdf->render();
    }
}
