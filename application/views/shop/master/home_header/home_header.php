                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('shop-master-data'); ?>">Master</a></li>
                            <li class="breadcrumb-item active">Home Header</li>
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
                                                <h3 class="card-title" id="test">Home Header Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-home-header" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add New Home Header Entry</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('shop-master-data/add_home_header'); ?>" method="post">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Title</label>
                                                                            <input type="text" class="form-control" name="title">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Type:</label>
                                                                            <select class="form-control" style="width:100%;" name="type">
                                                                                <option value="">--Select--</option>
                                                                                <option value="1">Product header</option>
                                                                                <option value="2">Category header</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                   
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Sequence:</label>
                                                                            <input type="number" class="form-control" name="seq">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Color Code</label>
                                                                            <textarea name="colorcode" class="form-control" cols="30" rows="5"></textarea>
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
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-home-header" >Add Home Header</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete Selected</button></th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Title</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Type</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Shop name</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Sequence</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($home_header as $value){ ?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                                                        <label for="multiple_delete<?= $value->id; ?>"></label>
                                                    </td>
                                                    <th class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->title;?></td>
                                                    <th class="jsgrid-cell jsgrid-align-center">
                                                        <?php if($value->type==1) { ?>
                                                    <?php echo 'Product header';?>
                                                    <?php } else {?>
                                                        <?php echo 'Category header';?>
                                                        <?php }?>
                                                    </th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->shop_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->seq;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <a  data-toggle="modal" href="#" data-target="#edit-home-header<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('shop-master-data/delete_home_header/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                        <?php if($value->type==1) { ?>
                                                        <a href="<?php echo base_url('shop-master-data/product_headers_mapping/' . $value->id); ?>"><i class="fa fa-eye"></i></a>
                                                        <?php } else {?>
                                                            <a href="<?php echo base_url('shop-master-data/cat_headers_mapping/' . $value->id); ?>"><i class="fa fa-eye"></i></a>
                                                            <?php }?>
                                                    </td>
                                                </tr>
                                                
                                                <div id="edit-home-header<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Home Header</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('shop-master-data/edit_home_header/'.$value->id); ?>" method="post" required>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Title</label>
                                                                            <input type="text" class="form-control" name="title" value="<?php echo $value->title; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Type:</label>
                                                                            <select class="form-control" style="width:100%;" name="type" required>
                                                                                <option value="1" <?php if($value->type == '1') {
                                                                            echo "selected";
                                                                        } ?>>Product header</option>
                                                                                <option value="2" <?php if($value->type == '2') {
                                                                            echo "selected";
                                                                        } ?>>Category header</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                   
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Sequence:</label>
                                                                            <input type="number" class="form-control" name="seq" value="<?php echo $value->seq; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Color Code</label>
                                                                            <textarea name="colorcode" class="form-control" cols="30" rows="5"><?php echo $value->colorcode; ?></textarea>
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
            title:"required",
            type:"required",
            seq:"required"
        },
    }); 
});
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
        var table = 'home_headers';
            if(checkbox.length > 0)
            {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>shop-master-data/multiple_delete",
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


