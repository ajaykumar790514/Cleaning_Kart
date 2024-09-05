                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h3 class="card-title" id="test">Change Password</h3>
                                                <h6 class="card-subtitle"></h6>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                            
                                    <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('update-shop-password');?>" method="post">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Old Password</label>
                                                                                <input type="password" class="form-control" name="old_password">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">New Password</label>
                                                                                <input type="password" class="form-control" name="new_password" id="new_password">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Confirm Password</label>
                                                                                <input type="password" class="form-control" name="confirm_password">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                <input type="submit" class="btn btn-primary waves-light" type="submit" value="Submit">
                                                                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                                                                       
                                                                    </div>
                                                                    </div>
                                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
<script type="text/javascript">
$(document).ready(function() {
        // var old_password = $(".old_password").val();
        //   var new_password = $(".new_password").val();
    $(".needs-validation").validate({
        rules: {
            new_password:"required",
            confirm_password:{
                required:true,
                equalTo:"#new_password"
            },
            old_password:{
                required:true,
            }
            
        },
        messages: {
            new_password:"This field is required",
            confirm_password: {
                required : "This field is required",
                equalTo : "Password does not match!!"
            },
            old_password: {
                required : "Enter Old Password",
                remote : "Password Does not match!"
            }            
        }
    }); 
});
</script>