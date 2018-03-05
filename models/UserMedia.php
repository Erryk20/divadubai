<?php

namespace app\models;

use Yii;
use app\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_media".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $src
 *
 * @property User $user
 */
class UserMedia extends \yii\db\ActiveRecord
{
    use \app\traits\TypeVideo;
    
    public $file;
    public $files;
    public $link;
    public $youtube_id;
    public $vimeo_id;
    
    public $link_1;
    public $link_2;
    public $link_3;
    public $link_4;
    
    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::className(),
            'sortable' => [
                'class' => \kotchuprik\sortable\behaviors\Sortable::className(),
                'query' => self::find(),
            ],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['files'], 'required', 'on'=>['site-register']],
            
            [['info_user_id', 'type'], 'required', 'on'=>['image']],
            [['link'], 'required', 'on'=>['video']],
            
            [['info_user_id'], 'integer'],
            [['link', 'link_1', 'link_2', 'link_3', 'link_4'], 'url'],
            [['link', 'link_1', 'link_2', 'link_3', 'link_4'], 'isValidUrl'],
            
//            [['link'], 'url', 'when' => function ($model) {
//                    return true;
//                }, 'whenClient' => "function (attribute, value) {
//                    return false; //$('#usermedia-link').val().match('(youtube|vimeo)') != null;
//            }"],
            [['type'], 'string', 'max' => 20],
            [['src'], 'string', 'max' => 255],
            ['file', 'image', 'extensions' => 'jpg, png'],
            [['info_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserInfo::className(), 'targetAttribute' => ['info_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'info_user_id' => 'User ID',
            'type' => 'Type',
            'src' => 'Src',
            'link' => 'Link',
            'files' => 'Image',
        ];
    }
    
    public function isValidUrl($attrebute){
        if($this->$attrebute && !preg_match('/(youtube|vimeo)/', $this->$attrebute)){
            $this->addError('link','You can add only youtube/ vimeo video');
            return false;
        }
        return true;
    }
    
    public function afterFind(){
        
        if(in_array($this->type, array_keys(self::itemAlias('video')))){
            $key = preg_replace('/^(images\/user-media\/)(.*)\.(.*)$/i', '$2', $this->src);
            
            if(preg_match('/^\d*$/', $key)){
                $this->link = "https://vimeo.com/{$key}";
            }else{
                $this->link = "https://www.youtube.com/watch?v={$key}";
            }
        }

        parent::afterFind();
    }
    
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if($this->scenario == 'video'){
                if($this->link && preg_match('/youtube/', $this->link)){
                    $this->setVideoYoutube();
                }else{
                    $this->setVideoVimeo();
                }
            }
            return true;
        }
        return false;
    }
    
    
    public function setVideoYoutube(){
        $data = parse_url($this->link, PHP_URL_QUERY);
        $data = explode('&', $data);
        $this->youtube_id = preg_replace('/v=(.*)/i', '$1', $data[0]);
        
        $this->src = "{$this->youtube_id}";
        
//        $newfile = \Yii::getAlias("@webroot/images/user-media/{$this->src}");
        
//        $folder = \Yii::getAlias("@webroot/images/user-media/");
//        
//        if (!File::savefile($newfile, $this->urlYoutube)) {
//            return false;
//        }
    }
    
    /**
     * Верне зображення для відео з youtube
     * @return type
     */
    public function getUrlYoutube(){
        return "http://img.youtube.com/vi/{$this->youtube_id}/0.jpg";
    }
    
  
    public function setVideoVimeo(){
        $this->vimeo_id = preg_replace('/^(.*\/)(.*)$/i', '$2', $this->link);
        
//        $thumbnail = self::getVimeoThumb($this->vimeo_id);
        
        
//        $ext = preg_replace('/^(.*)\.(.*)$/i', '$2', $thumbnail);
        
//        $this->src = "{$this->vimeo_id}.{$ext}";
        $this->src = "{$this->vimeo_id}";
        
//        $newfile = \Yii::getAlias("@webroot/images/user-media/{$this->src}");
//        
//        if (!File::savefile($newfile, $thumbnail)) {
//            return false;
//        }
    }
    
    /**
     * Верне зображення для відео з vimeo
     * @return type
     */
    public static function getVimeoThumb($id) {
        $data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
        $data = json_decode($data);
        
        return $data[0]->thumbnail_large;
    }
    
    public static function itemAlias($type, $code = NULL) {
        $_items = [
            'type' => [
                'image' => 'Image',
                'polaroid' => 'Polaroid',
                'catwalk' => 'Catwalk',
                'showreel' => 'Showreel',
            ],
            'photo' => [
                'image' => 'Image',
                'polaroid' => 'Polaroid',
            ],
            'video' => [
                'catwalk' => 'Catwalk',
                'showreel' => 'Showreel',
            ],
        ];
        if (isset($code)) {
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        } else
            return isset($_items[$type]) ? $_items[$type] : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserInfo::className(), ['id' => 'info_user_id']);
    }
    
    
    public static function getListMediaFromUser($info_user_id){
        $query = "
            SELECT um.id, um.`type`, IF(um.type IN ('image', 'polaroid'), CONCAT('/images/user-media/', TRIM(um.src)), um.src) AS 'src' 
            FROM user_media um
            WHERE um.info_user_id = :info_user_id
            AND (IF(um.type IN ('catwalk', 'showreel'), um.isset = '1', true))
            ORDER BY IF(um.`type` = 'image', false, true), um.type, um.`order` ASC
        ";
        
        $request = Yii::$app->db->createCommand($query, [
            ':info_user_id' => $info_user_id,
        ])->queryAll();
        
        $result = [];
        foreach ($request as $key => $value) {
            if(in_array($value['type'], array_keys(self::itemAlias('photo')))){
                if($key == 0){
                    $result['logo'] = $value['src'];
                }elseif($key < 9){
                    $result['list'][] = $value['src'];
                }
                $result['all'][] = $value['src'];
                
            }
            $result[$value['type']][] = $value['src'];
        }
        
        $count = count($request);
        
        if($count < 8){
            if($count == 0){
                $result['logo'] = "/images/user-media/diva-logo.png";
                for ($i = 1; $i <= 8; $i++) {
                    $result['list'][] = "/images/user-media/diva-logo.png";
                }
            }else{
                for ($i = 0; $i <= (8 - $count); $i++) {
                    $result['list'][] = "/images/user-media/diva-logo.png";
                }
            }
        }
        
        if(isset($result['catwalk'])){
            foreach ($result['catwalk'] as $key => $value) {
                $result['catwalk'][$key] = self::getTypeVideo($value);
            }
        }
//        
        if(isset($result['showreel'])){
            foreach ($result['showreel'] as $key => $value) {
                $result['showreel'][$key] = self::getTypeVideo($value);
            }
        }
        
        return $result;
    }
    
    public static function getImagesFromUser($info_user_id = false){
        $result = [
            'catwalk'=>[],
            'showreel'=>[],
            'image'=>[],
            'polaroid'=>[],
        ];
        
        if($info_user_id){
            $query = "
                SELECT id, `type`, `src`
                FROM user_media
                WHERE info_user_id = :info_id
                ORDER BY `type`, `order` ASC
            ";
            
            $lists = Yii::$app->db->createCommand($query, [':info_id'=>$info_user_id])->queryAll();
            
            $i = 0;
            $type = null;
            foreach ($lists as $value) {
                if($type == null){
                    $type = $value['type'];
                }elseif($type != $value['type']){
                    $i = 0;
                    $type = $value['type'];
                }
                
                if(in_array($type, ['showreel', 'catwalk'])){
                    $video_id = preg_replace('/^(.*)\.(.*)$/i', '$1', $value['src']);
                    
                    if(preg_match('/^\d*$/', $video_id)){
                        $result[$value['type']][++$i]['src'] = "https://vimeo.com/{$video_id}";
                        $result[$value['type']][$i]['id'] = $value['id'];
                    }else{
                        $result[$value['type']][++$i]['src'] = "https://www.youtube.com/watch?v={$video_id}";
                        $result[$value['type']][$i]['id'] = $value['id'];
                    };
                }else{
                    $result[$value['type']][++$i]['src'] = $value['src'];
                    $result[$value['type']][$i]['id'] = $value['id'];
                }
            }
        }
        return $result;
    }
    
    public function setSrc(){
        if($this->file){
            $src = preg_replace('/images\/user-media\//', "", $this->file);
            $this->src = $src;
        }
    }


//    public function behaviors(){
//        return [
//            'imageUploaderBehavior' => [
//                'class' => 'demi\image\ImageUploaderBehavior',
//                'imageConfig' => [
//                    // Name of image attribute where the image will be stored
//                    'imageAttribute' => 'src',
//                    // Yii-alias to dir where will be stored subdirectories with images
//                    'savePathAlias' => '@webroot/images/user-media',
//                    // Yii-alias to root project dir, relative path to the image will exclude this part of the full path
//                    'rootPathAlias' => '@webroot',
//                    // Name of default image. Image placed to: webrooot/images/{noImageBaseName}
//                    // You must create all noimage files: noimage.jpg, medium_noimage.jpg, small_noimage.jpg, etc.
//                    'noImageBaseName' => 'noimage.jpg',
//                    // List of thumbnails sizes.
//                    // Format: [prefix=>max_width]
//                    // Thumbnails height calculated proportionally automatically
//                    // Prefix '' is special, it determines the max width of the main image
//                    'imageSizes' => [
//                        '' => 1000,
//                        'medium_' => 270,
//                        'small_' => 70,
//                        'my_custom_size' => 25,
//                    ],
//                    // This params will be passed to \yii\validators\ImageValidator
//                    'imageValidatorParams' => [
//                        'minWidth' => 400,
//                        'minHeight' => 300,
//                    ],
//                    // Cropper config
////                    'aspectRatio' => 4 / 3, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
//                    // default config
//                    'imageRequire' => false,
//                    'fileTypes' => 'jpg,jpeg,gif,png',
//                    'maxFileSize' => 10485760, // 10mb
//                    // If backend is located on a subdomain 'admin.', and images are uploaded to a directory
//                    // located in the frontend, you can set this param and then getImageSrc() will be return
//                    // path to image without subdomain part even in backend part
//                    'backendSubdomain' => 'admin.',
//                ],
//            ],
//        ];
//    }
}
