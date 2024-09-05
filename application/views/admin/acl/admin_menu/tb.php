<!-- <input type="text" id="tb-search" placeholder="enter product name"> -->

<div id="result">

</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($menu_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<div id="grid_table">
    <table class="jsgrid-table" id="tab1">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center cat_table_heading">Title</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Indexing</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
        <?php $i=0; foreach($menu_data as $value){ if($value->parent=="0"){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>                                
                <th class="jsgrid-cell jsgrid-align-center"><?= $value->title; ?></th>                                
                <th class="jsgrid-cell jsgrid-align-center"><?= $value->indexing; ?></th>                                                              
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <?php if($value->status==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                    <?php }?>
                </td>                              
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Admin Menu ( <?=$value->title?> )" data-url="<?=$update_url?><?=$value->id?>" >
                            <i class="fa fa-edit"></i>
                    </a>

                    <a href="javscript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$value->id?>" title="Delete"><i class="fa fa-trash"></i>
                    </a>
                </td>                              
            </tr> 
            <?php foreach($menu_data as $value2){ if($value2->parent==$value->id){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"></th>                                
                <th class="jsgrid-cell jsgrid-align-center"><p class="text-xs"><i class="fas fa-arrow-right ml-5"></i><?= $value2->title; ?></p></th>                                
                <th class="jsgrid-cell jsgrid-align-center"><?= $value2->indexing; ?></th>                                                              
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value2->id; ?>">
                    <?php if($value2->status==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value2->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value2->id;?>)">Inactive</button>
                    <?php }?>
                </td>                              
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value2->id; ?>">
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Admin Menu ( <?=$value2->title?> )" data-url="<?=$update_url?><?=$value2->id?>" >
                            <i class="fa fa-edit"></i>
                    </a>

                    <a href="javscript:void(0)" onclick="_delete(this)" url="<?=$delete_url?><?=$value2->id?>" title="Delete"><i class="fa fa-trash"></i>
                    </a>
                </td>                              
            </tr> 
        <?php }}}} ?>
                                                  
    </table>

        
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($menu_data)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('acl-data/change_menu_status'); ?>",
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
