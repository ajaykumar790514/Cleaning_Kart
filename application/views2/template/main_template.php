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
    <title>ADMIN | <?= $_SESSION['user_data']['shop_name'] ?></title>
    <base href="<?php echo base_url();?>">
    <!-- Bootstrap Core CSS -->
    <link href="public/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- chartist CSS -->
    <!-- <link href="public/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="public/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="public/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet"> -->
    <!--This page css - Morris CSS -->
    <link href="public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="public/assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="public/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="public/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url('public/assets/plugins/toastr/toastr.min.css'); ?>">

    <link href="public/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
    <link href="public/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="public/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="public/assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" id="theme-styles">
    <!-- Custom CSS -->
    <link href="public/assets/css/style.css" rel="stylesheet">
    <link href="public/assets/css/custom.css" rel="stylesheet">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="public/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <!-- You can change the theme colors from here -->
    <link href="public/assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="public/assets/js/jquery.validate.min.js"></script>
    <!---JS grid tags start---->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" integrity="sha512-3Epqkjaaaxqq/lt5RLJsTzP6cCIFyipVRcY4BcPfjOiGM1ZyFCv4HHeWS7eCPVaAigY3Ha3rhRgOsWaWIClqQQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" integrity="sha512-jx8R09cplZpW0xiMuNFEyJYiGXJM85GUL+ax5G3NlZT3w6qE7QgxR4/KE1YXhKxijdVTDNcQ7y6AJCtSpRnpGg==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js" integrity="sha512-blBYtuTn9yEyWYuKLh8Faml5tT/5YPG0ir9XEABu5YCj7VGr2nb21WPFT9pnP4fcC3y0sSxJR1JqFTfTALGuPQ==" crossorigin="anonymous"></script>
    <!-- Toastr -->
<script src="<?php echo base_url('public/assets/plugins/toastr/toastr.min.js'); ?>"></script>

 <script src="<?php echo base_url('public/assets/plugins/select2/dist/js/select2.full.min.js'); ?>" type="text/javascript"></script>


<script>
    $(document).ready(function() {
        // ----------------Sweetalert2-----------------//
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000
            });

            <?php if ($this->session->flashdata('success')) { ?>

                toastr.success('<?php echo $this->session->flashdata('success'); ?>')
            <?php }
            if ($this->session->flashdata('error')) { ?>

                toastr.error('<?php echo $this->session->flashdata('error'); ?>')
            <?php } ?>


        });

    });
</script>
    <style>
        body{
        color:black;
        },
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

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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
                    <a class="navbar-brand text-white" href="<?php echo base_url();?>">
                        <?php echo $_SESSION['user_data']['shop_name']?>
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
                            <?php
                            $newOrders = $this->orders_model->getNewOrdersRows(array('conditions'=>array('status'=>'17')));
                            if($newOrders!==FALSE){
                                echo '<div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>';
                            }
                            ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center" id="messageCenter">
                                            <?php
                                                $count=1;
                                                if($newOrders!==FALSE){
                                                    $_SESSION['orders_notification_last_id'] = $newOrders[0]['id'];
                                                    foreach($newOrders as $orders){
                                                        if($count <= 5){
                                                            echo '<a href="orders/'.$orders['id'].'">
                                                                    <div class="mail-contnet">
                                                                        <h5>'.$orders['customer_name'].' - <small>New Order</small></h5>
                                                                        <span class="mail-desc"></span>
                                                                        <span class="time">'.date('M j, Y g:i a',strtotime($orders['added'])).'</span>
                                                                    </div>
                                                                </a>';
                                                            $count++;
                                                        }
                                                    }
                                                }else{
                                                    $_SESSION['orders_notification_last_id'] = 0;
                                                }
                                            ?>
                                        </div>
                                        <script>
                                            setInterval(function(){ 
                                                $.ajax({
                                                    'url': "orders/getNewOrders",
                                                    'dataType': "json",
                                                    'success': function (data) {
                                                        if(data.status == true){
                                                            $('#messageCenter').prepend(data.message);
                                                        }
                                                        if(data.icon_status){
                                                            $('#notificationIcon').html('<i class="mdi mdi-message"></i><div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>');
                                                        }
                                                    }
                                                });
                                            }, 10000);
                                        </script>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="orders"> <strong>Check all Orders</strong> <i class="fa fa-angle-right"></i> </a>
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
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="<?php echo IMGS_URL.$shop_photo;?>" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="<?php echo IMGS_URL.$shop_photo;?>" alt="user"></div>
                                            <!-- <div class="u-img"><img src="public/assets/images/shopzone-logo.png" alt="user"></div> -->
                                            <div class="u-text">
                                                <h4><?php echo $_SESSION['user_data']['shop_name'];?></h4>
                                                <p class="text-muted"><?php echo $_SESSION['user_data']['email'];?></p><a href="<?= base_url('shop-profile'); ?>" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li><!--
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                    <li role="separator" class="divider"></li>-->
                                    <li><a href="<?php echo base_url('shop-change-password'); ?>"><i class="ti-key"></i> Change Password</a></li>
                                    <li><a href="logout"><i class="fa fa-power-off"></i> Logout</a></li>
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
        <?php
            echo $menu; 
        ?>
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="max-width: 100% !important;">
                <?php
                    echo $main_body_data;
                ?>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                
                <div class="float-right">
                    Page rendered in <strong>{elapsed_time}</strong> seconds.
                </div>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="public/assets/plugins/popper/popper.min.js"></script>
    <script src="public/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="public/assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="public/assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="public/assets/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="public/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="public/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="public/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="public/assets/plugins/switchery/dist/switchery.min.js"></script>
    
    <!-- <script src="public/assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script> -->
    <script src="public/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="public/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
    <script src="public/assets/plugins/dff/dff.js" type="text/javascript"></script>
    <script type="text/javascript" src="public/assets/plugins/multiselect/js/jquery.multi-select.js"></script>

    <script src="public/assets/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
   
    <!-- Sweet-Alert  -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="public/assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>
    <!--c3 JavaScript -->
    <script src="public/assets/plugins/d3/d3.min.js"></script>
    <script src="public/assets/plugins/c3-master/c3.min.js"></script>
    <!-- Chart JS -->
    <!-- <script src="public/assets/js/dashboard1.js"></script> -->
    <script>
        $(".select2").select2();
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="public/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

</body>

</html>
