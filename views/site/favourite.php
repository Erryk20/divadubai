<?php
use app\models\UserInfo;
use yii\helpers\Url;
use yii\web\View;
use kartik\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use kartik\form\ActiveForm;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$this->title = 'Favourite';
$this->params['breadcrumbs'][] = 'Profile';

$this->registerJs("
        $(document).ready(function() {
            $('#page-size select').change(function(e) {
                var val = $('select option:selected').val();
                var url = window.location.href;

                if(url.indexOf('limit')+1){
                    url = url.replace(/limit=(\d*)/, 'limit='+val)
                }else{
                    url += (url.indexOf('?')+1) ? '&' : '?';
                    url += 'limit='+val;
                }

                window.location.href = url;
            });
	});
    ", View::POS_END);

?>

<style>
    #botton-style{
        margin: 0;
        padding: 5px;
        float: right;
        
        border: 2px solid #3f3f40;
        font-size: 12px;
        font-weight: 700;
        color: #3f3f40;
        background: 0 0;
        -webkit-border-radius: 0;
        border-radius: 0;
        -webkit-transition: .3s;
        -o-transition: .3s;
        transition: .3s;
    }
</style>

<?php // Pjax::begin(); ?>


<div class="view_profile clearfix">
    <div class="view_header">
            <?php // $form = ActiveForm::begin([
//                'action'=> Url::toRoute(['/site/dashboard', 'user_id'=>$user_id]),
//                'method'=>"get",
//                'options'=>[
//                    'calss'=>"form-inline", 
//                ]]); 
            ?>
<!--            <div class="form-group clearfix">
                    <input type="submit" class="form_submit" value="Search">
                    <input type="text" class="form-control form_text" placeholder="Search..." name="q" value="<?= $q ?>">
                
                <div class="select_form" id="page-size">
                    <div class="select_form">
                        
                        <label>Show</label>
                        <?= Html::dropDownList("limit", $limit, [
                            10=>10,
                            20=>20,
                            30=>30,
                        ]) ?>
                    </div>
                </div>
            </div>-->
        <?php // ActiveForm::end(); ?>
    </div>
    <div class="view_content">
        <div class="profile_table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th  class="view_casting">
                             <?php if(count($models) != 0) : ?>
                                <a
                                    style="margin: 0;padding: 5px;font-size: 12px;"
                                    href="/download/favorite" class="btn btn-default">
                                Download</a>
                            <?php endif; ?>
                        </th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Nationality</th>
                        <th style="width: 160px;">
                            <?php if(count($models) != 0) : ?>
                                <a
                                    id ="botton-style"
                                    class="btn btn-default delte-all"
                                    data-toggle="modal" data-target="#profileModal"
                                    data-url="/ajax/favourite-delete-all">
                                Delete all</a>
                            <?php endif; ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($models as $value) : ?>
                    <tr  data-id ="<?= $value['id'] ?>">
                        <td><?= $value['id'] ?></td>
                        <td>
                            <a href="<?= Url::toRoute(['/site/profile', 'id'=>$value['info_user_id']]) ?>">
                                <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/user-media/{$value['logo']}"), 'width' => 67, 'height' => 67]) ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?= Url::toRoute(["/site/profile", 'id'=>$value['info_user_id']]) ?>"><?= $value['name'] ?></a>
                        </td>
                        <td><?= (date('Y', time()) - (int)date('Y',$value['birth'])) ?> (<?= date('Y-m-d',$value['birth']) ?>)</td>
                        <td><?= $value['nationality'] ?></td>
                        <td >
                            <a style="float: right;" class="delete_profile" href="#" data-id="<?= $value['id'] ?>" data-toggle="modal" data-target="#profileModal" data-url="/ajax/favourite-delete?id=<?= $value['id'] ?>">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php // Pjax::end(); ?>

<div class="pagination-div">
    <?= LinkPager::widget(['pagination' => $pages]);?>
</div>

<div class="modals_wrap">
    <div id="profileModal" class="modal fade">
        <div class="modal-dialog modal-sm">
            <div class="modal-header">
                <!-- <div class="close_icon">Close</div> -->
                <button type="button" class="close" data-dismiss="modal">Close</button>
                <div class="form_title">Are you sure?</div>
            </div>
            <div class="modal-content">
                <div class="btn btn-danger btn_delete">Delete</div>
                <div class="btn btn-success btn_cancel" data-dismiss="modal">Cancel</div>
            </div>
        </div>
    </div>
</div>
