 <?php 
 
use kartik\helpers\Html;
 
echo Html::img(
        $this->render('@app/views/blocks/thumbnail-url', 
        ['url' => Yii::getAlias("@webroot/{$value}"), 'height' => $height, 'width' => $width]
    ),['data-src'=>$value]) 
                
 
//echo kartik\helpers\Html::img(
//        $this->render(
//            '@app/views/blocks/thumbnail-url-resize-height', 
//            ['url' => Yii::getAlias("@webroot/{$item}"), 'height' => 360]
//        ),['height'=>"323"]);
?>