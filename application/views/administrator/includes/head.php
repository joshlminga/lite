<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html lang="en">
    
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $site_title; ?></title>

        <!-- Vendor CSS -->
        <link href="<?= base_url($assets); ?>/vendors/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/bower_components/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet">    
        <link href="<?= base_url($assets); ?>/vendors/bootgrid/jquery.bootgrid.min.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/bower_components/google-material-color/dist/palette.css" rel="stylesheet">

        <link href="<?= base_url($assets); ?>/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/bower_components/nouislider/distribute/jquery.nouislider.min.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/farbtastic/farbtastic.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/bower_components/chosen/chosen.min.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/vendors/summernote/dist/summernote.css" rel="stylesheet">

        <!-- CSS -->
        <link href="<?= base_url($assets); ?>/css/app.min.1.css" rel="stylesheet">
        <link href="<?= base_url($assets); ?>/css/app.min.2.css" rel="stylesheet"> 

        <!-- Custom -->
        <link href="<?= base_url($assets); ?>/custom/custom.css" rel="stylesheet"> 

        <!-- Font Awsome -->
        <script src="https://use.fontawesome.com/36d9a607df.js"></script>

    </head>




    <body data-ma-header="teal">
        <header id="header" class="media">
            <div class="pull-left h-logo">
                <a href="index.php" class="hidden-xs">
                    CORE  
                    <small>The Lite</small>
                </a>
                
                <div class="menu-collapse" data-ma-action="sidebar-open" data-ma-target="main-menu">
                    <div class="mc-wrap">
                        <div class="mcw-line top palette-White bg"></div>
                        <div class="mcw-line center palette-White bg"></div>
                        <div class="mcw-line bottom palette-White bg"></div>
                    </div>
                </div>
            </div>

            <ul class="pull-right h-menu">
                <li class="hm-search-trigger">
                    <a href="#" data-ma-action="search-open">
                        <i class="hm-icon zmdi zmdi-search"></i>
                    </a>
                </li>
                <!--
                <li class="dropdown hidden-xs hidden-sm h-apps">
                    <a data-toggle="dropdown" href="#">
                        <i class="hm-icon zmdi zmdi-apps"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="#">
                                <i class="palette-Red-400 bg zmdi zmdi-calendar"></i>
                                <small>Calendar</small>
                            </a>
                        </li>
                        
                        <li>
                            <a href="#">
                                <i class="palette-Green-400 bg zmdi zmdi-file-text"></i>
                                <small>Files</small>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="palette-Light-Blue bg zmdi zmdi-email"></i>
                                <small>Mail</small>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="palette-Orange-400 bg zmdi zmdi-trending-up"></i>
                                <small>Analytics</small>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="palette-Purple-300 bg zmdi zmdi-view-headline"></i>
                                <small>News</small>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="palette-Blue-Grey bg zmdi zmdi-image"></i>
                                <small>Gallery</small>
                            </a>
                        </li>
                    </ul>
                </li>
                -->
                <li class="dropdown hidden-xs">
                    <a data-toggle="dropdown" href="#"><i class="hm-icon zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dm-icon pull-right">
                        <li class="hidden-xs">
                            <a data-action="fullscreen" href="#"><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
                        </li>
                    </ul>
                </li>
                <li class="hm-alerts" data-user-alert="sua-messages" data-ma-action="sidebar-open" data-ma-target="user-alerts">
                    <a href="#"><i class="hm-icon zmdi zmdi-notifications"></i></a>
                </li>
                <li class="dropdown hm-profile">
                    <a data-toggle="dropdown" href="#">
                        <img src="<?= base_url($assets); ?>/img/profile-pics/1.jpg" alt="">
                    </a>
                    
                    <ul class="dropdown-menu pull-right dm-icon">
                        <li>
                            <a href="#"><i class="zmdi zmdi-account"></i> View Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="zmdi zmdi-settings"></i> Settings</a>
                        </li>
                        <li>
                            <a href='<?= site_url("admin/logout");?>'><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <div class="media-body h-search">
                <div class="p-relative">
                    <span class="welcome-header">
                        Welcome to Core Lite, you're running Lite version 1.0 | Build Faster &amp; Smart.
                    </span>
                </div>
            </div>
            
        </header>



        <section id="main">

            <aside id="s-main-menu" class="sidebar">
                <div class="smm-header">
                    <i class="zmdi zmdi-long-arrow-left" data-ma-action="sidebar-close"></i>
                </div>

                <ul class="smm-alerts">
                    <li class="">
                        <i class="zmdi zmdi-flash"></i> Core v3.0 (Lite)
                    </li>
                </ul>

                <ul class="main-menu">
                    <li class="dashboard">
                        <a href="<?= site_url('dashboard') ?>"><i class="zmdi zmdi-input-composite"></i> Dashboard</a>
                    </li>
                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle">
                            <i class="zmdi zmdi-format-color-text green_less"></i> Blog 
                        </a>
                        <ul>
                            <li class=""><a href="#">New</a></li>
                            <li class=""><a href="#">Tags</a></li>
                            <li class=""><a href="#">Category</a></li>
                            <li class=""><a href="#">Manage</a></li> <!--active -->
                        </ul>
                    </li>
                    <li class="" style="display: none;"><a href="#"><i class="zmdi zmdi-comment-list"></i> Blog Comments</a></li>
                    <li class="sub-menu" style="display: none;">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-file-plus green_less"></i> Page </a>
                        <ul>
                            <li class=""><a href="#">New</a></li>
                            <li class=""><a href="#">Manage</a></li>
                        </ul>
                    </li>
                    <?php if ($this->CoreLoad->auth('user')): ?>
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-alt"></i> User </a>
                        <ul>
                            <li class=""><a href="<?= site_url('users/new') ?>">New</a></li>
                            <li class=""><a href="<?= site_url('users') ?>">Manage</a></li> <!--active -->
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('customer')): ?>
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-pin-account zmdi-hc-fw"></i> Customer </a>
                        <ul>
                            <li class=""><a href="<?= site_url('customers/new') ?>">New</a></li>
                            <li class=""><a href="<?= site_url('customers') ?>">Manage</a></li> <!--active -->
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('company')): ?>
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-local-convenience-store zmdi-hc-fw blue"></i> Companies </a>
                        <ul>
                            <li class=""><a href="<?= site_url('companies/new') ?>">New</a></li>
                            <li class=""><a href="<?= site_url('companies') ?>">Manage</a></li> <!--active -->
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('listing')): ?>
                    <!-- Listing -->
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-plus-circle-o-duplicate purple"></i> Listing Plus </a>
                        <ul>
                            <li class=""><a href="<?= site_url('listing_companies') ?>">Companies</a></li>
                            <li class=""><a href="<?= site_url('listing_configs') ?>">Config</a></li>
                        </ul>
                    </li>
                    <!-- End Listing -->
                    <?php endif ?>
                    <li class="" style="display: none;"><a href="#"><i class="zmdi zmdi-plus-circle-o-duplicate purple"></i> Content Plus </a></li>
                    <!-- Extensions -->
                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-puzzle-piece blue"></i> Extensions </a>
                        <ul>
                            <li class=""><a href="#">Manage</a></li>
                            <li class=""><a href="#">New</a></li>
                        </ul>
                    </li>
                    <!-- End Extensions -->

                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-settings red_less"></i> Controls </a>
                        <ul>
                            <li class="" style="display: none;"><a href="#">Store</a></li>
                            <li class="" style="display: none;"><a href="#">Import</a></li>
                            <li class="" style="display: none;"><a href="#">Export</a></li>
                            <li class=""><a href="<?= site_url('fieldcustoms') ?>">Manage Field</a></li>
                            <li class=""><a href="<?= site_url('customfields') ?>">Custom Fields</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-flower yellow"></i> Themes </a>
                        <ul>
                            <li class=""><a href="#">Manage</a></li>
                            <li class=""><a href="#">Customize</a></li>
                            <li class=""><a href="#">Menu</a></li>
                            <li class=""><a href="#">CSS</a></li>
                            <li class=""><a href="#">Header</a></li>
                            <li class=""><a href="#">Footer</a></li>
                        </ul>
                    </li>

                    <li class="" style="display: none;"><a href="#"><i class="zmdi zmdi-star-half yellow"></i> Widgets </a></li>

                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle">
                            <i class="zmdi zmdi-flower-alt green"></i> ATU Page Builder 
                        </a>
                        <ul>
                            <li class=""><a href="#">General</a></li>
                            <li class=""><a href="#">Role Manager</a></li>
                            <li class=""><a href="#">CSS/JS</a></li>
                            <li class=""><a href="#">Shortcode</a></li>
                            <li class=""><a href="#">About</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-alt"></i> User </a>
                        <ul>
                            <li class=""><a href="#">New</a></li>
                            <li class=""><a href="#">Manage</a></li> <!--active -->
                        </ul>
                    </li>

                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-wrench red_less"></i> Settings </a>
                        <ul>
                            <li class=""><a href="#">General</a></li>
                            <li class=""><a href="#">Link</a></li>
                            <li class=""><a href="#">Blog</a></li>
                            <li class=""><a href="#">Mail</a></li>
                            <li class=""><a href="#">About</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu" style="display: none;"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-swap-vertical-circle blue"></i> About </a>
                        <ul>
                            <li class=""><a href="#">Core</a></li>
                            <li class=""><a href="#">News</a></li>
                            <li class=""><a href="#">Updates</a></li>
                        </ul>
                    </li>

                </ul>
            </aside>
