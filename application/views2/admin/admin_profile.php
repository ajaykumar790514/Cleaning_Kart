                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-wrapper">
                <div class="container-fluid" style="max-width: 100% !important;">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Admin Profile</li>
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
                                                <h3 class="card-title" id="test">Admin Profile</h3>
                                                <h6 class="card-subtitle"></h6>
                                                
                                            </div>
                                            <div class="float-right col-md-10 col-lg-10 col-sm-12">
                                                <button class="mb-3 btn btn-primary" data-toggle="modal" data-target="#edit-admin-profile" >Edit Profile</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Username</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $admin_data->userName; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Fullname</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $admin_data->fullName; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Photo</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><img src="<?php echo IMGS_URL.$admin_data->photo; ?>" alt="profile" height="100"></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Contact</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $admin_data->contact; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Email</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $admin_data->email; ?></td>
                                                </tr>
                                                
                                                <div id="edit-admin-profile" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Profile</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('edit-admin-profile/'.$admin_data->id); ?>" method="post" enctype= multipart/form-data>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">User Name</label>
                                                                                <input type="text" class="form-control" name="userName" value="<?php echo $admin_data->userName;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Full Name</label>
                                                                                <input type="text" class="form-control" name="fullname" value="<?php echo $admin_data->fullName;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Contact</label>
                                                                                <input type="text" class="form-control" name="contact" value="<?php echo $admin_data->contact;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Email</label>
                                                                                <input type="email" class="form-control" name="email" value="<?php echo $admin_data->email;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Profile Picture</label>
                                                                                <input type="file" class="form-control" name="photo">
                                                                                <img src="<?php echo IMGS_URL.$admin_data->photo; ?>" alt="profile" height="50">
                                                                            </div>
                                                                        </div>
                                                                       
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="UPDATE">
                                                            </div>
                                                                </form>
                                                        </div>
                                                    </div>
                                                </div> 
                                                </table>
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
