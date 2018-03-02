    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="javascript:;"> Profile</a></li>
                        <li>
                            <a href="javascript:;">
                                <span class="badge bg-red pull-right">50%</span>
                                <span>Settings</span>
                            </a>
                        </li>
                        <li><a href="javascript:;">Help</a></li>
                        <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
                <div class="lng-holder">
                    <?php 
//                    = \lajax\languagepicker\widgets\LanguagePicker::widget([
//                        'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
//                        'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
//                    ]);
                    ?>
                </div>
            </ul>
        </nav>
    </div>
<?php 
$this->registerCss("
    .language-picker.large i.pt, .language-picker.large i.pt-PT {
        background-position: 0px -15px;
    }");
?>
