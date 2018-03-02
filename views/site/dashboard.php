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

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = 'Profile';

$this->registerJs("
        $(document).ready(function() {
            $('#page-size select').change(function(e) {
                var val = $('.select_form select option:selected').val();
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

<?php // Pjax::begin(); ?>


<div class="view_profile clearfix">
    
    
    <div class="view_header">
    <div class="wrap-button">
        <?= $this->render('@app/views/blocks/profile-menu') ?>
    </div>
            <?php $form = ActiveForm::begin([
                'action'=> Url::toRoute(['/site/dashboard', 'user_id'=>$user_id]),
                'method'=>"get",
                'options'=>[
                    'calss'=>"form-inline", 
                ]]); 
            ?>
            <div class="form-group clearfix">
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
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <div class="view_content">
        <div class="profile_table">
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Nationality</th>
                        <th>Modify</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($models as $value) : ?>
                    <tr data-id ="<?= $value['id'] ?>">
                        <td><?=  $value['type'] ?></td>
                        <td><?= $value['id'] ?></td>
                        <td>
                            <a href="<?= Url::toRoute(['/site/profile', 'id'=>$value['id']]) ?>">
                                <?= $this->render('@app/views/blocks/thumbnail-img', ['url' => Yii::getAlias("@webroot/images/user-media/{$value['logo']}"), 'width' => 67, 'height' => 67]) ?>
                            </a>
                        </td>
                        <td>
                            <a href="<?= Url::toRoute([
                                    '/site/profile', 
                                    'id'=>$value['id']
                                ]) ?>"><?= $value['name'] ?>
                            </a>
                        </td>
                        <td><?= (date('Y', time()) - (int)date('Y',$value['birth'])) ?> (<?= date('Y-m-d',$value['birth']) ?>)</td>
                        <td><a href="tel:<?= $value['phone_html'] ?>"><?= $value['phone'] ?></a></td>
                        <td><a href="<?= $value['email'] ?>"><?= $value['email'] ?></a></td>
                        <td><?= $value['nationality'] ?></td>
                        <td><a href="<?= Url::toRoute(['/site/edite-profile', 'info_user_id'=>$value['id']]) ?>"> Edit Profile</a></td>
                        <td><?= UserInfo::itemAlias('review', ($value['type']) ? 1 : 0 ) ?></td>
                        <td>
                            <?= Html::a('Delete', '#', ['data-id'=> $value['id'],  'data-toggle'=>"modal", 'data-target'=>"#profileModal", 'data-url'=> Url::toRoute(['/ajax/profile-delete', 'id'=>$value['id']]), 'class'=>"delete_profile"]) ?>
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
