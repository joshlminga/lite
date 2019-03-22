<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $site_title; ?></title>

        <meta name="author" content="Core CMS Lite Team">
        <meta name="robots" content="noindex, nofollow">

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
                <a href="<?= site_url('dashboard'); ?>" class="hidden-xs">
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
                <li class="dropdown hidden-xs">
                    <a data-toggle="dropdown" href="#"><i class="hm-icon zmdi zmdi-more-vert"></i></a>
                    <ul class="dropdown-menu dm-icon pull-right">
                        <li class="hidden-xs">
                            <a data-action="fullscreen" href="#"><i class="zmdi zmdi-fullscreen"></i> Toggle Fullscreen</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown hm-profile">
                    <a data-toggle="dropdown" href="#">
                        <img src="<?= base_url($assets); ?>/img/profile-pics/1.jpg" alt="">
                    </a>
                    
                    <ul class="dropdown-menu pull-right dm-icon">
                        <li>
                            <a class="core-sub-link" href="<?= site_url('') ?>" target="_blank">
                                <i class="zmdi zmdi-view-web"></i> View Website
                            </a>
                        </li>
                        <li>
                            <a href='<?= site_url("profile")?>'><i class="zmdi zmdi-account"></i> My Profile</a>
                        </li>
                        <li>
                            <a href='<?= site_url("admin/logout")?>'><i class="zmdi zmdi-time-restore"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <div class="media-body h-search hidden-xs hidden-sm">
                <div class="p-relative">
                    <span class="welcome-header">
                        <?= $copyright_head; ?>
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
                    <li class="core-sub-item">
                        <i class="zmdi zmdi-flash"></i> <?= $copyright_side; ?>
                    </li>
                </ul>

                <ul class="main-menu">
                    <li class="dashboard">
                        <a class="core-sub-link" href="<?= site_url('dashboard') ?>"><i class="zmdi zmdi-input-composite"></i>
                        Dashboard
                        </a>
                    </li>
                    <?php if ($this->CoreLoad->auth('author')): ?>
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle">
                            <i class="zmdi zmdi-format-color-text green_less"></i> Blog 
                        </a>
                        <ul>
                            <li class=""><a href="<?= site_url('blogs/new') ?>">New</a></li>
                            <li class=""><a href="<?= site_url('blogtag') ?>">Tags</a></li>
                            <li class=""><a href="<?= site_url('blogcategory') ?>">Category</a></li>
                            <li class=""><a href="<?= site_url('blogs') ?>">Manage</a></li> <!--active -->
                        </ul>
                    </li>
                    <li class="" style="display: none;"><a href="#"><i class="zmdi zmdi-comment-list"></i> Blog Comments</a></li>
                    <li class="sub-menu">
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-file-plus green_less"></i> Page </a>
                        <ul>
                            <li class=""><a href="<?= site_url('pages/new') ?>">New</a></li>
                            <li class=""><a href="<?= site_url('pages') ?>">Manage</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('autofield')): ?>
                    <li class=""><a href="<?= site_url('autofields') ?>">
                        <i class="zmdi zmdi-folder-star zmdi-hc-fw blue"></i> Auto Fields</a>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('userdata')): ?>
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-assignment zmdi-hc-fw red_less"></i> 
                            Field Control User 
                        </a>
                        <ul>
                            <li class=""><a href="<?= site_url('userdatas/new') ?>">New</a></li>
                            <li class=""><a href="<?= site_url('userdatas') ?>">Manage</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('user')): ?>
                    <li class="sub-menu"> <!-- active -->
                        <a href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-pin-account zmdi-hc-fw blue"></i> Customer </a>
                        <ul>
                            <li class=""><a href="<?= site_url('customers/new') ?>">New</a></li>
                            <li class=""><a href="<?= site_url('customers') ?>">Manage</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('admin')): ?>
                    <li class="sub-menu">
                        <a class="core-sidebar-link" href="#" data-ma-action="submenu-toggle">
                            <i class="zmdi zmdi-settings red_less"></i> Controls </a>
                        <ul>
                            <li class="core-sub-item" style="display: none;"><a href="#">Store</a></li>
                            <li class="core-sub-item" style="display: none;"><a href="#">Import</a></li>
                            <li class="core-sub-item"><a href="<?= site_url('inheritances') ?>">Inheritance</a></li>
                            <li class="core-sub-item">
                                <a class="core-sub-link" href="<?= site_url('customfields') ?>">
                                Custom Fields
                                </a>
                            </li>
                            <li class="core-sub-item">
                                <a class="core-sub-link" href="<?= site_url('level') ?>">
                                Access Level
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('user')): ?>
                    <li class="sub-menu">
                        <a class="core-sidebar-link" href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-accounts-alt"></i> User </a>
                        <ul>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('users/new') ?>">New</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('users') ?>">Manage</a></li> 
                        </ul>
                    </li>
                    <?php endif ?>
                    <?php if ($this->CoreLoad->auth('admin')): ?>
                    <li class="sub-menu">
                        <a class="core-sidebar-link" href="#" data-ma-action="submenu-toggle"><i class="zmdi zmdi-wrench red_less"></i> Settings </a>
                        <ul>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('general'); ?>">General</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('link'); ?>">Link</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('blog'); ?>">Page / Blog</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('mail'); ?>">Mail</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('seo'); ?>">Seo</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('inheritance'); ?>">Set Inheritance</a></li>
                            <li class="core-sub-item"><a class="core-sub-link" href="<?= site_url('module'); ?>">Modules</a></li>
                        </ul>
                    </li>
                    <?php endif ?>
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
