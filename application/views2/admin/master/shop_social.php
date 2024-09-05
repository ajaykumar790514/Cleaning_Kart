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
                            <li class="breadcrumb-item active">Shop Social</li>
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
                                                <h3 class="card-title" id="test">Shop Social Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-shop-social" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Icon</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('master-data/add_shop_social'); ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Business:</label>
                                                                            <select class="form-control" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
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
                                                                            <select class="form-control shop_id" style="width:100%;" name="shop_id" id="shop_id" onchange="check_existence(this.value);">
                                                                            
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Icon</label>
                                                                                <input type="text" name="icon" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Url</label>
                                                                                <input type="text" name="url" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                       
                                                                    </div>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="CREATE">
                                                            </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-shop-social" >Add Icon</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete Selected</button></th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Icon</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Url</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Shop name</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($socials as $value){ ?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                                                        <label for="multiple_delete<?= $value->id; ?>"></label>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->icon;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->url;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->shop_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a  data-toggle="modal" href="#" data-target="#edit-shop-social<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('master-data/delete_shop_social/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr> 
                                                <div id="edit-shop-social<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Icon</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('master-data/edit_shop_social/'.$value->id); ?>" method="post">
                                                                    <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Business:</label>
                                                                            <select class="form-control" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
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
                                                                                <label class="control-label">Icon</label>
                                                                                <input type="text" name="icon" class="form-control" value="<?php echo $value->icon;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Url</label>
                                                                                <input type="text" name="url" class="form-control" value="<?php echo $value->url;?>" required>
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
                                                <?php } ?>
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
    $(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            icon:{
                required:true,
                remote:"<?=$remote?>null/icon"
            },
            url:"required",
            business_id:"required",
            shop_id:"required",
        },
        messages: {
            icon: {
                required : "Please enter icon.",
                remote : "Icon already exists!"
            }
        }
    }); 
});
</script>
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('master-data/change_social_status'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
    });
    }
    function fetch_shop(business_id)
   {
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
        var table = 'shop_social';
            if(checkbox.length > 0)
            {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>master-data/multiple_delete",
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