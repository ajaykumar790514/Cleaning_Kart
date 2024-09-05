<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="public/assets/images/favicon.png">
    <title><?php echo $title; ?> | ADMIN | <?= $dashboard->fullName; ?></title>
    <base href="<?php echo base_url();?>">
    <!-- Bootstrap Core CSS -->
    <link href="public/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="public/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="public/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="public/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!--This page css - Morris CSS -->
    <link href="public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="public/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="public/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />


    <link href="public/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
    <link href="public/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="public/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="public/assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
    <!-- Custom CSS -->
    <link href="public/assets/css/style.css" rel="stylesheet">
    <link href="public/assets/css/custom.css" rel="stylesheet">

    <link href="public/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url('public/assets/plugins/toastr/toastr.min.css'); ?>">
    <!-- You can change the theme colors from here -->
    <link href="public/assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="public/assets/js/jquery.validate.min.js"></script>
    <!---JS grid tags start---->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" integrity="sha512-3Epqkjaaaxqq/lt5RLJsTzP6cCIFyipVRcY4BcPfjOiGM1ZyFCv4HHeWS7eCPVaAigY3Ha3rhRgOsWaWIClqQQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" integrity="sha512-jx8R09cplZpW0xiMuNFEyJYiGXJM85GUL+ax5G3NlZT3w6qE7QgxR4/KE1YXhKxijdVTDNcQ7y6AJCtSpRnpGg==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous"></script>

    <!--Toggle button css-->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

  <!-- <script type="text/javascript">
 
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  </script> -->
<style>
    body{
        color:black;
    }
    .card-img-top {
        height: 200px;
    }
    .error{
        color: #dc3545;
    }
.pag{
    margin: 12px 0px;
}
.pag a{
    color: white;
    background-color: #1e88e5;
    height: 30px;
    margin: 2px;
    padding: 4px 10px;
    border-radius: 2px;
    box-shadow: 0px 0px 3px 0px #1e88e5;
}
.pag strong{
    color: #1e88e5;
    background-color: white;
    height: 30px;
    width: 40px;
    margin: 2px;
    font-weight: bold;
    padding: 4px 10px;
    cursor: not-allowed;
    border-radius: 2px;
    box-shadow: 0px 0px 3px 0px #1e88e5;
}
</style>

    <!---JS grid tags end------>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border logo-center">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light" style="max-width:100% !important; padding-left:10px;">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header" style="width:100% !important;">
                    <a class="navbar-brand text-white" href="<?php echo base_url('admin-dashboard');?>">
                    <?php echo $dashboard->fullName; ?>
                    </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="notificationIcon"> <i class="mdi mdi-message"></i>
                           
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center" id="messageCenter">
                                           
                                        </div>
                                        <script>
                                            // setInterval(function(){ 
                                            //     $.ajax({
                                            //         'url': "orders/getNewOrders",
                                            //         'dataType': "json",
                                            //         'success': function (data) {
                                            //             if(data.status == true){
                                            //                 $('#messageCenter').prepend(data.message);
                                            //             }
                                            //             if(data.icon_status){
                                            //                 $('#notificationIcon').html('<i class="mdi mdi-message"></i><div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>');
                                            //             }
                                            //         }
                                            //     });
                                            // }, 10000);
                                        </script>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0)"> <strong>Check all Orders</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo IMGS_URL.$dashboard->photo; ?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="public/assets/images/shopzone-logo.png" alt="user"></div>
                                            <div class="u-text">
                                                <h4></h4>
                                                <p class="text-muted"></p><a href="<?php echo base_url('admin-profile'); ?>" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li class="ml-3"><b>Total Reward Points = <?= $dashboard->rewards; ?></b></li>
                                    <li><a href="<?php echo base_url('admin-change-password'); ?>"><i class="ti-key"></i> Change Password</a></li>
                                    <!-- <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                    <li role="separator" class="divider"></li> -->
                                    <li><a href="<?php echo base_url('admin-logout'); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Language -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->

        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" style="max-width:100% !important;">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php foreach($admin_menus as $menu){ ?>
                        <li>
                            <a href="<?php echo base_url($menu->url.'/'.$menu->id) ?>"><i class="<?= $menu->icon_class; ?>"></i><span class="hide-menu"><?= $menu->title; ?></span></a>
                        </li>
                        <?php } ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        