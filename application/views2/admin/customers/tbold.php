<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($customers)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
            <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?=$search?>" placeholder="Search...">
        </div>
        <div class="col-md-8 text-right" style="float: left;">
            <?=$links?>
        </div>
    </div>
</div>

<div id="grid_table">
    <table class="jsgrid-table">
        <tr class="jsgrid-header-row">
            <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
            <th class="jsgrid-header-cell jsgrid-align-center">Customer Name</th>
            <th class="jsgrid-header-cell jsgrid-align-center">Gender</th>
            <th class="jsgrid-header-cell jsgrid-align-center">Mobile</th>
            <th class="jsgrid-header-cell jsgrid-align-center">Email</th>
            <th class="jsgrid-header-cell jsgrid-align-center">Address</th>
            <th class="jsgrid-header-cell jsgrid-align-center">Photo</th>
            <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
        </tr>
        
        <?php $i=$page; foreach($customers as $value){ ?>
        <tr class="jsgrid-filter-row">
            <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
            <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->fname .' '.$value->lname;?></td>
            <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->gender;?></td>
            <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->mobile;?></td>
            <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->email;?></td>
            <td class="jsgrid-cell jsgrid-align-center">
            <a  data-toggle="modal" href="#" data-target="#view-address<?php echo $value->id; ?>" ><i class="fa fa-address-card"></i></a>
            </td>
            <td class="jsgrid-cell jsgrid-align-center">
                <?php if(!empty($value->photo)) { ?>
                    <img src="<?php echo IMGS_URL.$value->photo; ?>" alt="profile" height="50">
                <?php } else {?>
                    <img src="<?php echo IMGS_URL.'application/photo/avatar.png'; ?>" alt="cover" height="50">
                    <?php } ?>
            </td>
            <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->isActive==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
        </tr> 
         <!--Add property modal-->
         <div id="view-address<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Addresses</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <?php foreach($address as $addr){ if($value->mobile == $addr->customer_id) { ?>
                                                                        <div class="col-12"><h4><?= $addr->address; ?></h4></div>
                                                                   <?php } }?>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <!--/Add property modal-->
        <?php } ?>    
    </table>

        
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($customers)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('customers/change_cust_status'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
    });
    }
</script>
