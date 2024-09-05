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
                            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data/'.$menu_id); ?>">Master Data</a></li>
                            <li class="breadcrumb-item active">Pincodes Criteria</li>
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
                                                <h3 class="card-title" id="test">Pincodes Criteria</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-pincode-criteria" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Pincode Criteria</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('master-data/add_pincodes_criteria'); ?>" method="post">
                                                                
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Business:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
                                                                            <option value="">Select Business</option>
                                                                            <?php foreach ($business as $busi) { ?>
                                                                            <option value="<?php echo $busi->id; ?>">
                                                                                <?php echo $busi->title; ?>(<?php echo $busi->owner_name; ?>)
                                                                            </option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Shop:</label>
                                                                            <select class="form-control shop_id" style="width:100%;" name="shop_id" id="shop_id">
                                                                            
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Pin Code:</label>
                                                                                <input type="number" class="form-control" name="pincode">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="control-label">Price</label>
                                                                                <input type="number" class="form-control" name="price">
                                                                            </div>
                                                                        </div>
                                                                       
                                                                    </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD">
                                                            </div>
                                                            
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-pincode-criteria" >Add Pincode Criteria</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete Selected</button></th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Pincode</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Shop</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Price</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; $n=0; foreach($pincodes_criteria as $value){
                                                    $ids[] = uniqid();
                                                    
                                                 ?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                                                        <label for="multiple_delete<?= $value->id; ?>"></label>
                                                    </td>
                                                    <th class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->pincode;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->shop_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">₹ <?php echo $value->price;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a  data-toggle="modal" href="#" data-target="#edit-pincode-criteria<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('master-data/delete_pincodes_criteria/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                        
                                                   
                                                    </td>
                                                </tr> 
                                                <div id="edit-pincode-criteria<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Pincode Criteria</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form clas="<?=$ids[$n]?>" action="<?php echo base_url('master-data/edit_pincodes_criteria/'.$value->id); ?>" method="post" >

                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Business:</label>
                                                                                <select class="form-control select2" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
                                                                                <option value="">Select Business</option>
                                                                                <?php foreach ($business as $busi) { ?>
                                                                                <option value="<?php echo $busi->id; ?>" <?php if($busi->id == $value->business_id) {
                                                                                    echo "selected";
                                                                                } ?>>
                                                                                    <?php echo $busi->title; ?>
                                                                                </option>
                                                                                <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Shop:</label>
                                                                                <select class="form-control shop_id" style="width:100%;" name="shop_id" id="shop_id">
                                                                                    <option value="<?php echo $value->shop_id; ?>">
                                                                                    <?php echo $value->shop_name; ?>
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Pin Code:</label>
                                                                                <input type="number" class="form-control" value="<?php echo $value->pincode; ?>" name="pincode">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="control-label">Price</label>
                                                                                <input type="number" class="form-control" name="price" value="<?php echo $value->price; ?>" >
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
                            
                                                <?php  $n++; } ?> 
                                                <div class="statusdata"></div>   
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


<script type="text/javascript">
   function fetch_shop(business_id)
   {
    //    alert(business_id);
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_shop'); ?>",
        method: "POST",
        data: {
            business_id:business_id
        },
        success: function(data){
            $(".shop_id").html(data);
        },
    });
   }
</script>

<script type="text/javascript">
    $(document).ready(function() {
      
    $(".needs-validation").validate({
        rules: {
            business_id:"required",
            shop_id:"required",
            price:"required",
            pincode:{
                required:true,
                remote:"<?=$remote?>null/pincode"
            }
        },
        messages: {
            business_id:"Please Select Business!",
            shop_id:"Please Select Shop!",
            price:"Please Enter Price!",
            pincode: {
                required : "Please enter pincode.",
                remote : "Pincode already exists!"
            }
        }
    }); 
});
</script>

<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('master-data/change_status'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
    });
    }
            //multiple delete
            $('.delete_checkbox').click(function(){
        if($(this).is(':checked'))
        {
            $(this).closest('tr').addClass('removeRow');
        }
        else
        {
            $(this).closest('tr').removeClass('removeRow');
        }
    });
   $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        var table = 'pincodes_criteria';
            if(checkbox.length > 0)
            {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>master-data/multiple_delete/",
                method:"POST",
                data:{checkbox_value:checkbox_value,table:table},
                success:function(data)
                {
                    $('.removeRow').fadeOut(1500);
                }
            })
            }
            else
            {
            alert('Select atleast one record');
            }
   })
</script>