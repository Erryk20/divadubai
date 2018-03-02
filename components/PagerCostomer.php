<?php
namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;



class PagerCostomer extends yii\widgets\LinkPager {
    /**
     * Renders a page button.
     * You may override this method to customize the generation of page buttons.
     * @param string $label the text label for the button
     * @param int $page the page number
     * @param string $class the CSS class for the page button.
     * @param bool $disabled whether this page button is disabled
     * @param bool $active whether this page button is active
     * @return string the rendering result
     */
    protected function renderPageButton($label, $page, $class, $disabled, $active)
    {
        $options = $this->linkContainerOptions;
        $linkWrapTag = ArrayHelper::remove($options, 'tag', 'li');
        Html::addCssClass($options, empty($class) ? $this->pageCssClass : $class);

        if ($active) {
            Html::addCssClass($options, $this->activePageCssClass);
        }
        if ($disabled) {
            Html::addCssClass($options, $this->disabledPageCssClass);
            $tag = ArrayHelper::remove($this->disabledListItemSubTagOptions, 'tag', 'span');

            return Html::tag($linkWrapTag, Html::tag($tag, $label, $this->disabledListItemSubTagOptions), $options);
        }
        $linkOptions = $this->linkOptions;
        $linkOptions['data-page'] = $page;
        
        $request = Yii::$app->request;
        
        if($request->isPost){
            $post = $request->post('FilterFormAdmin', false);
            
            if($post){
                $result = [];
                foreach ($post as $key => $value) {
                    if($value != '' && !is_array($value)){
                        $result[$key] = $value;
                    }
                }
                $data = array_diff($result, array('', NULL, false));
            }else{
                $data = array_diff($request->post(), array('', NULL, false));
            }
            
            $linkOptions['data'] = [
                'method' => 'post',
                'params' => $data,
            ];
            
        }
        
        return Html::tag($linkWrapTag, Html::a($label, $this->pagination->createUrl($page), $linkOptions), $options);
    }
}
