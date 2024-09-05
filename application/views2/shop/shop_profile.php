                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->

                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Shop Profile</li>
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
                                                <h3 class="card-title" id="test">Shop Profile</h3>
                                                <h6 class="card-subtitle"></h6>
                                                
                                            </div>
                                            <div class="float-right col-md-10 col-lg-10 col-sm-12">
                                                <button class="mb-3 btn btn-primary" data-toggle="modal" data-target="#edit-shop-profile" >Edit Profile</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Shop name</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $shop_data->shop_name; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Open Time</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $shop_data->open_time; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Close Time</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $shop_data->close_time; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Delivery</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php if($shop_data->isDelivery=='1'){echo "Yes";} else{echo "No";} ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">COD</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php if($shop_data->is_cod=='1'){echo "Yes";} else{echo "No";} ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Shop Open/Close</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php if($shop_data->is_live=='1'){echo "Open";} else{echo "Close";} ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Online Payment</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php if($shop_data->is_online_payments=='1'){echo "Yes";} else{echo "No";} ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Security</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php if($shop_data->is_security=='1'){echo "Yes";} else{echo "No";} ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Email</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $shop_data->email; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Slider Button Color</th>
                                                    <td class="jsgrid-cell jsgrid-align-center" style="color:<?= $shop_data->slider_buttons; ?>"><?php echo $shop_data->slider_buttons; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Ecommerce</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php if($shop_data->is_ecommerce=='1'){echo "Yes";} else{echo "No";} ?></td>
                                                </tr>
                                             
                                                </table>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Iphone URL</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $shop_data->iphone_url; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Android URL</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $shop_data->android_url; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Logo</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><img src="<?php echo IMGS_URL.$shop_data->logo; ?>" alt="profile" height="100" width="100"></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Cover Photo</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><img src="<?php echo IMGS_URL.$shop_data->image; ?>" alt="profile" height="100" width="100"></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Album</th>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Shop Images ( <?=$shop_data->shop_name?> )" data-url="<?=$shop_img_url?><?=$shop_id?>" ><i class="fa fa-image"></i></a>
                                                    </td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Contact</th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $shop_data->contact; ?></td>
                                                </tr>
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Analytics Code</th>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <?php $code = strip_tags( $shop_data->analytics_code);
                                                        $code = substr($code,0,15);
                                                        echo $code; ?>
                                                        <?php if(strlen($shop_data->analytics_code) > 15){ ?> 
                                                        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-code<?php echo $shop_data->id; ?>">Read More</button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                <!--Read Analytics code modal-->
                                                    <div id="read-code<?php echo $shop_data->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b>Analytics Code</b>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo $shop_data->analytics_code; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!--/Read Analytics code modal-->
                                                <!--Shop Images modal-->
                                                    <div class="modal fade text-left" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="myModalLabel21">......</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    </div>
                                                <!--/Shop Images modal-->
                                                <div id="edit-shop-profile" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Profile</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('edit-shop-profile'); ?>" method="post" enctype= "multipart/form-data">
                                                                    <div class="row">
                                                                    <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Open Time</label>
                                                                                <input type="time" class="form-control" name="open_time" value="<?php echo $shop_data->open_time;?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Close Time</label>
                                                                                <input type="time" class="form-control" name="close_time" value="<?php echo $shop_data->close_time;?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">COD Limit</label>
                                                                                <input type="text" class="form-control" name="cod_limit" value="<?php echo $shop_data->cod_limit;?>" required>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Email</label>
                                                                                <input type="email" class="form-control" name="email" value="<?php echo $shop_data->email;?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Logo</label>
                                                                                <input type="file" class="form-control" name="logo">
                                                                                <img src="<?php echo IMGS_URL.$shop_data->logo; ?>" alt="profile" height="50">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="form-group">
                                                                            <input type='checkbox' name='is_cod' id="is_cod" <?php if($shop_data->is_cod == '1' ){echo "checked";} ?>/>
                                                                            <label for="is_cod">COD</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                            <input type='checkbox' name='is_live' id="is_live" <?php if($shop_data->is_live == '1' ){echo "checked";} ?>/>
                                                                            <label for="is_live">Open/Close</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="form-group">
                                                                            <input type='checkbox' name='isDelivery' id="isDelivery" <?php if($shop_data->isDelivery == '1' ){echo "checked";} ?>/>
                                                                            <label for="isDelivery">isDelivery</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                            <input type='checkbox' name='is_online_payments' value='1' id="is_online_payments" <?php if($shop_data->is_online_payments == '1' ){echo "checked";} ?> />
                                                                            <label for="is_online_payments">Online Payment</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-2">
                                                                            <div class="form-group">
                                                                            <input type='checkbox' name='is_security' value='1' id="is_security" <?php if($shop_data->is_security == '1' ){echo "checked";} ?>/>
                                                                            <label for="is_security">Security</label>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="col-12 mb-2">
                                                                            <h4>Layout Details</h4>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Slider button color</label>
                                                                                <input type="color" class="form-control" name="slider_buttons" value="<?php echo $shop_data->slider_buttons;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Iphone URL</label>
                                                                                <input type="text" class="form-control" name="iphone_url" value="<?php echo $shop_data->iphone_url;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Android URL</label>
                                                                                <input type="text" class="form-control" name="android_url" value="<?php echo $shop_data->android_url;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-3">
                                                                            <div class="form-group">
                                                                            <input type='checkbox' name='is_ecommerce' id="is_ecommerce" <?php if($shop_data->is_ecommerce == '1' ){echo "checked";} ?>/>
                                                                            <label for="is_ecommerce">Ecommerce</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Analytics Code</label>
                                                                                <textarea cols="92" rows="5" class="form-control" name="analytics_code"><?php echo $shop_data->analytics_code;?></textarea>
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
<script>
  $('#showModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    var data_url  = button.data('url') 
    var modal = $(this)
    $('#showModal .modal-title').text(recipient)
    $('#showModal .modal-body').load(data_url);
})

</script>