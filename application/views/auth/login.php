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
    <title>LOGIN</title>
    <base href="<?php echo base_url(); ?>">
    <!-- Bootstrap Core CSS -->
    <link href="public/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="public/assets/css/style.css" rel="stylesheet">
        <!-- Toastr -->
        <link rel="stylesheet" href="<?php echo base_url('public/assets/plugins/toastr/toastr.min.css'); ?>">
    <!-- You can change the theme colors from here -->
    <link href="public/assets/css/colors/blue.css" id="theme" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
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
    <!--Commented by sanya on 06-01-2022-->
    <!-- <section id="wrapper" class="login-register login-sidebar" style="background-image:url(public/assets/images/background/ckbg.png);"> -->
    <section id="wrapper" class="login-register login-sidebar">
        <div class="login-box card">
            <div class="card-body">
                
<!--                <a href="javascript:void(0)" class="text-center db"><img src="public/assets/images/ckweblogo.png" width="250px" height="100px" alt="Home" /></a>-->
                <br />
                <br />
                <center>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label id="admin-label" class="transition btn btn-primary active" onclick="transition_button('admin-label');">
                            ADMIN
                        </label>
                        <label id="business-label" class="transition btn btn-secondary" onclick="transition_button('business-label');">
                            BUSINESS
                        </label>
                        <label id="shop-label" class="transition btn btn-secondary " onclick="transition_button('shop-label');">
                            SHOP
                        </label>
                    </div>
                </center>
                <script>
                    function transition_button(id){
                        $(".transition").attr('class', 'transition btn btn-secondary');
                        $("#"+id).attr('class', 'transition btn btn-primary');
                        switch(id){
                            case 'admin-label': $("#business-label-form").slideUp(); $("#shop-label-form").slideUp(); $("#admin-label-form").fadeIn(); break;
                            case 'business-label': $("#shop-label-form").slideUp(); $("#admin-label-form").slideUp(); $("#business-label-form").fadeIn(); break;
                            case 'shop-label': $("#admin-label-form").slideUp(); $("#business-label-form").slideUp(); $("#shop-label-form").fadeIn(); break;
                            default: break;
                        }
                    }
                </script>

                <form class="form-horizontal form-material" id="admin-label-form"  method="post" action="<?php echo base_url('admin-login'); ?>">
                
                    <div class="form-group m-t-40">
                        <?php if($this->session->flashdata('errormsg')) { ?>
                    <h5 class="text-danger"><i class="fas fa-times text-danger"></i> <?php echo $this->session->flashdata('errormsg'); ?></h5>
                    <?php } ?>
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" name="userName" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="password" placeholder="Enter Password">
                        </div>
                    </div>
                   <!--  <div class="form-group">
                        <div class="d-flex no-block align-items-right">
                            <div class="ml-auto">
                                <a href="javascript:void(0)" class="text-muted" id="admin-change-mobile">Change mobile number</a> 
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <input type="submit" class="btn btn-info btn-lg btn-block text-uppercase " value="Login">
                        </div>
                    </div>
                    <script>
                        
                        $("#admin-change-mobile").click(function(e){
                            e.preventDefault();
                            //$("#admin-enter-otp").slideUp();
                            //$("#admin-enter-mobile").fadeIn();
                        });
                    </script>
                </form>

                <form class="form-horizontal form-material" id="business-label-form" style="display:none;">
                    <div id="business-enter-mobile">
                        <div class="form-group m-t-40">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="mobile_business" placeholder="Mobile business" readonly>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" id="business-generate-otp">GENERATE OTP</button>
                            </div>
                        </div>
                    </div>
                    <div id="business-enter-otp" style="display:none;">
                        <div class="form-group m-t-40">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="mobile_business" placeholder="Username" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" name="otp_business" placeholder="ENTER OTP">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex no-block align-items-right">
                                <div class="ml-auto">
                                    <a href="javascript:void(0)" class="text-muted" id="business-change-mobile">Change mobile number</a> 
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>
                    </div>
                    <script>
                        $("#business-generate-otp").click(function(e){
                            e.preventDefault();
                            $("#business-enter-mobile").slideUp();
                            //$("#business-enter-mobile").hide();
                            $("#business-enter-otp").fadeIn();
                        });
                        $("#business-change-mobile").click(function(e){
                            e.preventDefault();
                            $("#business-enter-otp").slideUp();
                            $("#business-enter-mobile").fadeIn();
                            //$("#business-enter-otp").hide();
                        });
                    </script>
                </form>

                <form class="form-horizontal form-material" id="shop-label-form" style="display:none;">
                    <div id="shop-enter-password">
                        <div class="form-group m-t-40">
                        <h5 class="text-danger" id="shop-error-msg"></h5>
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="contact" id="contact" placeholder="Mobile Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" name="password" id="password" placeholder="Enter Password">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" id="shop-password-login">LOGIN</button>
                            </div>
                        </div>
                    </div>

                    <div id="shop-enter-mobile" style="display:none;">
                        <div class="form-group m-t-40">
                            <h5 class="text-danger" id="error-msg"></h5>
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="mobile_shop" id="otp-mobile-shop" placeholder="Enter Mobile Number">
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" id="shop-generate-otp">GENERATE OTP</button>
                            </div>
                        </div>
                    </div>
                    <div id="shop-enter-otp" style="display:none;">
                        <div class="form-group m-t-40">
                        <h5 class="text-danger" id="otp-error-msg"></h5>
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" id="mobile_shop" placeholder="Username" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                        <h5 class="text-danger" id="otp-error-msg"></h5>
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" id="otp_shop" placeholder="ENTER OTP">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="d-flex no-block align-items-right">
                                <div class="ml-auto">
                                    <a href="javascript:void(0)" class="text-muted" id="change-mobile">Change mobile number</a> 
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" id="shop-login">Log In</button>
                            </div>
                        </div>
                    </div>
                    <script>
                        $("#shop-password-login").click(function(e){
                            e.preventDefault();
                            $.ajax({
                                url: 'welcome/shop_login',
                                type: 'post',
                                data: {contact:$('#contact').val(),password:$('#password').val()},
                                dataType: 'json',
                                beforeSend: function() {
                                            $("#shop-password-login").attr("disabled", true);
                                            $("#shop-password-login").html("Please wait...");
                                        }, 
                                success: function(response) {
                                            if(response.status == true){
                                                if(response.message == 'secured')
                                                {
                                                    $("#shop-enter-password").slideUp();
                                                    $("#shop-enter-otp").fadeIn();
                                                    $('#shop-login').html("Log In "+response.otp);
                                                    $('#mobile_shop').val($('#contact').val());
                                                }
                                                else if(response.message == 'not_secured')
                                                {
                                                    location.reload();
                                                }
                                            }else{
                                                $('#shop-password-login').removeAttr("disabled");
                                                $('#shop-password-login').html("Log In");
                                                
                                                $("#shop-error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);
                                            }          
                                        },
                                error: function (response) {
                                    $("#error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;Something went wrong!!');
                                    $('#shop-generate-otp').removeAttr("disabled");
                                    $('#shop-generate-otp').html("Sign up");
                                        }
                            });
                        });
                        $("#shop-generate-otp").click(function(e){
                            e.preventDefault();
                            $.ajax({
                                url: 'welcome/shop_generate_otp',
                                type: 'post',
                                data: {mobile:$('#otp-mobile-shop').val()},
                                dataType: 'json',
                                beforeSend: function() {
                                            $("#shop-generate-otp").attr("disabled", true);
                                            $("#shop-generate-otp").html("Generating...");
                                        }, 
                                success: function(response) {
                                            if(response.status == true){
                                                $('#shop-login').html("Log In "+response.message);
                                                $('#mobile_shop').val($('#otp-mobile-shop').val());
                                                $("#shop-enter-mobile").slideUp();
                                                $("#shop-enter-otp").fadeIn();
                                            }else{
                                                $('#shop-generate-otp').removeAttr("disabled");
                                                $('#shop-generate-otp').html("Log In");
                                                
                                                $("#error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);
                                            }          
                                        },
                                error: function (response) {
                                    $("#error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;Something went wrong!!');
                                    $('#shop-generate-otp').removeAttr("disabled");
                                    $('#shop-generate-otp').html("Sign up");
                                        }
                            });
                        });
                        $("#change-mobile").click(function(e){
                            e.preventDefault();
                            $('#shop-generate-otp').removeAttr("disabled");
                            $("#shop-generate-otp").html("Generate OTP");
                            $("#shop-enter-otp").slideUp();
                            $("#shop-enter-mobile").fadeIn();
                            //$("#shop-enter-otp").hide();
                        });
                        $("#shop-login").click(function(e){
                           
                            e.preventDefault();
                            $.ajax({
                                url: 'welcome/shop_verify_login',
                                type: 'post',
                                data: {mobile:$('#mobile_shop').val(),otp:$('#otp_shop').val()},
                                dataType: 'json',
                                beforeSend: function() {
                                            $("#shop-login").attr("disabled", true);
                                            $("#shop-login").html("Logging in...");
                                        }, 
                                success: function(response) {
                                            if(response.status == true){
                                                location.reload();
                                            }else{
                                                $('#shop-login').removeAttr("disabled");
                                                $('#shop-login').html("Log in");
                                                $("#otp-error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;'+response.message);
                                            }          
                                        },
                                error: function (response) {
                                    $("#error-msg").html('<i class="fas fa-times text-danger"></i>&nbsp;Something went wrong!!');
                                    $('#shop-generate-otp').removeAttr("disabled");
                                    $('#shop-generate-otp').html("Log In");
                                        }
                            });
                        });
                    </script>
                </form>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="public/assets/plugins/jquery/jquery.min.js"></script>
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
    <!--Custom JavaScript -->
    <script src="public/assets/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="public/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
        <!-- Toastr -->
<script src="<?php echo base_url('public/assets/plugins/toastr/toastr.min.js'); ?>"></script>


</body>

</html>