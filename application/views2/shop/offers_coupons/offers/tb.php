<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($offers)?> of <?=$total_rows?> entries</span>
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

<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Title</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Description</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Value</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Start date</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Expiry date</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Shop</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Photo</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
            
            <?php $i=$page; foreach($offers as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->title;?></td>
                <td class="jsgrid-cell jsgrid-align-left">
                                                        <?php $desc = strip_tags( $value->description);
        $desc = substr($desc,0,15);
        echo $desc; ?>
        <?php if(strlen($value->description) > 15){ ?> 
        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $value->id; ?>">Read More</button>
        <?php } ?>
        
                                                        </td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->value; if($value->discount_type == '1') {echo "%";} else{echo " ₹";} ?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo date('d-m-Y',strtotime($value->start_date));?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo date('d-m-Y',strtotime($value->expiry_date));?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->shop_name;?></td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php if(!empty($value->photo)) { ?>
                        <img src="<?php echo IMGS_URL.$value->photo; ?>" alt="offer_photo" height="50">
                    <?php } else {?>
                        <img src="<?php echo IMGS_URL.'application/photo/banner_default.png'; ?>" alt="offer_photo" height="50">
                        <?php } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                            <?php if($value->active==1) { ?>
                                                        <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                        <?php } else {?>
                                                            <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                            <?php }?>
                                                        </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Offer ( <?=$value->title?> )" data-url="<?=$update_url?><?=$value->id?>" >
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="javscript:void(0)" onclick="delete_offer(<?php echo $value->id;?>)"><i class="fa fa-trash"></i>
                    </a>

                </td>
            </tr> 
            <!--Read Description modal-->
            <div id="read-desc<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b>Description</b>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo $value->description; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        <!--/Read Description modal-->
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($offers)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script>
    function delete_offer(oid){
        if(confirm('Do you want to delete?') == true)
        {
            $('#tb').load("<?php echo base_url('shop-offers/delete_offer/')?>"+oid );
        }
    }
</script>
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('coupons-offers/change_offer_coupon_status'); ?>",
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
