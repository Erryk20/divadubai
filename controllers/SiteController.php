<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;
use app\models\FilterForm;

class SiteController extends Controller
{
    public $top_text;
    public $model;
    public $filter;
    public $seo = [
        'title'=>'',
        'keywords'=>'',
        'description'=>'',
    ];
    
    public function behaviors(){
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['my-castings', 'dashboard'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function beforeAction($action) {
        
        $this->enableCsrfValidation = !in_array($action->id, ['register']);
        
        if ($action->id == 'error') {
            $this->layout = 'error';
        }

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@app/views/site/error.php'
            ],
            'model-management' => [
                'class' => \app\actions\Models::className(),
                'action' => Yii::$app->request->get('action'),
                'title'=>'Diva Model Management',
                'menu' => 'model-management',
                'urlCat' => '/site/model-management'
            ],
            'production' => [
                'class' => \app\actions\Models::className(),
                'action' => Yii::$app->request->get('action'),
                'title'=>'Production',
                'menu' => 'production',
                'urlCat' => '/site/production'
            ],
            'promotions-activations' => [
                'class' => \app\actions\Models::className(),
                'action' => Yii::$app->request->get('action'),
                'title'=>'Promotions Activations',
                'menu' => 'promotions-activations',
                'urlCat' => '/site/promotions-activations'
            ],
            'event' => [
                'class' => \app\actions\Models::className(),
                'action' => Yii::$app->request->get('action'),
                'title'=>'Events',
                'menu' => 'event',
                'urlCat' => '/site/event'
            ],
            'digital-marketing' => [
                'class' => \app\actions\Models::className(),
                'action' => Yii::$app->request->get('action'),
                'title'=>'Influencers',
                'menu' => 'digital-marketing',
                'urlCat' => '/site/digital-marketing'
            ],
            'our-work' => [
                'class' => \app\actions\Models::className(),
                'action' => Yii::$app->request->get('action'),
                'title'=>'Our Work',
                'menu' => 'our-work',
                'urlCat' => '/site/our-work'
            ],
            'production-profile' => [
                'class' => \app\actions\Profile::className(),
                'action' => Yii::$app->request->get('action'),
                'id' => Yii::$app->request->get('id'),
                'title'=>'Production',
                'menu' => 'Production',
                'urlCat' => '/site/production'
            ],
            'promotions-activations-profile' => [
                'class' => \app\actions\Profile::className(),
                'action' => Yii::$app->request->get('action'),
                'id' => Yii::$app->request->get('id'),
                'title'=>'Promotions activations',
                'menu' => 'promotions-activations',
                'urlCat' => '/site/promotions-activations',
            ],
            'event-profile' => [
                'class' => \app\actions\Profile::className(),
                'action' => Yii::$app->request->get('action'),
                'id' => Yii::$app->request->get('id'),
                'title'=>'Events',
                'menu' => 'event',
                'urlCat' => '/site/event'
            ],
            'digital-marketing-profile' => [
                'class' => \app\actions\Profile::className(),
                'action' => Yii::$app->request->get('action'),
                'id' => Yii::$app->request->get('id'),
                'title'=>'Influencers',
                'menu' => 'digital-marketing',
                'urlCat' => '/site/digital-marketing'
            ],
            'our-work-profile' => [
                'class' => \app\actions\Profile::className(),
                'action' => Yii::$app->request->get('action'),
                'id' => Yii::$app->request->get('id'),
                'title'=>'Our Work',
                'menu' => 'our-work',
                'urlCat' => '/site/our-work'
            ],
            'model-management-profile' => [
                'class' => \app\actions\Profile::className(),
                'action' => Yii::$app->request->get('action'),
                'id' => Yii::$app->request->get('id'),
                'title'=>'Diva Model Management',
                'menu' => 'model-management',
                'urlCat' => '/site/model-management'
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $content = \app\models\Content::findOne(['target_id'=>5, 'type'=>'page']);
        $this->seo = \app\models\Seo::getInfoSeo(5, 'index');
        
        $this->layout = 'index';

        return $this->render('index', [
            'description' => $content['description'],
            'iframe' => $content['block_1']
        ]);
    }
    
    
    public function actionBookingprocess($id, $type)
    {
        $request = Yii::$app->request;
        $this->layout = 'casting';
        $this->seo['title'] = 'Diva Dubai Models Production Events Promotion Agency in UAE | Modeling Agencies';

        $model = \app\models\Booking::findOne($id);
        
        if($model && !$model->signature && $type === 'decline'){
            $model->status = 0;
            $model->save(false);
            Yii::$app->session->setFlash('success','Your invitation has been deleted!', false);
            return $this->redirect('/');
        }
        
        
        if($model->signature){
            return $this->redirect('/');
        }
        
        
        $model->scenario = 'site';
        
        date_default_timezone_set('Asia/Dubai');
        $model->last_date = date('d/m/Y');
        
        return $this->render('bookingprocess', ['model' => $model, 'disabled'=>true]);
    }
    
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionOffice()
    {
        $this->layout = 'office';
        $this->top_text = 'Office Images';
        $this->seo = \app\models\Seo::getInfoSeo(12, 'office');

        
        $list = \app\models\ContentImages::getListFromContentId(9);
        
        return $this->render('office', [
            'list'=> $list
        ]);
    }
    
    public function actionServices()
    {
        $this->layout = 'services';
        $this->seo = \app\models\Seo::getInfoSeo(11, 'services');

        
        $list = \app\models\ServicePage::getListAll();
        return $this->render('services', [
            'list'=> $list
        ]);
    }
    
    
    public function actionService($service, $url = false)
    {
        $this->layout = 'service-cat';

        $info_top = \app\models\ServiceCategories::getIfoTop($service, $url);
        
        $menu = \app\models\ServiceCategories::getMenu($service, $url);
        
        
        $this->filter = new \app\models\FilterForm();
        
        $this->filter->load(Yii::$app->request->get());
        
        $list = \app\models\ServiceUsers::getList($service, $url, $this->filter);
        
        return $this->render('service-cat', [
            'info_top'=> $info_top,
            'url'=> $url,
            'menu'=> $menu,
            'list'=> $list,
        ]);
    }
    
    
//    public function actionModelManagement($gender = false){
//        $this->layout = 'service-cat';
//        
//        $this->seo = \app\models\Seo::getInfoSeoFromCategory($gender);
//        
//        $menu = \app\models\ModelManagement::getMenuFromManagement('model-management', $gender);
//        
//        $this->filter = new \app\models\FilterForm();
//        $this->filter->setForm($gender);
//        $this->filter->load(Yii::$app->request->get());
//
//        
//        $request = \Yii::$app->request;
//        $page = (int) $request->get('page');
//        
//        $limit = Yii::$app->params['countTalents'];
//        if($request->isAjax){
//            $ofsset = ($page == null) ? 0 : $page*$limit;
//        }else{
//            $ofsset = 0;
//            $limit = ($page == 0) ? $limit : $page*$limit;
//        }
//        
//        $items = \app\models\MenuCategory::getListIDFromMenu('model-management');
//
//        $list = \app\models\UserInfo::getListUniversal($gender, $this->filter, $items, $limit, $ofsset);
//        
//        if($request->isAjax){
//            return $this->renderPartial('@app/views/blocks/infinite-scroll-management-bocks', [
//        'url'=> \yii\helpers\Url::to(['']+['page'=>$page++]+Yii::$app->request->get(), true),
//                'list' => $list, 
//            ]);
//        }
//        
//        return $this->render('model-management', [
//            'url'=> \yii\helpers\Url::to(['']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
//            'menu'=> $menu,
//            'list'=> $list,
//        ]);
//    }
    
    public function actionModelManagementProfile($action, $id){
        $this->layout = 'profile';
        
        $model = \app\models\ModelManagement::getUserInfoFromManagement($id);
        
        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
        $items = \app\models\MenuCategory::getListIDFromMenu('model-management');
        
        $nextPrev = \app\models\UserCategory::getNextLastUserGender($id, 'model-management', $action, $items);
        
        return $this->render('model-management-profile', [
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'pre_url' => '/site/service-profile',
        ]);
    }
    
    
    
    
//    public function actionPromotionsActivations($url = '')
//    {
//        $this->layout = 'service-cat';
//        
//        $menu = \app\models\ModelCategory::getListCategoryFromParent('promoters', $url);
//
//        
//        $this->filter = new \app\models\FilterForm();
//        $this->filter->load(Yii::$app->request->get());
//        $this->filter->setForm("promoters");
//        
//        $request = \Yii::$app->request;
//        $page = (int) $request->get('page');
//        
//        $limit = Yii::$app->params['countTalents'];
//        if($request->isAjax){
//            $ofsset = ($page == null) ? 0 : $page*$limit;
//        }else{
//            $ofsset = 0;
//            $limit = ($page == 0) ? $limit : $page*$limit;
//        }
//        
//        $listId = \app\models\MenuCategory::getListIDFromMenu('promotions-activations');
//        $this->seo = \app\models\Seo::getInfoSeoFromCategoryistID($listId, $url);
//        
//        $list = \app\models\PromotionsActivations::getList($url, $this->filter, $listId, $limit, $ofsset);
//        
//        if($request->isAjax){
//            return $this->renderPartial('@app/views/blocks/infinite-scroll-promotions-bocks', [
//                'url'=> \yii\helpers\Url::to(['']+['page'=>$page++]+Yii::$app->request->get(), true),
//                'list' => $list, 
//                'page' => $page++, 
//                'url_profile'=> '/site/promotions-activations-profile',
//            ]);
//        }
//        
//        
//        return $this->render('list-profile', [
//            'url'=> \yii\helpers\Url::to(['']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
//            'title' => 'Promotions Activations',
//            'pre_url'=> '/site/promotions-activations',
//            'url_profile'=> '/site/promotions-activations-profile',
//            'menu'=> $menu,
//            'list'=> $list,
//            'page' => 1
//        ]);
//    }
    
    
    public function actionPromotionsActivationsProfile($action, $id){
        $this->layout = 'profile';
        
//        $model = \app\models\PromotionsActivations::getUserInfo($id);
        $model = \app\models\UserInfo::getModelInfo('promotions-activations', $action, $id);

        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
        $nextPrev = \app\models\UserCategory::getNextLastUserCategory($id, 'promotions-activations', $action);
        
        $breadCrumbs = \app\models\ModelCategory::breadCrumbs('promotions-activations', $action);
        return $this->render('block-profile', [
            'title' => 'Promotions Activations',
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'breadCrumbs' => $breadCrumbs,
            'pre_url' => '/site/promotions-activations-profile',
        ]);
    }
    
    
    
//    public function actionDigitalMarketing($url = false)
//    {
//        $this->layout = 'service-cat';
//        
//        $this->filter = new \app\models\FilterForm();
//        $this->filter->load(Yii::$app->request->get());
//        
//        $url = $url ? $url : 'digital-marketing';
//        $this->filter->setForm($url);
//        
//        $request = \Yii::$app->request;
//        $page = (int) $request->get('page');
//        
//        $limit = Yii::$app->params['countTalents'];
//        if($request->isAjax){
//            $ofsset = ($page == null) ? 0 : $page*$limit;
//        }else{
//            $ofsset = 0;
//            $limit = ($page == 0) ? $limit : $page*$limit;
//        }
//        
//        $list = \app\models\DigitalMarketing::getList($url, $this->filter, $limit, $ofsset);
//        
//        if ($request->isAjax) {
//            return $this->renderPartial('@app/views/blocks/infinite-scroll-promotions-bocks', [
//                        'url' => \yii\helpers\Url::to([''] + ['page' => $page++] + Yii::$app->request->get(), true),
//                        'list' => $list,
//                        'page' => $page++,
//                        'url_profile' => '/site/digital-marketing-profile',
//            ]);
//        }
//        $menu = \app\models\ModelCategory::getListCategoryFromParent('digital-marketing', $url);
//        
//        return $this->render('list-profile', [
//            'url'=> \yii\helpers\Url::to(['/site/digital-marketing']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
//            'title' => 'Influencers',
////            'url_profile'=> '/site/digital-marketing',
//            'url_profile'=> '/site/digital-marketing-profile',
//            'pre_url'=> '/site/digital-marketing',
//            'menu'=> $menu,
//            'list'=> $list,
//        ]);
//    }
    
    
    public function actionDigitalMarketingProfile($action, $id){
        $this->layout = 'profile';
        
        $model = \app\models\UserInfo::getModelInfo('digital-marketing', $action, $id);

        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
        $nextPrev = \app\models\UserCategory::getNextLastUserCategory($id, 'digital-marketing', $action);
        
        $breadCrumbs = \app\models\ModelCategory::breadCrumbs('digital-marketing', $action);

        return $this->render('block-profile', [
            'title' => 'Digital Marketing',
            'model' => $model,
            'list' => $list,
            'breadCrumbs' => $breadCrumbs,
            'nextPrev' => $nextPrev,
            'pre_url' => '/site/digital-marketing-profile',
        ]);
    }
    
    
//    public function actionOurWork($url = false)
//    {
//        $this->layout = 'service-cat';
//        $this->seo = \app\models\Seo::getInfoSeo(41, 'our-work');
//        
//        
//        $this->filter = new \app\models\FilterForm();
//        $this->filter->load(Yii::$app->request->get());
//        
//        $url = $url ? $url : 'our-works';
//        $this->filter->setForm($url);
//        
//        $request = \Yii::$app->request;
//        $page = (int) $request->get('page');
//        
//        $limit = Yii::$app->params['countTalents'];
//        if($request->isAjax){
//            $ofsset = ($page == null) ? 0 : $page*$limit;
//        }else{
//            $ofsset = 0;
//            $limit = ($page == 0) ? $limit : $page*$limit;
//        }
//        
//        $menu = \app\models\ModelCategory::getListCategoryFromParent('our-work', $url);
//        
//        $list = \app\models\OurWork::getList($url, $this->filter, $limit, $ofsset);
//        
//        
////        $list = \app\models\PromotionsActivations::getList($url, $this->filter, $limit, $ofsset);
//        
//        if($request->isAjax){
//            return $this->renderPartial('@app/views/blocks/infinite-scroll-promotions-bocks', [
//                'url'=> \yii\helpers\Url::to(['']+['page'=>$page++]+Yii::$app->request->get(), true),
//                'list' => $list, 
//                'page' => $page++, 
//                'url_profile'=> '/site/our-work-profile',
//                'suf'=> 'PA',
//            ]);
//        }
//        
//        
//        
//        return $this->render('list-profile', [
//            'url'=> \yii\helpers\Url::to(['']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
//            'title' => 'Our Work',
//            'pre_url'=> '/site/our-work',
//            'url_profile'=> '/site/our-work-profile',
//            'menu'=> $menu,
//            'list'=> $list,
//            'page' => 1
//        ]);
//    }
    
    
    public function actionOurWorkProfile($action, $id){
        $this->layout = 'profile';
        
        $model = \app\models\UserInfo::getModelInfo('our-work', $action, $id);
        
        
//        $list = \app\models\UserMedia::getListMediaFromUser($id);
//        $nextPrev = \app\models\UserCategory::getNextLastUserCategory($id, 'digital-marketing', $url);

        
        
//        $model = \app\models\OurWork::getUserInfo($id);
        
        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
        $nextPrev = \app\models\OurWork::getNextLastUser($id, $action);
        
        $breadCrumbs = \app\models\ModelCategory::breadCrumbs('our-work', $action);

        
        return $this->render('block-profile', [
            'title' => 'Our Work',
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'breadCrumbs' => $breadCrumbs,
            'pre_url' => '/site/our-work-profile',
        ]);
    }
    
    public function actionProfile($id){
        $this->layout = 'profile';
        
        $model = \app\models\SearchForm::getUserInfo($id);
        
        if($model === false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        $list = \app\models\UserMedia::getListMediaFromUser($id);
        
//        vd($list);



        $category = \app\models\UserInfo::getListCategoryFromSite();
        
        $category_id = \Yii::$app->request->get('category', key($category));
        $fields = \app\models\RegisterFields::getFields($category_id);
        
        $breadCrumbs = [
            'pre_url' => null,
            'parentName' => null,
            'parentSlug' => null,
            'name' => null,
            'slug' => null,
        ];
        
        $nextPrev = \app\models\UserInfo::getNextLastProfile($id);
        
        return $this->render('block-profile', [
            'title' => 'Profile',
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'category' => $category,
            'fields' => $fields,
            'breadCrumbs' => $breadCrumbs,
            'pre_url' => '/site/profile',
        ]);
    }
    
    
    
    public function actionServiceProfile($service, $category, $info_user_id){
        $this->layout = 'profile';
        
        $info_top = \app\models\ServiceCategories::getIfoTop($service, $category);
        
        $model = \app\models\UserInfo::getUserInfoFromService($info_user_id);
        
        $list = \app\models\UserMedia::getListMediaFromUser($info_user_id);
        
        $nextPrev = \app\models\ServiceUsers::getServiceNextLastUser($service, $category, $info_user_id);
        
        return $this->render('profile-service', [
            'info_top'=> $info_top,
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'pre_url' => '/site/service-profile',
        ]);
    }
    
    
    public function actionCasting()
    {
        $this->layout = 'casting';
        
        $request = \Yii::$app->request;
        
        $page = (int) $request->get('page', 1);
        $limit = $request->get('limit', 50);
        $offset = ($page == 1) ? 0 : ($limit * ($page-1));
        
        $count = \app\models\Casting::find()->count();
        
        $pages = new \yii\data\Pagination([
            'totalCount' => (int) $count, 
            'pageSize' => $limit,
        ]);
        $pages->pageSizeParam = false;
        
        $models = \app\models\Casting::find()
                ->orderBy('casting_date DESC')
                ->asArray()
                ->limit($limit)
                ->offset($offset)
                ->all();

        $model = new \app\models\CastingUser();
        
        if(!\Yii::$app->user->isGuest){
            $user = \app\models\User::getUser(\Yii::$app->user->id);
       
            $model->email = $user['email'];

            $model->phone = $user['prepend_phone'].$user['phone'];
            
            $model->name = $user['name'];
        }
        
        if ($model->load($request->post())&& $model->validate()) {
            
            $casting = [];
            foreach ($models as $item){
                if($item['id'] == $model['casting_id']){
                    $casting = $item;
                    break;
                }
            }
            $model->save();

            \app\models\Email::setMailCasting($casting, $model);
            
            \Yii::$app->session->setFlash('success', "Your order has been submitted.!");
            return $this->refresh();
        }
        
        return $this->render('casting', [
            'list' => $models,
            'pages' => $pages,
            'model'=> $model,
            'count'=> ($count - 1),
        ]);
    }
    
    public function actionMyCastings(){
        $this->layout = 'my-casting';

        if(Yii::$app->user->isGuest){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $user = Yii::$app->user->identity;
       
        $castings = \app\models\CastingUser::getCastingsFromUserId($user);
  
        return $this->render('my-casting', [
            'castings'=> $castings,
            'delete'=> false,
            'title'=> 'My Castings',
        ]);
    }
    
    
    public function actionMyBook(){
        $this->layout = 'my-casting';

        if(Yii::$app->user->isGuest){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $user = Yii::$app->user->identity;
       
        $castings = \app\models\CastingUser::getCastingsFromUserId($user);
  
        return $this->render('my-casting', [
            'castings'=> $castings,
            'delete'=> false,
            'title'=> 'My Castings',
        ]);
    }
    
    public function actionFavoriteCastings(){
        $this->layout = 'my-casting';

        if(Yii::$app->user->isGuest){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        $user_id = Yii::$app->user->identity->id;
        
        $castings = \app\models\FavoriteCasting::getCastingsFromUserId($user_id);
        
        return $this->render('my-casting', [
            'castings'=> $castings,
            'delete'=> true,
            'title'=> 'Favorite Castings',
        ]);
    }
    
    
    public function actionBlog($id)
    {
        $this->layout = 'blog';
        
        $model = \app\models\Blogs::findOne($id);        
        if($model == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }else{
            $model->popular += 1;
            $model->update(false);
        }
        
        $popular = \app\models\Blogs::getListBlogsFromPopular();
        $recent = \app\models\Blogs::getListBlogsFromRecent();

        
        return $this->render('blog', [
            'model' => $model,
            'popular' => $popular,
            'recent' => $recent,
        ]);
    }
    
    public function actionBlogs()
    {
        $this->layout = 'blogs';
        $request = \Yii::$app->request;
        $this->seo = \app\models\Seo::getInfoSeo(13, 'blogs');

        
        $page = (int) $request->get('page', 1);
        $limit = $request->get('limit', 4);
        $offset = ($page == 1) ? 0 : ($limit * ($page-1));
        
        $count = \app\models\Blogs::getCountBlogs();
        
        $pages = new \yii\data\Pagination([
            'totalCount' => (int) $count, 
            'pageSize' => $limit,
        ]);
        $pages->pageSizeParam = false;
        
        $models = \app\models\Blogs::getListBlogs($limit, $offset);
        $popular = \app\models\Blogs::getListBlogsFromPopular();
        $recent = \app\models\Blogs::getListBlogsFromRecent();

        
        return $this->render('blogs', [
            'models' => $models,
            'pages' => $pages,
            'popular' => $popular,
            'recent' => $recent,
        ]);
    }
    
    
    public function actionBook($action){
        $this->layout = 'action';

        $request = Yii::$app->request;
        
        $this->seo = \app\models\Seo::getInfoSeo('book', $action);
        
        $content = \app\models\Book::findOne(['url'=>$action]);
        
        if($content == null)
            throw new NotFoundHttpException('The requested page does not exist.');
        
        $this->top_text = $content->text;
        
        $fields = \app\models\BookFields::getBooksFieldAction($action);
        
        $bookFields = new \app\models\BookFields(['scenario'=>'site']);
        
        $email = '';
        $user_name = '';
        if(!\Yii::$app->user->isGuest){
            $user = \Yii::$app->user->identity;
            $email = $user->email;
            $user_name = \app\models\UserInfo::getName($user->id);
        }
        
        if($bookFields->load($request->post()) && $bookFields->validate()){
            $id_field = microtime(true);
            
            foreach (Yii::$app->request->post() as $key => $value) {
                if(is_integer($key)){
                    $model = new \app\models\BookFieldsUser();
                    $model->id_field = $id_field;
                    $model->book_fields_id = $key;
                    $model->value = $value;
                    $model->save();
                }
            }

            if(\app\models\SendEmailMessage::Book($id_field)){
                \Yii::$app->session->setFlash('success', "Your Booking successfully sent!");

                return $this->refresh();
            };
            
        }
        
        return $this->render('book', [
            'email' => $email,
            'user_name' => $user_name,
            'bookFields' => $bookFields,
            'fields' => $fields,
            'content' => $content,
        ]);
    }
    
    
    public function actionParent($parent)
    {
        $this->layout = 'category';
        
        $model = \app\models\Categories::getCategoryFromUrl($parent, 'category');
        if($model === false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $chilldren = \app\models\Categories::getChildrenCategoryFromId($model['id']);
        
        $this->top_text = $model['top'];

        return $this->render('category', [
            'model' => $model,
            'chilldren' => $chilldren,
        ]);
    }
    
    public function actionChildren($children, $type='')
    {
        $this->layout = 'action';
        $parent = Yii::$app->request->get('parent');
        
        $model = \app\models\Categories::getCategoryFromUrl($children, 'category');
        
        if($model === false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->top_text = $model['top'];
        
        $models = \app\models\User::getAllModels($children, $type, 20, 0);
        
        return $this->render('chilldren', [
            'model' => $model,
            'models' => $models,
            'parent' => $parent,
            'children' => $children,
            'type' => $type,
        ]);
    }
    
    public function actionEditeProfile($info_user_id){
        ini_set("memory_limit","2000M");
        ignore_user_abort(true);
        set_time_limit(0);
        
        
        $post = \Yii::$app->request->post('UserMedia');
        
        if(isset($post['src'])){
            if(isset($post['src']['polaroid'])){
                foreach ($post['src']['polaroid'] as $key => $value) {
                    if($value != ''){
                        if(is_array($value) && !empty($value)){
                            $userMedia = \app\models\UserMedia::findOne($key);
                            $item = array_shift($value);
                            if($userMedia->src != $item){
                                $userMedia->src = $item;

                                if($userMedia->save()){
                                    $nawDate = date('Y-m-d', time());
                                    $path = \Yii::getAlias("@webroot/temp/user-media/{$nawDate}/{$userMedia->src}");
                                    $result = Yii::getAlias("@webroot/images/user-media/{$userMedia->src}");
                                    copy($path, $result);
                                }
                            }
                        }else{
                            $userMedia = new \app\models\UserMedia();
                            $userMedia->src = $value;
                            $userMedia->type = 'polaroid';
                            $userMedia->info_user_id = $info_user_id;

                            if ($userMedia->save()) {
                                $nawDate = date('Y-m-d', time());
                                $path = \Yii::getAlias("@webroot/temp/user-media/{$nawDate}/{$userMedia->src}");
                                $result = Yii::getAlias("@webroot/images/user-media/{$userMedia->src}");
                                copy($path, $result);
                            }
                        }
                    }
                }
            }
            
            if(isset($post['src']['image'])){
                foreach ($post['src']['image'] as $key => $value) {
                    if($value != ''){
                        if(is_array($value) && !empty($value)){
                            $userMedia = \app\models\UserMedia::findOne($key);

                            if($userMedia->src != $value[0]){
                                $userMedia->src = $value[0];
                                $userMedia->save();
                            }
                        }else{
                            $userMedia = new \app\models\UserMedia();
                            $userMedia->src = $value;
                            $userMedia->type = 'image';
                            $userMedia->info_user_id = $info_user_id;
                            $userMedia->save();
                        }
                    }
                }
            }
        }
        
        if(isset($_POST['UserMedia'])){
            
            foreach ($post['src'] as $key => $value) {
                if(in_array($key, ['catwalk', 'showreel'])){
                    
                    foreach ($value as $k => $item) {
                        $userMedia = \app\models\UserMedia::findOne([$k]);
                        if($item != ''){
                            if(is_array($item)){
                                if($item[0] == ''){
                                    $userMedia->delete();
                                }else{
                                    $id = preg_replace("/^(.*)\.\w{3}/", "$1", $userMedia->src);

                                    if(stripos($item[0], $id) == false){
                                        $userMedia->scenario = 'video';
                                        $userMedia->link = $item[0];
                                        $userMedia->update();
                                    }
                                }
                            }else{
                                $userMedia = new \app\models\UserMedia();
                                $userMedia->scenario = 'video';
                                $userMedia->info_user_id = $info_user_id;
                                $userMedia->type = $key;
                                $userMedia->link = $item;
                                $userMedia->save();
                            }
                        }
                    }
                }
            }
        }
        
        $this->layout = 'registration'; 
        $request = \Yii::$app->request->post();

        
        $user = new \app\models\User();
        $info = \app\models\UserInfo::findOne($info_user_id);
        
        if($info == null){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        if(!empty(\Yii::$app->request->post())){
            $userSubcategory = \Yii::$app->request->post("UserSubcategory", ['subcategory_id'=>[]]);
            // Subcategory
            $userSubcat = \app\models\UserSubcategory::setSubcategory($userSubcategory, $info->id);
        }else{
            $userSubcat = \app\models\UserSubcategory::getLIstSubcategoyForUser($info->id);
        }
        
        $fields = \app\models\RegisterFields::getFields($info->category_id);
        
        $subcategory = [];
        if(in_array('subcategory', $fields)){
            $subcategory = \app\models\ModelSubcategory::getListSubcategoryFofCategoryID($info->category_id);
        }
        
        
        $info->scenario = 'registration';
        
        $medias = \app\models\UserMedia::getImagesFromUser($info_user_id);
        
        if($info->load(Yii::$app->request->post()) && $info->validate($fields)){
            $info->save(false);
            \Yii::$app->session->setFlash('success', "Your information has been updated!");
            $info = \app\models\UserInfo::findOne($info_user_id);
//            \app\models\PDF::savePdf($info->id);
        }
        
        $userMedia = new \app\models\UserMedia(['scenario' => 'video']);
        

        return $this->render('register', [
            'category_id' => null,
            'user' => $user,
            'info' => $info,
            'userMedia' => $userMedia,
            'fields' => $fields,
            'subcategory' => $subcategory,
            'userSubcat' => $userSubcat,
            'medias' => $medias,
            'title' => "Edit profile",
        ]);
    }

    public function actionRegister(){
        $this->layout = 'registration'; 
        $category = \app\models\UserInfo::getListCategoryFromSiteSlug();

//        $categorySlug = \Yii::$app->request->get('category', key($category));
        $categorySlug = \Yii::$app->request->get('category', 'models');

//        if(in_array($category_id, ['models','casts','promoters','stylists','eventsupport','entertainer','photographers','locations','influencers'])){
            $id = \app\models\ModelCategory::getIdFromCategorySlug($categorySlug);
            if($id != 0){$category_id = $id;}
//        }
      
        $fields = \app\models\RegisterFields::getFields($category_id);
        
        $this->seo = \app\models\Seo::getInfoSeo('register', "register?category={$category_id}");
        
        $subcategory = [];
        if(in_array('subcategory', $fields)){
            $subcategory = \app\models\ModelSubcategory::getListSubcategoryFofCategoryID($category_id);
        }
        
        $user_id = '';
        $info_user_id = null;
        
        $postUser = Yii::$app->request->post('User', false);
        $postUserInfo = Yii::$app->request->post('UserInfo', false);
        $userMedia = new \app\models\UserMedia(['scenario' => 'video']);
        
        if(!Yii::$app->user->isGuest){
           $user = Yii::$app->user->identity;
           $user_id = $user->id;
        }else{
            $user = \app\models\User::findOne(['email' => $postUserInfo['email']]);
            
            if($user == null){
                $user = new \app\models\User(['scenario'=>'registration']);  
            }else{
                $login = new LoginForm(['scenario'=>'login-site']);
                    
                $login->usernameOrEmail = $user->email;
                $login->password = $user->password;
                $login->username = $user->username;

                $login->login();
                
               $user_id = $user->id;
            }
        }
        
        if($user_id == '' && $user->load(Yii::$app->request->post())){
            $user->email = $postUserInfo['email'];
            $user->setPassword($user->password);
            $user->generateAuthKey();
            $user->status = \app\models\User::STATUS_ACTIVE;
            
            if($user->save()){
                $user_id = $user->id;
                
                $login = new LoginForm(['scenario'=>'login-site']);
                    
                $login->usernameOrEmail = $user->email;
                $login->password = $user->password;
                $login->username = $user->username;

                $login->login();
            }
        }
        
        
        
        if(!\Yii::$app->user->isGuest){
            $user_id = \Yii::$app->user->id;
                    
//            $info = \app\models\UserInfo::getInstancesModel($user_id, $fields);
        }
//        else{
//        }
        $info = new \app\models\UserInfo(['scenario'=>'registration']);
        $info->category_id = $category_id;
        $info->categorySlug = $categorySlug;
        $info->prepend_phone = 971;
        $info->prepend_phone2 = 971;

        
        
//        $info->setScenario($fields);
        /*************************************/
//        $info = \app\models\UserInfo::findOne(96);
//        $info->scenario = 'registration';
//        vd($info);
        
        /*************************************/
        
        
        if($user_id != ''){
            $info->user_id = $user_id;
        }
        
//        $info->load(Yii::$app->request->post());
//        vd($info);





        if ($info->load(Yii::$app->request->post()) && $info->validate($fields)) {
            
            $info->user_id = ($user_id != null) ? $user_id : '';

            if($info->save(false)){
                $info_user_id = $info->id;
                
                // Subcategory
                $userSubcategory = \Yii::$app->request->post("UserSubcategory", ['subcategory_id'=>[]]);
                $userSubcat = \app\models\UserSubcategory::setSubcategory($userSubcategory, $info->id);
                
                $postUserMedia = $_POST['UserMedia'];
                
                if(isset($postUserMedia['src']['image']) && !empty($postUserMedia['src']['image'])){
                    foreach ($postUserMedia['src']['image'] as $key => $value) {
                        if ($value != '') {
                            if (is_array($value) && !empty($value)) {
                                $userMedia = \app\models\UserMedia::findOne($key);

                                if ($userMedia->src != $value[0]) {
                                    $userMedia->src = $value[0];
                                    $userMedia->save();
                                }
                            } else {
                                $userMedia = new \app\models\UserMedia();
                                $userMedia->info_user_id = $info->id;
                                $userMedia->type = 'image';
                                $userMedia->src = $value;
                                $userMedia->save();
                            }
                        }
                    }
                }
                
                
                if(isset($postUserMedia['src']['polaroid'])){
                    foreach ($postUserMedia['src']['polaroid'] as $key => $value) {
                        if($value != ''){
                            if(is_array($value) && !empty($value)){
                                $userMedia = \app\models\UserMedia::findOne($key);
                                $item = array_shift($value);
                                if($userMedia->src != $item){
                                    $userMedia->src = $item;

                                    if($userMedia->save()){
                                        $nawDate = date('Y-m-d', time());
                                        $path = \Yii::getAlias("@webroot/temp/user-media/{$nawDate}/{$userMedia->src}");
                                        $result = Yii::getAlias("@webroot/images/user-media/{$userMedia->src}");
                                        copy($path, $result);
                                    }
                                }
                            }else{
                                $userMedia = new \app\models\UserMedia();
                                $userMedia->src = $value;
                                $userMedia->type = 'polaroid';
                                $userMedia->info_user_id = $info_user_id;

                                if ($userMedia->save()) {
                                    $nawDate = date('Y-m-d', time());
                                    $path = \Yii::getAlias("@webroot/temp/user-media/{$nawDate}/{$userMedia->src}");
                                    $result = Yii::getAlias("@webroot/images/user-media/{$userMedia->src}");
                                    copy($path, $result);
                                }
                            }
                        }
                    }
                }
                
                if(isset($postUserMedia['src'])){
                    foreach ($postUserMedia['src'] as $key => $value) {
                        if(in_array($key, ['catwalk', 'showreel'])){

                            foreach ($value as $k => $item) {
                                $userMedia = \app\models\UserMedia::findOne([$k]);


                                if($item != ''){
                                    if(is_array($item)){
                                        if($item[0] == ''){
                                            $userMedia->delete();
                                        }else{
                                            $id = preg_replace("/^(.*)\.\w{3}/", "$1", $userMedia->src);
                                            if(stripos($item[0], $id) == false){
                                                $userMedia->scenario = 'video';
                                                $userMedia->link = $item[0];
                                                $userMedia->update();
                                            }
                                        }
                                    }else{
                                        $userMedia = new \app\models\UserMedia();
                                        $userMedia->scenario = 'video';
                                        $userMedia->info_user_id = $info_user_id;
                                        $userMedia->type = $key;
                                        $userMedia->link = $item;
                                        $userMedia->save();
                                    }
                                }
                            }
                        }
                    }
                }
                
                \Yii::$app->session->setFlash('success', "Are you registered!");
                
                $userFind = \app\models\User::findOne($info->user_id);
                     
                if($userFind != null){
                    \app\models\UserInfo::sentMailForRegister("registration", $info->id);
                }
                
//                \app\models\PDF::savePdf($info->id);
                $this->redirect(['/site/dashboard', 'user_id' => $user->id]);
//                return $this->refresh();
            };
        }

//        $medias = \app\models\UserMedia::getImagesFromUser(113); //$info_user_id
        $medias = \app\models\UserMedia::getImagesFromUser($info_user_id);
        
        return $this->render('register', [
            'category_id' => $category_id,
            'user' => $user,
            'info' => $info,
            'userMedia' => $userMedia,
            'medias' => $medias,
            'category' => $category,
            'subcategory' => $subcategory,
            'fields' => $fields,
            'userSubcat' => [],
            'title' => "Registration",
        ]);
    }
    
    public function actionDashboard(){
        $this->layout = 'dashboard';
        
        $request = \Yii::$app->request;
        $q = $request->get('q', '');
        
        $page = (int) Yii::$app->request->get('page', 1);
        $limit = \Yii::$app->request->get('limit', 10);
        $offset = ($page == 1) ? 0 : ($limit * ($page-1));
        
        $user_id = Yii::$app->user->id;
        $count = \app\models\UserInfo::countItemsUser($q, $user_id);
        
        $pages = new \yii\data\Pagination([
            'totalCount' => (int) $count, 
            'pageSize' => $limit,
        ]);
        $pages->pageSizeParam = false;
        
        $models = \app\models\UserInfo::getListItemsUser($q, $user_id, $limit, $offset);

        return $this->render('dashboard', [
            'models' => $models,
            'user_id' => $user_id,
            'limit' => $limit,
            'pages' => $pages,
            'q' => $q,
        ]);
    }
    
    
    
    public function actionFavourite(){
        $this->layout = 'dashboard';
        
        $page = (int) Yii::$app->request->get('page', 1);
        $limit = \Yii::$app->request->get('limit', 10);
        $offset = ($page == 1) ? 0 : ($limit * ($page-1));
        
        $request = \Yii::$app->request;
        $q = $request->get('q', '');
        
        if(Yii::$app->user->isGuest){
            $session = Yii::$app->session;
            
            $favourites = $session->get('favourite');
            
            $count = count($favourites);
            $models = \app\models\Favourite::getListItems($favourites, $limit, $offset);
        }else{

            $user_id = Yii::$app->user->id;
            $count = \app\models\Favourite::countItemsUser($q, $user_id);
            $models = \app\models\Favourite::getListItemsUser($q, $user_id, $limit, $offset);
        }
        
        $pages = new \yii\data\Pagination([
            'totalCount' => (int) $count, 
            'pageSize' => $limit,
        ]);
        $pages->pageSizeParam = false;
        
        return $this->render('favourite', [
            'models' => $models,
            'limit' => $limit,
            'pages' => $pages,
            'q' => $q,
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $this->layout = 'contact';
        $this->seo = \app\models\Seo::getInfoSeo(8, 'contact');

        $content = \app\models\Contacts::getContent();
        
        if($content === false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->top_text = $content['top'];
        
        $contacts = \app\models\ContactsInfo::find()
                ->where(['published' => '1'])
                ->orderBy('order ASC')
                ->all();
        
        $this->model = new ContactForm();
        
        
        
        if ($this->model->load(Yii::$app->request->post()) && $this->model->contact(Yii::$app->params['supportEmail'])) {
            \Yii::$app->session->setFlash('success', "Your message has been sent!");
            return $this->refresh();
        }
     

        return $this->render('contact', [
            'content' => $content,
            'contacts' => $contacts,
        ]);
    }
    
    
    
    
    public function actionAboutUs()
    {
        $this->layout = 'action';
        $this->seo = \app\models\Seo::getInfoSeo(9, 'about-us');


        $model = \app\models\Content::findOne(12);
        
        if($model == null || $model->block_1 == ''){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        $youtube = preg_replace("/^.*v=(.*)$/", "$1", $model->block_1);
        
        return $this->render('about-us', [
            'youtube' => $youtube,
            'title' => 'About Us'
        ]);
    }
    
    
    
    
    public function actionAwards(){
        $this->layout = 'awards';
        $this->seo = \app\models\Seo::getInfoSeo(1, 'awards');
        
        $content = \app\models\Content::findOne(['type'=>'awards', 'target_id'=>1]);
        
        $modes = \app\models\Awards::find()
                ->asArray()
                ->orderBy('`order` ASC')
                ->all();
        
        return $this->render('awards', [
            'content' => $content,
            'modes' => $modes,
        ]);
    }
    
    public function actionProductions(){
        $slug = Yii::$app->request->pathInfo;
        
        $this->layout = 'diva';
        $this->seo = \app\models\Seo::getInfoFromType($slug);

        $content = \app\models\Diva::find()
                ->where(['url'=>$slug])
                ->asArray()
                ->one();
        
        $category = \app\models\DivaMedia::find()
                ->select(['*', 'slug AS url'])
                ->where(['diva_id'=>$content['id']])
                ->orderBy('order ASC')
                ->asArray()
                ->all();
        
        return $this->render('productions', [
            'content' => $content,
            'category' => $category,
        ]);
    }
    
    public function actionProduction($action){
        $this->layout = 'diva-items';
        
        $this->filter = new \app\models\FilterForm();
        $this->filter->load(Yii::$app->request->get());
        $this->filter->setForm($action);
        
        $request = \Yii::$app->request;
        $page = (int) $request->get('page');
        
        $limit = Yii::$app->params['countTalents'];
        if($request->isAjax){
            $ofsset = ($page == null) ? 0 : $page*$limit;
        }else{
            $ofsset = 0;
            $limit = ($page == 0) ? $limit : $page*$limit;
        }
        
        $listId = \app\models\MenuCategory::getListIDFromMenu('production');
        $this->seo = \app\models\Seo::getInfoSeoFromCategoryistID($listId, $action);
        
        $list = \app\models\ModelProduction::getList($action, $this->filter, $listId, $limit, $ofsset);
//        $list = \app\models\UserInfo::getListUniversal($action, $this->filter, $listId, $limit, $ofsset);

        
        if($request->isAjax){
            return $this->renderPartial('@app/views/blocks/infinite-scroll-production-bocks', [
                'url'=> \yii\helpers\Url::to(['']+['page'=>$page++]+Yii::$app->request->get(), true),
                'list' => $list, 
                'type' => 'production', 
                'action'=> $action,
            ]);
        }
        $categoryes = \app\models\DivaMedia::getListCategoryDivaMedia(16, '/site/production');
        
        return $this->render('production', [
            'list' => $list,
            'categoryes' => $categoryes,
            'action' => $action,
            'url'=> \yii\helpers\Url::to(['']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
            'type' => 'production',
        ]);
    }
    
    public function actionDiva($category, $action, $info_user_id){
        $this->layout = 'profile';
        
        $model = \app\models\UserInfo::getModelInfo($category, $action, $info_user_id);
        if($model === false){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $nextPrev = \app\models\UserCategory::getNextLastUserCategory($info_user_id, $category, $action);
        
        $list = \app\models\UserMedia::getListMediaFromUser($info_user_id);
        
        $breadCrumbs = \app\models\ModelCategory::breadCrumbs($category, $action);
        
        return $this->render('profile', [
            'model' => $model,
            'list' => $list,
            'nextPrev' => $nextPrev,
            'category' => $category,
            'action' => $action,
            'breadCrumbs' => $breadCrumbs,
            'pre_url' => '/site/production',
        ]);
    }


    public function actionEvents(){
        $this->layout = 'diva';
        $this->seo = \app\models\Seo::getInfoSeo(2, 'event');

        $content = \app\models\Diva::find()
                ->where(['type'=>'events', 'id'=>2])
                ->asArray()
                ->one();
        
        $category = \app\models\DivaMedia::find()
                ->select(['*', 'slug AS url'])
                ->where(['diva_id'=>2])
                ->orderBy('order ASC')
                ->asArray()
                ->all();
        
        return $this->render('events', [
            'content' => $content,
            'category' => $category,
        ]);
    }
    
    public function actionEvent($action){
        $this->layout = 'diva-items';
        
        $this->filter = new \app\models\FilterForm();
        $this->filter->load(Yii::$app->request->get());
        $this->filter->setForm($action);
        
        $request = \Yii::$app->request;
        $page = (int) $request->get('page');
        
        $limit = Yii::$app->params['countTalents'];
        if($request->isAjax){
            $ofsset = ($page == null) ? 0 : $page*$limit;
        }else{
            $ofsset = 0;
            $limit = ($page == 0) ? $limit : $page*$limit;
        }
        
        $listId = \app\models\MenuCategory::getListIDFromMenu('event');
        $this->seo = \app\models\Seo::getInfoSeoFromCategoryistID($listId, $action);
        
        $list = \app\models\ModelEvent::getList($action, $this->filter, $listId, $limit, $ofsset);
        
        if ($request->isAjax) {
            return $this->renderPartial('@app/views/blocks/infinite-scroll-production-bocks', [
                        'url' => \yii\helpers\Url::to([''] + ['page' => $page++] + Yii::$app->request->get(), true),
                        'list' => $list,
                        'page' => $page++,
                        'url_profile' => '/site/promotions-activations-profile',
                        'action' => $action,
                        'type' => 'event',
            ]);
        }

        $categoryes = \app\models\DivaMedia::getListCategoryDivaMedia(7, '/site/event');

        return $this->render('production', [
            'url'=> \yii\helpers\Url::to(['']+['page'=>($page == null) ? 1 : $page]+Yii::$app->request->get(), true),
            'list' => $list,
            'categoryes' => $categoryes,
            'action' => $action,
            'type' => 'event',
        ]);
    }
    
    
    
    
    
    public function actionClients(){
        $this->layout = 'clients';
        $this->seo = \app\models\Seo::getInfoSeo(10, 'clients');
        
        $content = \app\models\Content::findOne(['type'=>'clients', 'target_id'=>1]);
        
//        $page = (int) Yii::$app->request->get('page', 1);
//        $limit = \Yii::$app->request->get('limit', 32);
//        $offset = ($page == 1) ? 0 : ($limit * ($page-1));
//        
//        $count = (int)\app\models\Clients::find()->count();
//        
//        $pages = new \yii\data\Pagination([
//            'totalCount' => (int) $count, 
//            'pageSize' => $limit,
//        ]);
//        $pages->pageSizeParam = false;
        
        $modes = \app\models\Clients::find()
                ->asArray()
//                ->orderBy('`order` ASC')
//                ->offset($offset)
//                ->limit($limit)
                ->all();
                
        return $this->render('clients', [
            'content' => $content,
            'modes' => $modes,
//            'limit' => $limit,
//            'pages' => $pages,
        ]);
    }
    
    public function actionFaq(){
        $this->layout = 'faq';
        $this->seo = \app\models\Seo::getInfoSeo(1, 'faq');
        
        $content = \app\models\Content::findOne(['type'=>'faq', 'target_id'=>1]);
        
        $models = \app\models\Faq::listFAQ();
        
        $ask = new \app\models\FaqAsk();
        
        if(!Yii::$app->user->isGuest){
            $user = Yii::$app->user->identity;
            $ask->email = $user->email;
        }
        
        if ($ask->load(Yii::$app->request->post()) && $ask->save()) {
            \Yii::$app->session->setFlash('success', "Your message has been sent!");
            return $this->refresh();
        }
        
        return $this->render('faq', [
            'content' => $content,
            'models' => $models,
            'ask' => $ask,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(){
        return $this->render('about');
    }
    
    
    public function actionTest(){
        $model = new \app\models\PasswordResetRequestForm();
        
        $model->email = 'erryk20@gmail.com';
        
        if ($model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        
        die('end');
    }
    
    public function actionDisclaimer(){
        $this->layout = 'disclaimer';
        $this->seo = \app\models\Seo::getInfoSeo(1, 'disclaimer');

        $content = \app\models\Pages::getContent('disclaimer');
        
        return $this->render('disclaimer', [
            'content' => $content
        ]);
    }
    
    public function actionTraining(){
        $this->layout = 'training';
        $this->seo = \app\models\Seo::getInfoSeo(3, 'training');
        
        $content = \app\models\Pages::getContent('training');
        if(!$content){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        
        $images = \app\models\ContentImages::getImagesFromContent($content['id']);
        
        return $this->render('training', [
            'content' => $content,
            'images' => $images,
        ]);
    }
    
    
    public function actionPublicRelations($action){
        $this->layout = 'public-relations';
        $this->seo = \app\models\Seo::getInfoSeo(2, $action);
        
        $content = \app\models\Pages::getContent($action);
        
        if(!$content){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $images = \app\models\ContentImages::getImagesFromContent($content['id']);
        

        $htmlImages = "<div class='photos_wrap {$action}'>";
        foreach ($images as $key => $value) {
            $htmlImages .= "<div class='item item_".($key+1)."'><img src='{$value['src']}' alt='{$value['title']}'></div>";
        }
        $htmlImages .= "</div>";
        
        $content['description'] = str_replace('{images}', $htmlImages, $content['description']);
        
        return $this->render('public-relations', [
            'content' => $content,
            'action' => $action,
        ]);
    }
    
    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(){
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(){
        $this->layout = 'access';
        
        if (!Yii::$app->user->isGuest) {return $this->goHome();}

        $model = new LoginForm(['scenario'=>'login-site']);
        
        $remember = Yii::$app->request->post('remember');
        $model->rememberMe = ($remember == 'on') ? true : false;
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    public function actionRequestPasswordReset(){
        $this->layout = 'access';
        
        $model = new \app\models\PasswordResetRequestForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('reset-password', [
            'model' => $model,
        ]);
    }
    
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token){
        $this->layout = 'access';

        try {
            $model = new \app\models\ResetPasswordForm($token);
        } catch (\yii\base\InvalidParamException $e) {
            throw new \yii\web\BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
