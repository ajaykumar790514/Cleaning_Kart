
<div id="result">

</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($user_role_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<div id="grid_table">
    <table class="jsgrid-table" id="tab1">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center cat_table_heading">Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Description</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Menus & Permissions</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
        <?php $i=$page; foreach($user_role_data as $value){  ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>                                
                <th class="jsgrid-cell jsgrid-align-center"><?= $value->name; ?></th>                                
                <td class="jsgrid-cell jsgrid-align-left">
                    <?php $desc = strip_tags( $value->description);
                    $desc = substr($desc,0,15);
                    echo $desc; ?>
                    <?php if(strlen($value->description) > 15){ ?>   
                        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $value->id; ?>">Read More</button>
                    <?php } ?>
    
                </td>                                                             
                <td class="jsgrid-cell jsgrid-align-center">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Menu Access - <?=$value->name?>" data-url="<?=$m_access_url?><?=$value->id?>" class="btn btn-primary btn-sm"> Manage </a>
                </td>                              
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <?php if($value->status==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                    <?php }?>
                </td>                              
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                        <?php if($value->id!== '1' && $value->id!== '2'){ ?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Admin Menu ( <?=$value->name?> )" data-url="<?=$update_url?><?=$value->id?>" >
                            <i class="fa fa-edit"></i>
                    </a>
                    <a href="javscript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$value->id?>" title="Delete"><i class="fa fa-trash"></i>
                    </a>
                    <?php } ?>
                </td>  
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
            </tr> 
        <?php } ?>
                                                  
    </table>

        
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($user_role_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('acl-data/change_user_role_status'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
        });
    }
    function delete_menu(menu_id){
        if(confirm('Do you want to delete?') == true)
        {
            $.ajax({
                url: "<?php echo base_url('acl-data/admin_menu/delete'); ?>",
                method: "POST",
                data: {
                    menu_id:menu_id
                },
                success:function(data){
                    $("#tb").html(data);
                }
            });
            // $('#tb').load("<?php echo base_url('ACL/admin_menu/delete/')?>"+menu_id );
            // toastr.success('Menu Deleted Successfully..')
        }
    };
</script>
