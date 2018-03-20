<?php
namespace app\controllers;

use Yii;
//use app\components\Controller;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Url;
use app\models\Products;

use kartik\mpdf\Pdf;


class DownloadController extends Controller {
    
    public $seo = [
        'title'=>'',
        'keywords'=>'',
        'description'=>'',
    ];
    
    
    public function actionFavorite(){
        
        $fileName = '';
        $nawDate = date('Y-m-d', time());
        
        
        if(Yii::$app->user->isGuest){
            $session = Yii::$app->session;
            $favourites = $session->get('favourite');
            
            
            $models = \app\models\Favourite::getListItems($favourites, 1000);
            
            $user_id = rand(5, 15);
            
            $path = \Yii::getAlias("@webroot/temp/pdf/{$nawDate}/{$user_id}");
        }else{
            $user_id = Yii::$app->user->id;
            
            $models = \app\models\Favourite::getListItemsUser('', $user_id, 1000);
            $path = \Yii::getAlias("@webroot/temp/pdf/{$nawDate}/{$user_id}");
        }
        
        is_dir($path) ?: mkdir($path, 0775, true);
        
        $domen = Yii::$app->getRequest()->hostInfo;
        
        foreach ($models AS $value){
            $info = \app\models\PDF::getUserInfo($value['info_user_id']);
            $list = \app\models\UserMedia::getListMediaFromUser($value['info_user_id']);
//            list($width, $height) = getimagesize($list['logo']);

            
            $content = $this->renderPartial('pdf-html', [
                'info' => $info,
                'list' => $list,
                'domen' => $domen,
//                'width' => $width,
//                'height' => $height,
            ]);
            
            $pdf = new Pdf([
                'marginLeft' => 25,
                'marginRight' => 25,
                'marginTop' => 10,
                'marginBottom' => 10,
                'destination' => Pdf::DEST_FILE,
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_LANDSCAPE,
//                'methods' => [
//                    'SetHeader'=>['www.divadubai.com'], 
//                    'SetFooter'=>['{PAGENO}'],
//                ],
                'content' => $content,
                'filename' => "{$path}/{$info['id']}.pdf",
            ]);
            $pdf->render();
        }
        
        
        $pathdir= "{$path}/"; // путь к папке, файлы которой будем архивировать
        $nameArhive = "{$path}/favourite.zip"; //название архива
        $zip = new \ZipArchive(); // класс для работы с архивами
        if ($zip -> open($nameArhive, $zip::CREATE) === TRUE){ // создаем архив, если все прошло удачно продолжаем
            $dir = opendir($pathdir); // открываем папку с файлами
            while( $file = readdir($dir)){ // перебираем все файлы из нашей папки
                    if (is_file($pathdir.$file)){ // проверяем файл ли мы взяли из папки
                        $zip -> addFile($pathdir.$file, $file); // и архивируем
                        //echo("Заархивирован: " . $pathdir.$file) , '<br/>';
                    }
            }
            $zip -> close(); // закрываем архив.
            //echo 'Архив успешно создан';
            
//        Высылаем пользователю архив
        header ("Content-Type: application/octet-stream");
        header ("Accept-Ranges: bytes");
        header ("Content-Length: ".filesize($nameArhive));
        header ("Content-Disposition: attachment; filename=favourite.zip");  
        readfile($nameArhive);
        
        //Удаляем файл
        $this->dirDel($path); 
//        unlink($nameArhive);
        }else{
            die ('Произошла ошибка при создании архива');
        }
        die();
    }
    
    
    public function actionPdfProfile($id){
//        header("Content-Type: application/force-download");    
//        header("Content-Disposition: attachment; filename={$id}.pdf");
//        
////        vd($id);
//        $path = \Yii::getAlias("@webroot/pdf/{$id}.pdf");
//        vd($path);
//        
//        return $this->renderPartial($path);
//        
//        die();
//        return;
//        
        
        
        $domen = Yii::$app->getRequest()->hostInfo;

        $info = \app\models\PDF::getUserInfo($id);
        $list = \app\models\UserMedia::getListMediaFromUser($id);
//        list($width, $height) = getimagesize($list['logo']);

        $newlogo = Yii::$app->request->post('main');
        $oldLogo = $list['logo'];
        
        $list['logo'] = $newlogo;
        $idImage = array_search($newlogo, $list['image']);
        if($idImage){
            $list['image'][$idImage] = $oldLogo;
        }
        

        
        $content = $this->renderPartial('pdf-html', [
            'info' => $info,
            'list' => $list,
            'domen' => $domen,
//            'width' => $width,
//            'height' => $height,
        ]);
        
        $pdf = Yii::$app->pdf;
//        $pdf->methods = [ 
//            'SetHeader'=>['www.divadubai.com'], 
//            'SetFooter'=>['{PAGENO}'],
//        ];
        $pdf->destination = Pdf::DEST_DOWNLOAD;
        $pdf->content = $content;
        
        $pdf->marginLeft = 10;
        $pdf->marginRight = 10;
        $pdf->marginTop = 1;
        $pdf->marginBottom = 1;
        $pdf->filename = "{$info['id']}.pdf";
        
        return $pdf->render();
    }
    
    
    public function actionPrintPdfProfile($id){
        $domen = Yii::$app->getRequest()->hostInfo;

        $info = \app\models\PDF::getUserInfo($id);
        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
//        list($width, $height) = getimagesize($list['logo']);
       
        $content = $this->renderPartial('pdf-html', [
            'info' => $info,
            'list' => $list,
            'domen' => $domen,
//            'width' => $width,
//            'height' => $height,
        ]);
        
        $pdf = Yii::$app->pdf;
//        $pdf->methods = [ 
//            'SetHeader'=>['www.divadubai.com'], 
//            'SetFooter'=>['{PAGENO}'],
//        ];
        $pdf->destination = Pdf::DEST_BROWSER;
        $pdf->marginLeft = 25;
        $pdf->marginRight = 25;
        $pdf->marginTop = 10;
        $pdf->marginBottom = 10;
        $pdf->content = $content;
        $pdf->filename = "{$info['id']}.pdf";
        
        return $pdf->render();
    }
    
    public function actionHtmlPdf($id){
        $domen = Yii::$app->getRequest()->hostInfo;

        $info = \app\models\PDF::getUserInfo($id);
        $list = \app\models\UserMedia::getListMediaFromUser($id);
//        list($width, $height) = getimagesize($list['logo']);

        return $this->renderPartial('pdf-html', [
            'info' => $info,
            'list' => $list,
            'domen' => $domen,
//            'width' => $width,
//            'height' => $height,
        ]);
    }
    
    public function dirDel($dir) {
        $d = opendir($dir);
        while (($entry = readdir($d)) !== false) {
            if ($entry != "." && $entry != "..") {
                if (is_dir($dir . "/" . $entry)) {
                    dirDel($dir . "/" . $entry);
                } else {
                    unlink($dir . "/" . $entry);
                }
            }
        }
        closedir($d);
        rmdir($dir);
    }

    public function actionTest($gender, $id){
        $this->layout = 'profile';
        
        $model = \app\models\ModelManagement::getUserInfoFromManagement($id);
        
        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
        $nextPrev = \app\models\UserCategory::getNextLastUserGender($id, 'model-management', $gender);
        
        return $this->render('model-management-profile', [
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'pre_url' => '/site/service-profile',
        ]);
    }
}
