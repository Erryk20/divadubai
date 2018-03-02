<?php
namespace app\components;

use yii\base\DynamicModel;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use Yii;

class UploadCrop extends \yii\base\Action {

    public $path;
    public $url;
    public $uploadParam = 'file';
    public $maxSize = 2097152;
    public $extensions = 'jpeg, jpg, png, gif';
    public $width = 0;
    public $height = 253;

    public function run()
    {
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstanceByName($this->uploadParam);
            $model = new DynamicModel(compact($this->uploadParam));
            $model->addRule($this->uploadParam, 'image', [
                'maxSize' => $this->maxSize,
                'tooBig' => Yii::t('app', 'TOO_BIG_ERROR', ['size' => $this->maxSize / (1024 * 1024)]),
                'extensions' => explode(', ', $this->extensions),
                'wrongExtension' => Yii::t('app', 'EXTENSION_ERROR', ['formats' => $this->extensions])
            ])->validate();

            if ($model->hasErrors()) {
                $result = [
                    'error' => $model->getFirstError($this->uploadParam)
                ];
            } else {
                $model->{$this->uploadParam}->name = uniqid() . '.' . $model->{$this->uploadParam}->extension;
                $request = Yii::$app->request;

                $width = $request->post('width', $this->width);
                $height = $request->post('height', $this->height);

                $image = Image::crop(
                    $file->tempName . $request->post('filename'),
                    intval($request->post('w')),
                    intval($request->post('h')),
                    [$request->post('x'), $request->post('y')]
                );
//                ->resize(
//                    new Box($width, $height)
//                );
                
                
                
                $pathImage = $this->path . $model->{$this->uploadParam}->name;
                
                $path = \Yii::getAlias($this->path . $model->{$this->uploadParam}->name);
                
                if ($image->save($path)) {
                    
                    $result = [
                        'filelink' => $this->url . $model->{$this->uploadParam}->name
                    ];
                } else {
                    $result = [
                        'error' => Yii::t('app', 'ERROR_CAN_NOT_UPLOAD_FILE')]
                    ;
                }
            }
            Yii::$app->response->format = Response::FORMAT_JSON;

            return $result;
        } else {
            throw new BadRequestHttpException(Yii::t('app', 'ONLY_POST_REQUEST'));
        }
    }
}
