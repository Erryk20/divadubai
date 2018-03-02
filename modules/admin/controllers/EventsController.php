<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\DivaMediaSearch;


class EventsController extends \yii\web\Controller
{
    public function actions() {
        return [
             'index' => [
                'class' => \app\actions\categories\SeoCategory::className(),
                'type' => 'event'
            ],
            'create-media' => [
                'class' => \app\actions\categories\CreateMedia::className(),
            ],
            'update-media' => [
                'class' => \app\actions\categories\UpdateMedia::className(),
            ],
            'view-media' => [
                'class' => \app\actions\categories\ViewMedia::className(),
            ],
            'delete-media' => [
                'class' => \app\actions\categories\DeleteMedia::className(),
            ],
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => \app\models\DivaMedia::find(),
            ],
        ];
    }
}
