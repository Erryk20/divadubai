<?php

use adminlte\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?= Html::img('@web/images/user2-160x160.jpg', ['class' => 'img-circle', 'alt' => 'User Image']) ?>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <?=
        Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => [
//                        ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
//                        ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                        [
                            'label' => 'Site', 
                            'icon' => 'fa fa-globe', 
                            'url' => ['/'], 
                            'active' => $this->context->route == 'site/index',
                        ],
                        
                        ['label' => 'Menu', 'options' => ['class' => 'header']],
                        [
                            'label' => 'Content',
                            'icon' => 'fa fa-address-card-o',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Pages', 
                                    'icon' => 'fa fa-clone', 
                                    'url' => ['/admin/pages'], 
                                    'active' => $this->context->route == 'admin/pages/index'
                                ],
                                [
                                    'label' => 'Agencies', 
                                    'icon' => 'fa fa-cogs', 
                                    'url' => ['/admin/agencies'], 
                                    'active' => $this->context->route == 'admin/agencies/index'
                                ],
                                [
                                    'label' => 'Diva Promotions', 
                                    'icon' => 'fa fa-cogs', 
                                    'url' => ['/admin/promotions'], 
                                    'active' => $this->context->route == 'admin/promotions/index'
                                ],
                                [
                                    'label' => 'Productions', 
                                    'icon' => 'fa fa-cogs', 
                                    'url' => ['/admin/production'], 
                                    'active' => $this->context->route == 'admin/production/index'
                                ],
                                [
                                    'label' => 'Events', 
                                    'icon' => 'fa fa-cogs', 
                                    'url' => ['/admin/events'], 
                                    'active' => $this->context->route == 'admin/events/index'
                                ],
                                [
                                    'label' => 'Office', 
                                    'icon' => 'fa fa-briefcase', 
                                    'url' => ['/admin/office'], 
                                    'active' => $this->context->route == 'admin/office/index'
                                ],
                                [
                                    'label' => 'About Us', 
                                    'icon' => 'fa fa-star-o', 
                                    'url' => ['/admin/about-us'], 
                                    'active' => $this->context->route == 'admin/about-us/index'
                                ],
                                [
                                    'label' => 'Contacts', 
                                    'icon' => 'fa fa-map-marker', 
                                    'url' => ['/admin/contacts'], 
                                    'active' => $this->context->route == 'admin/contacts/index'
                                ],
                                [
                                    'label' => 'Slider', 
                                    'icon' => 'fa fa-exchange', 
                                    'url' => ['/admin/slider'], 
                                    'active' => $this->context->route == 'admin/slider/index'
                                ],
                                [
                                    'label' => 'Main Categories', 
                                    'icon' => 'fa fa-tasks', 
                                    'url' => ['/admin/main-list'], 
                                    'active' => $this->context->route == 'admin/main-list/index'
                                ],
//                                [
//                                    'label' => 'Diva', 
//                                    'icon' => 'fa fa-diamond', 
//                                    'url' => ['/admin/diva'], 
//                                    'active' => $this->context->route == 'admin/diva/index'
//                                ],
                               
//                                [
//                                    'label' => 'User Productions', 
//                                    'icon' => 'fa fa-cogs', 
//                                    'url' => ['/admin/production-user'], 
//                                    'active' => $this->context->route == 'admin/production-user/index'
//                                ],

                                [
                                    'label' => 'Services', 
                                    'icon' => 'fa fa-graduation-cap', 
                                    'url' => ['/admin/services'], 
                                    'active' => $this->context->route == 'admin/services/index'
                                ],
                                [
                                    'label' => 'Email Theme', 
                                    'icon' => 'fa fa-envelope', 
                                    'url' => ['/admin/email-theme'], 
                                    'active' => $this->context->route == 'admin/email-theme/index'
                                ],
                                [
                                    'label' => 'Register Fields', 
                                    'icon' => 'fa fa-bars', 
                                    'url' => ['/admin/register-fields'], 
                                    'active' => $this->context->route == 'admin/register-fields/index'
                                ],
                                [
                                    'label' => 'Share', 
                                    'icon' => 'fa fa-share-alt', 
                                    'url' => ['/admin/share'], 
                                    'active' => $this->context->route == 'admin/share/index'
                                ],
                                [
                                    'label' => 'Category',
                                    'icon' => 'fa fa-folder-open', 
                                    'url' => '#',
                                    'items' => [
                                        [
                                            'label' => 'Model Category',
                                            'icon' => 'fa fa-users',
                                            'url' => ['/admin/model-category'],
                                            'active' => $this->context->route == 'admin/model-category/index'
                                        ],
                                        [
                                            'label' => 'Model Subcategory',
                                            'icon' => 'fa fa-users',
                                            'url' => ['/admin/model-subcategory'],
                                            'active' => $this->context->route == 'admin/model-subcategory/index'
                                        ],
                                    ]
                                ],
                            ]
                        ],
                       
                        
                        
                       
                       
                       
                       
//                        [
//                            'label' => 'Categories', 
//                            'icon' => 'fa fa-tasks', 
//                            'url' => ['/admin/categories'], 
//                            'active' => $this->context->route == 'admin/categories/index'
//                        ],
//                        [
//                            'label' => 'Digital Marketing', 
//                            'icon' => 'fa fa-users', 
//                            'url' => ['/admin/digital-marketing'], 
//                            'active' => $this->context->route == 'admin/digital-marketing/index'
//                        ],
//                        [
//                            'label' => 'Our Work', 
//                            'icon' => 'fa fa-users', 
//                            'url' => ['/admin/our-work'], 
//                            'active' => $this->context->route == 'admin/our-work/index'
//                        ],
                        
                            [
                                'label' => 'Awards',
                                'icon' => 'fa fa-star-o',
                                'url' => ['/admin/awards'],
                                'active' => $this->context->route == 'admin/awards/index'
                            ],
                            [
                            'label' => 'Booking',
                            'icon' => 'fa fa-address-card',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'Booking Form',
                                    'icon' => 'fa fa-users',
                                    'url' => ['/admin/booking-form'],
				    'active' => $this->context->route == 'admin/booking-form/index'
                                ],
                                [
                                    'label' => 'Booking Status',
                                    'icon' => 'fa fa-users',
                                    'url' => ['/admin/booking'],
				    'active' => $this->context->route == 'admin/booking/index'
                                ],
                                [
                                    'label' => 'Booking',
                                    'icon' => 'fa fa-users',
                                    'url' => ['/admin/book-fields-user'],
				    'active' => $this->context->route == 'admin/book-fields-user/index'
                                ],
                                [
                                    'label' => 'Booking ',
                                    'icon' => 'fa fa-address-card',
                                    'url' => ['/admin/book'],
				    'active' => $this->context->route == 'admin/book/index'
                                ],
                                [
                                    'label' => 'Fields',
                                    'icon' => 'fa fa-bars',
                                    'url' => ['/admin/book-fields'],
				    'active' => $this->context->route == 'admin/book-fields/index'
                                ],
                            ]
                        ],
                        [
                            'label' => 'Talents',
                            'icon' => 'fa fa-folder-open', 
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'All Talents',
                                    'icon' => 'fa fa-users',
                                    'url' => ['/admin/user-info'],
				    'active' => in_array($this->context->route, [
                                        'admin/user-info/index',
                                        'admin/user-media/index'
                                    ])
                                ],
                                [
                                    'label' => 'Model Management', 
                                    'icon' => 'fa fa-users', 
                                    'url' => ['/admin/model-management'], 
                                    'active' => $this->context->route == 'admin/model-management/index'
                                ],
                                [
                                    'label' => 'Model Event', 
                                    'icon' => 'fa fa-users', 
                                    'url' => ['/admin/model-event'], 
                                    'active' => $this->context->route == 'admin/model-event/index'
                                ],
                                [
                                    'label' => 'Promotions/Activations', 
                                    'icon' => 'fa fa-users', 
                                    'url' => ['/admin/promotions-activations'], 
                                    'active' => $this->context->route == 'admin/promotions-activations/index'
                                ],
                                [
                                    'label' => 'Production', 
                                    'icon' => 'fa fa-users', 
                                    'url' => ['/admin/model-production'], 
                                    'active' => $this->context->route == 'admin/model-production/index'
                                ],
                                [
                                    'label' => 'Digital Marketing', 
                                    'icon' => 'fa fa-users', 
                                    'url' => ['/admin/digital-marketing'], 
                                    'active' => $this->context->route == 'admin/digital-marketing/index'
                                ],
                                [
                                    'label' => 'Our work', 
                                    'icon' => 'fa fa-users', 
                                    'url' => ['/admin/our-work'], 
                                    'active' => $this->context->route == 'admin/our-work/index'
                                ],
                            ]
                        ],
                        [
                            'label' => 'Register', 
                            'icon' => 'fa fa-user-o', 
                            'url' => ['/admin/register'], 
                            'active' => $this->context->route == 'admin/register/index'
                        ],
                        [
                            'label' => 'Post Blogs', 
                            'icon' => 'fa fa-comments-o', 
                            'url' => ['/admin/blogs'], 
                            'active' => $this->context->route == 'admin/blogs/index'
                        ],
                        [
                            'label' => 'IT Manager', 
                            'icon' => 'fa fa-area-chart', 
                            'url' => ['/admin/it-manager'], 
                            'active' => $this->context->route == 'admin/it-manager/index'
                        ],
                        [
                            'label' => 'IT USERS',
                            'icon' => 'fa fa-users',
                            'url' => ['/admin/user'],
                            'active' => $this->context->route == 'admin/user/index'
                        ],
                        [
                            'label' => 'Casting Call', 
                            'icon' => 'fa fa-envelope', 
                            'url' => ['/admin/casting-call'], 
                            'active' => $this->context->route == 'admin/casting-call/index'
                        ],
                        [
                            'label' => 'View Job Casting',
                            'icon' => 'fa fa-gavel', 
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'View Job Casting',
                                    'icon' => 'fa fa-gavel',
                                    'url' => ['/admin/casting'],
                                    'active' => $this->context->route == 'admin/casting/index'
                                ],
                                [
                                    'label' => 'Casting Users',
                                    'icon' => 'fa fa-users',
                                    'url' => ['/admin/casting-user'],
				    'active' => $this->context->route == 'admin/casting-user/index'
                                ],
                            ]
                        ],
                        [
                            'label' => 'Clients', 
                            'icon' => 'fa fa-users', 
                            'url' => ['/admin/clients'], 
                            'active' => $this->context->route == 'admin/clients/index'
                        ],
                        [
                            'label' => 'FAQ',
                            'icon' => 'fa fa-comments-o',
                            'url' => '#',
                            'items' => [
                                [
                                    'label' => 'FAQ', 
                                    'icon' => 'fa fa-comments-o', 
                                    'url' => ['/admin/faq'], 
                                    'active' => $this->context->route == 'admin/faq/index'
                                ],
                                [
                                    'label' => 'Question', 
                                    'icon' => 'fa fa-users', 
                                    'url' => ['/admin/faq-ask'], 
                                    'active' => $this->context->route == 'admin/faq-ask/index'
                                ],
                            ]
                        ],
                        
                        
                        
                        
//                        [
//                            'label' => 'Service',
//                            'icon' => 'fa fa-graduation-cap',
//                            'url' => '#',
//                            'items' => [
//                                [
//                                    'label' => 'Service', 
//                                    'icon' => 'fa fa-graduation-cap', 
//                                    'url' => ['/admin/services'], 
//                                    'active' => $this->context->route == 'admin/services/index'
//                                ],
//                                [
//                                    'label' => 'Service Categories', 
//                                    'icon' => 'fa fa-cogs', 
//                                    'url' => ['/admin/service-categories'], 
//                                    'active' => $this->context->route == 'admin/service-categories/index'
//                                ],
//                                [
//                                    'label' => 'Service User', 
//                                    'icon' => 'fa fa-users', 
//                                    'url' => ['/admin/service-user'], 
//                                    'active' => $this->context->route == 'admin/service-user/index'
//                                ],
//                            ]
//                        ],
                    ],
                ]
        )
        ?>
        
    </section>
    <!-- /.sidebar -->
</aside>
