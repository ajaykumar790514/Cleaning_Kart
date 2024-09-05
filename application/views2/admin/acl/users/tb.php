<div id="result">

</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($user_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<div id="grid_table">
    <table class="jsgrid-table" id="tab1">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Username</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Mobile</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Email</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Photo</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
        <?php $i=$page; foreach($user_data as $value){  ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>                                
                <th class="jsgrid-cell jsgrid-align-center"><?= $value->userName; ?></th>                                
                <th class="jsgrid-cell jsgrid-align-center"><?= $value->contact; ?></th>                                                              
                <th class="jsgrid-cell jsgrid-align-center"><?= $value->email; ?></th>    
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php if(!empty($value->photo)) { ?>
                        <img src="<?php echo IMGS_URL.$value->photo;?>" alt="<?php echo $value->fullName;?>" height="50" width="50">
                    <?php } ?> 
                </td>                                                          
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <?php if($value->status==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                    <?php }?>
                </td>                              
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Admin Menu ( <?=$value->userName?> )" data-url="<?=$update_url?><?=$value->id?>" >
                            <i class="fa fa-edit"></i>
                    </a>

                    <a href="javscript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$value->id?>" title="Delete"><i class="fa fa-trash"></i>
                    </a>
                </td>                              
            </tr> 
        <?php } ?>
                                                  
    </table>

        
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($user_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('acl-data/change_user_status'); ?>",
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
