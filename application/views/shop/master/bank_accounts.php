<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data'); ?>">Master</a></li>
            <li class="breadcrumb-item active">Shop Bank Accounts</li>
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
                                <h3 class="card-title" id="test">Shop Bank Accounts</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>
                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                <div id="add-shop-social" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b>Add Account</b>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="needs-validation" action="<?php echo base_url('shop-master-data/add_bank_accounts'); ?>" method="post">
                                                <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Account No.</label>
                                                                <input type="number" name="account_no" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">IFSC</label>
                                                                <input type="text" name="ifsc" class="form-control" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Name</label>
                                                                <input type="text" name="bank_name" class="form-control"  required>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Branch Name</label>
                                                                <input type="text" name="branch_name" class="form-control"  required>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="control-label">Opening</label>
                                                        </div>



                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Dr./Cr.:</label>
                                                                <select class="form-control" name="dr_cr">
                                                                    <option value="">-- Select --</option>
                                                                    <option value="cr">Credit</option>
                                                                    <option value="dr">Debit</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Amount:</label>
                                                                <input type="number" class="form-control" name="amount">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Remark:</label>
                                                                <input type="text" class="form-control" name="remark">
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
                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-shop-social" >Add Account</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="grid_table">
                            <table class="jsgrid-table">
                                <tr class="jsgrid-header-row">
                                   
                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center">account_no</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center">ifsc</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center">bank_name</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center"> branch_name</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                </tr>
                                <?php $i=1; foreach($rows as $value){ ?>
                                <tr class="jsgrid-filter-row">
                                   
                                    <td class="jsgrid-cell jsgrid-align-center"><?=$i++?></td>
                                    <td class="jsgrid-cell jsgrid-align-center"><?=$value->account_no?></td>
                                    <td class="jsgrid-cell jsgrid-align-center"><?=$value->ifsc?></td>
                                    <td class="jsgrid-cell jsgrid-align-center"><?=$value->bank_name?></td>
                                    <td class="jsgrid-cell jsgrid-align-center"><?=$value->branch_name?></td>
                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                        <?php if($value->active==1) { ?>
                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                    <?php } else {?>
                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                        <?php }?>
                                    </td>
                                    <td class="jsgrid-cell jsgrid-align-center">
                                    <a  data-toggle="modal" href="#" data-target="#edit-shop-bank-accounts<?=$value->id?>" ><i class="fa fa-edit"></i></a>
                                       
                                    </td>
                                </tr> 
                                <div id="edit-shop-bank-accounts<?=$value->id?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b>Update Icon</b>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?=base_url('shop-master-data/edit_bank_accounts/'.$value->id)?>" method="post">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Account No.</label>
                                                                <input type="number" name="account_no" class="form-control" value="<?=$value->account_no?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">IFSC</label>
                                                                <input type="text" name="ifsc" class="form-control" value="<?=$value->ifsc?>" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Bank Name</label>
                                                                <input type="text" name="bank_name" class="form-control" value="<?=$value->bank_name?>" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Branch Name</label>
                                                                <input type="text" name="branch_name" class="form-control" value="<?=$value->branch_name?>" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="control-label">Opening</label>
                                                        </div>



                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Dr./Cr.:</label>
                                                                <select class="form-control" name="dr_cr">
                                                                    <option value="">-- Select --</option>
                                                                    <option value="cr" <?=($value->dr_cr=='cr') ? 'selected' : ''?> >Credit</option>
                                                                    <option value="dr" <?=($value->dr_cr=='dr') ? 'selected' : ''?> >Debit</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Amount:</label>
                                                                <input type="number" class="form-control" name="amount" value="<?=$value->amount?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Remark:</label>
                                                                <input type="text" class="form-control" name="remark" value="<?=$value->remark?>">
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
        url: "<?php echo base_url('shop-master-data/change_bank_accounts_status'); ?>",
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
        var table = 'shop_social';
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