<?php
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use yii\widgets\ActiveForm;
USE yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bookings';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="booking-index">
    <div id="ajaxCrudDatatable">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => ['template' => "{input}\n{error}"],
    ]); ?>
        <?=GridView::widget([
            'id'=>'crud-datatable',
            'dataProvider' => $dataProvider,
            'toolbar'=> [], 
            'columns' => require(__DIR__.'/_columns.php'),
            'panel' => ['type' => 'primary']
        ])?>
        
        
        <?php if (!Yii::$app->request->isAjax){ ?>
          <div class="form-group">
            <?= Html::submitButton('Send Email', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php } ?>
    <?php ActiveForm::end(); ?>
    </div>
</div>