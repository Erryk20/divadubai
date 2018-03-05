<?php
namespace app\controllers;

use Yii;
//use app\components\Controller;
use yii\web\Controller;
use \yii\web\Response;
use yii\helpers\Url;
use app\models\Products;


class AjaxController extends Controller {
    
    public function beforeAction($action) {
        $this->enableCsrfValidation = !in_array($action->id, ['ipn', 'send-to-email-profile']); 
        return parent::beforeAction($action);
    }
    
    public function actionSendEmail()
    {
        $request = Yii::$app->request;
        $model = new \app\models\Email(['scenario'=>'profile-send']);
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            if($model->load($request->post()) && $model->sendEmailToContact()){
                $model = new \app\models\Email(['scenario'=>'profile-send']);
                return [
                    'status' => true,
                    'html'=> $this->renderAjax(
                            '@app/views/blocks/modal-email', 
                            [
                                'model'=> new \app\models\Email(['scenario'=>'profile-send']), 
                                'action'=>'/ajax/send-email',
                            ])
                ];
            }else{  
                return [
                    'status' => false,
                    'html'=> $this->renderAjax(
                            '@app/views/blocks/modal-email', 
                            [
                                'model'=> $model, 
                                'action'=>'/ajax/send-email',
                            ])
                ];
            }
        }
    }
    
    
    
    
//    public function actionModelManagement($page){
//        
////        $this->filter = new \app\models\FilterForm();
////        $this->filter->setForm('Models');
////        $this->filter->load(Yii::$app->request->get());
////        
////        $list = \app\models\ModelManagement::getList($gender, $this->filter, $limit = 40, $ofsset = 0);
//        
//        return $this->renderPartial('@app/views/test/blosk');
//    }
    
    
     public function actionSendEmailProfile($id)
    {
        $request = Yii::$app->request;
        $model = new \app\models\Email(['scenario'=>'profile-send']);
        
        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            
            if($model->load($request->post()) && $model->sendEmailProfile($id)){
                $model = new \app\models\Email(['scenario'=>'profile-send']);
                return [
                    'status' => true,
                    'html'=> $this->renderAjax('@app/views/blocks/modal-email-profile', ['model' => $model, 'id'=>$id])
                ];
            }else{  
                return [
                    'status' => false,
                    'html'=> $this->renderAjax('@app/views/blocks/modal-email-profile', ['model' => $model, 'id'=>$id])
                ];
            }
        }
    }
    
    public function actionSearch($q){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        
        $list = \app\models\SearchForm::resultSearch($q);
        
        $out['results'] = array_values($list);
        return $out;
    }
    
    
    public function actionSearchUser($q){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        
        $list = \app\models\SearchForm::resultSearchUser($q);
        
        $out['results'] = array_values($list);
        return $out;
    }
    
    
    public function actionUploadImage(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(!empty($_FILES)){
            $upload = new \app\models\File();
            $upload->file = \yii\web\UploadedFile::getInstanceByName("canvasImage");
            
            $path = \Yii::getAlias("@webroot/images/user-media/");
            if ($upload->uploadCanvas($path)) {
                
                $pathWatermark = '@webroot/images/watermark.png';
                $pathImage = "@webroot/images/user-media/{$upload->url}";
                \app\models\File::addWatermark($pathWatermark, $pathImage, $upload->url, true);
                
                return [
                    'status' => true,
                    'name' => $upload->url
                ];
            }
            
        }else{
            return [
                    'status' => false,
                    'message' => 'Error. Upload another image'
                ];
        }  
        
            
            Yii::$app->response->format = Response::FORMAT_JSON;
            $img = $_POST['undefined'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            
            $ip = $_SERVER['REMOTE_ADDR'];
            $extension = '.jpg';
            
            $name = hash('ripemd160', $ip.time()).$extension;
            $file =  Yii::getAlias("@webroot/images/user-media/{$name}");
            
            
            if (file_put_contents($file, $data)) {
                
                $pathWatermark = '@webroot/images/watermark.png';
                $pathImage = "@webroot/images/user-media/{$name}";
                \app\models\File::addWatermark($pathWatermark, $pathImage, $name, true);
                
                return [
                    'status' => true,
                    'name' => $name
                ];
            } else {
                return ['status' => false];
            }
    }
    
    
    
    public function actionUploadPolaroid(){
            Yii::$app->response->format = Response::FORMAT_JSON;
        
            $fileName = '';
            $nawDate = date('Y-m-d', time());
            $path = \Yii::getAlias("@webroot/temp/user-media/{$nawDate}");
            
            is_dir($path) ?: mkdir($path, 0775, true);
            
            $folder = \app\models\File::getFiles("@webroot/temp/user-media/");
            unset($folder[$nawDate]);
            
            foreach ($folder as $key => $value) {
                $dir = \Yii::getAlias("@webroot/temp/user-media/{$value}");
                
                \app\models\File::delFolder($dir);
            }
            
            $upload = new \app\models\File();
            $upload->file = \yii\web\UploadedFile::getInstanceByName("image");
            
            if ($upload->upload("{$path}/")) {
                $fileName = $upload->url;
                
                $pathWatermark = '@webroot/images/watermark.png';
                $pathImage = "{$path}/$fileName";
                \app\models\File::addWatermark($pathWatermark, $pathImage, $fileName, true);

                return [
                    'status' => true,
                    'name' => $fileName
                ];
            }else{
                return [
                    'status' => true,
                    'name' => "Error"
                ];
            };
            
           
    }
    
    
    public function actionIpn(){
        $data = Yii::$app->request->post();
        
        $emailTo = 'gr@chateaued.com';
        if(isset($data['payment_status']) && $data['payment_status'] == 'Completed' ){
            
            
            if($data['business'] == $emailTo && \app\models\Accrual::checkAccrual($data, 'sandbox.')){ //
                $model = \app\models\Accrual::find()->where(['txn_id'=>$data['txn_id']])->exists();

                if($model == false){
                    $model = new \app\models\Accrual();
                    $model->attributes = $data;

                    if($model->save()){
                        $purchased = new \app\models\Purchases();
                        $purchased->user_id = $data['custom'];
                        $purchased->product_id = $data['item_number'];
                        $purchased->quantity = $data['quantity'];
                        
                        $purchased->save();
                        
                    }
                }
                exit();
            }   
        }
    }
    
    
    /*
     * Загрузка изображений Editora
     */
    public function actionImageCkEditor() {
        $uploadedFile = \yii\web\UploadedFile::getInstanceByName('upload');
        $mime = \yii\helpers\FileHelper::getMimeType($uploadedFile->tempName);
        $file = $uploadedFile->name;

        $url = Yii::$app->urlManager->createAbsoluteUrl('/images/ckeditor/' . $file);
        $uploadPath = Yii::getAlias('@webroot/images/ckeditor/') . $file;
        //extensive suitability check before doing anything with the file…
        if ($uploadedFile == null) {
            $message = "No file uploaded.";
        } else if ($uploadedFile->size == 0) {
            $message = "The file is of zero length.";
        } else if ($mime != "image/jpeg" && $mime != "image/png") {
            $message = "The image must be in either JPG or PNG format. Please upload a JPG or PNG instead.";
        } else if ($uploadedFile->tempName == null) {
            $message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
        } else {
            $message = "";
            $move = $uploadedFile->saveAs($uploadPath);
            if (!$move) {
                $message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
            }
        }
        $funcNum = $_GET['CKEditorFuncNum'];
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
    }
    
    public function actionSendToEmailProfile($id){
        $email = Yii::$app->request->post('email');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if($email == ''){
            return [
                    'status'=> true,
                    'message'=> 'Register on the site to receive a notification',
                ];
        }
        
        $domen = Yii::$app->getRequest()->hostInfo;
        
        $info = \app\models\PDF::getUserInfo($id);
        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
        $message = $this->renderPartial('@app/views/download/pdf-html', [
            'info' => $info,
            'list' => $list,
            'domen' => $domen,
        ]);
        
        // тема письма
        $subject = 'Profile model';

        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Дополнительные заголовки
//        $headers[] = 'To: Mary <mary@example.com>, Kelly <kelly@example.com>';
        $headers[] = 'From: www.divadubai.com';
//        $headers[] = 'Cc: birthdayarchive@example.com';
//        $headers[] = 'Bcc: birthdaycheck@example.com';

        // Отправляем
        if(mail($email, $subject, $message, implode("\r\n", $headers))){
            return [
                'status'=> true,
                'message'=> 'profile sent to your email',
            ];
        }else{
            return [
                'status'=> false,
                'message'=> 'Failed to send',
            ];
        };
        
    }
    
    public function actionAddFavourite($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(Yii::$app->user->isGuest){
            $session = Yii::$app->session;
            
            $favourite = $session->get('favourite');
            
            if($favourite == '' || $favourite === null){
                $favourite = [$id];
            }elseif(is_array($favourite) &&  !in_array($id, $favourite)){
                $favourite[] = $id;
            }
            $session->set('favourite', $favourite);
        }else{
            $user_id = Yii::$app->user->id;
            
            $model = \app\models\Favourite::findOne([
                'user_id' => $user_id,
                'info_user_id' => $id,
            ]);
            
            if($model == null){
                $model = new \app\models\Favourite();
                    
                $model->user_id = $user_id;
                $model->info_user_id = $id;
                $model->save();
            }
        }
        
        return [
            'status'=> true,
            'message'=> 'Model added to favorites',
        ];
    }
    
    
    public function actionAddFavoriteCasting($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(!Yii::$app->user->isGuest){
            $user_id = Yii::$app->user->id;
            
            $model = \app\models\FavoriteCasting::findOne([
                'user_id' => $user_id,
                'casting_id' => $id,
            ]);
            
            if($model == null){
                $model = new \app\models\FavoriteCasting();
                
                $model->user_id = $user_id;
                $model->casting_id = $id;
                $model->save();
                
                return [
                    'status'=> true,
                    'message'=> 'Casting added to favorites',
                ];
            }else{
                return [
                    'status'=> true,
                    'message'=> 'Casting added to favorites',
                ];
            }
        }
        return [
            'status'=> false,
            'message'=> 'You can not add to favorites, first sign up',
        ];
    }
    
    
    public function actionFavoriteCastingDelete($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if(Yii::$app->user->isGuest){
            return [
                'status'=> false,
                'message'=> 'You do not have rights to єto action',
            ];
        }
        $user_id = Yii::$app->user->id;
        
        $model = \app\models\FavoriteCasting::findOne([
            'user_id' => $user_id,
            'casting_id' => $id,
        ]);
        
        if($model !== null){
            return [
                'status'=> $model->delete(),
                'message'=> 'Casting removed from the favorite',
            ];
        }else{
            return [
                'status'=> false,
                'message'=> 'Error',
            ];
        }
        
    }    
    
    public function actionBookingprocess($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $exists = \app\models\Booking::find()
                    ->from('booking b')
                    ->leftJoin(
                            'user_info ui', 
                            'ui.user_id = :user_id AND b.model_id = ui.id', 
                            [':user_id'=>Yii::$app->user->id])
                    ->where(['b.id'=>$id])
                    ->exists();
            
        if($exists) {
            $form = Yii::$app->request->post('form');
            $post = [];
            parse_str($form, $post);

            $model = \app\models\Booking::findOne($id);
            $model->scenario = 'site';

            if ($model->load($post) && $model->validate()) {

                if (!empty($_FILES['canvasImage']['name'])) {
                    $upload = new \app\models\File();
                    $upload->file = \yii\web\UploadedFile::getInstanceByName("canvasImage");

                    $path = \Yii::getAlias("@webroot/images/bookingprocess/");
                    if ($upload->upload($path)) {
                        $model->signature = $upload->url;
                        $model->status = '2';
                    }
                }
                $model->save(false);

                return [
                    'status' => true,
                    'message' => 'Your data has been sent',
                ];
            }
        }
        
        else{
            return [
                'status'=> false,
                'message'=> 'You do not have rights to єto action',
            ];
        }
        
    }    
    
    
    public function actionProfileDelete($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = \app\models\UserInfo::findOne([
            'id'=>$id,
            'user_id'=> Yii::$app->user->id,
        ]);
        
        if($model == null){
            return [
                'status'=> false,
                'message'=> 'You do not have access to this action.',
            ];
        }
        
        return [
            'status'=> $model->delete(),
            'message'=> 'Your profile has been deleted.',
        ];
    }    
    
    public function actionFavouriteDelete($id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if(Yii::$app->user->isGuest){
            $session = Yii::$app->session;
            
            $favourite = $session->get('favourite');
            
            if(is_array($favourite) && in_array($id, $favourite)){
                $key = array_search($id, $favourite);
                unset($favourite[$key]);
                
                if(empty($favourite)){
                    $favourite = '';
                }
            }
            
            $session->set('favourite', $favourite);
            $status = true;
        }else{
            $model = \app\models\Favourite::findOne([
                'id'=>$id,
                'user_id'=> Yii::$app->user->id,
            ]);

            if($model == null){
                return [
                    'status'=> false,
                    'message'=> 'You do not have access to this action.',
                ];
            }
            
            $status = $model->delete() ? true : false;
        }
        
        return [
            'status'=> $status,
            'message'=> 'Your favourite has been deleted.',
        ];
    }    
    
    public function actionFavouriteDeleteAll(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(Yii::$app->user->isGuest){
            $session = Yii::$app->session;
            
            $session->destroy('favourite');
        }else{
            $model = \app\models\Favourite::deleteAll([
                'user_id'=> Yii::$app->user->id,
            ]);
        }
        
        return [
            'status'=> true,
            'message'=> 'Your favourites has been deleted.',
        ];
    }    
    
    /**
     * Відправка листів через yandexMail
     * @param type $email
     * @param type $subject
     * @param type $message
     * @param type $adminEmail
     * @return type
     */
    public static function sentMailYandex($email, $subject, $message, $adminEmail = null) {
        $adminEmail = $adminEmail ? : Yii::$app->params['adminEmail'];

        $mailSMTP = new \app\components\SendMailSmtpClass('sales@partsnb.ru', 'M9mzf7eq', 'ssl://smtp.yandex.ru', 'Partsnb', $smtp_port = 465, $smtp_charset = "utf-8");
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "From: $adminEmail\r\nReply-To: $adminEmail\r\n"; // от кого письмо
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
//        $headers .= "To: {$email}"; 
        return $mailSMTP->send($email, $subject, $message, $headers); // отправляем письмо
        // $result =  $mailSMTP->send('Кому письмо', 'Тема письма', 'Текст письма', 'Заголовки письма');
    }
    
    

//public static function arrayEqual($a1, $a2)
//{
//    vd(array_diff($a1, $a2));
//    if (count(array_diff($a1, $a2)))
//        return false;
//
//    foreach ($a1 as $k => $v)
//    {
//        if (is_array($v) && !self::arrayEqual($a1[$k], $a2[$k]))
//            return false;
//    }
//
//    return true;
//}
    
    public function actionTest(){
        $temp = \app\models\SendEmailMessage::Book('1506929317.7004');
        vd($temp);







        $hostName = Yii::$app->request->hostName;
        $theme = \app\models\EmailTheme::getTheme('registration', 96);
        
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Дополнительные заголовки
        $headers[] = "From: $hostName";

        // Отправляем
       return mail($theme['email'], $theme['subject'], $theme['message'], implode("\r\n", $headers));
        
        
        
//        $type = 'CATEGORY J';
//        
//        $modelSubcategory = \app\models\ModelSubcategory::findOne(['name' => $type]);
////        $modelCategory = \app\models\ModelCategory::findOne(['name' => $type]);
//        
//        $list = \app\models\FilterForm::itemSubcategory($type);
//        
//        foreach ($list as $key => $value) {
//            $model = new \app\models\ModelSubcategory();
//            $model->parent_id = $modelSubcategory->id;
//            $model->category_id = $modelSubcategory->category_id;
//            $model->name = $value;
//            $model->slug = $key;
//            $model->save();
//        }
////        
//        vd($list);
    }

}
