<table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Shop Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            <?php $i=1; foreach($shops as $value){ ?>
                <?php foreach($mapped_data as $mapping) 
                    {
                        if($mapping->shop_id == $value->id)
                        {
                            $flg=1;   
                        }
                    }
                ?>
                
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?= $i++; ?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->shop_name; ?></td>
                
                <td class="jsgrid-cell jsgrid-align-center" id="changeaction<?= $value->id ?>">
                    <?php if($flg==1){?> 
                        <input type='checkbox' value='1' class="checkbtn" id="btn<?= $value->id;?>" onclick="remove_linked_shop(<?= $value->id;?>)" checked>
                        <label for="btn<?= $value->id;?>"></label>
                    <?php } else { ?>
                        <input type='checkbox' value='1' class="checkbtn" id="btn<?= $value->id;?>" onclick="link_shop(<?= $value->id;?>)">
                    <label for="btn<?= $value->id;?>"></label>
                <?php } ?>
                </td>
          
            </tr> 
            <?php $flg=0;}?>
        </table>

<script type="text/javascript">
    function link_shop(shop_id)
    {
        if($("#is_inside"+shop_id).prop("checked") == true)
        {
            $is_inside = 1;
        }
        else
        {
            $is_inside = 0;
        }
        var is_inside = $is_inside;
        var society_id = $('#society_id').val();
    $.ajax({
        url: "<?php echo base_url('master-data/link_society_shop'); ?>",
        method: "POST",
        data: {
            shop_id:shop_id,
            society_id:society_id,
            is_inside:is_inside,
        },
        success: function(data){
            $("#changeaction"+shop_id).html(data);
            toastr.success('Shop Linked Successfully..');
        },
    });
    };
    function remove_linked_shop(shop_id)
    {
        if(confirm('Are you sure?') == true)
        {
            var society_id = $('#society_id').val();
            $.ajax({
                url: "<?php echo base_url('master-data/remove_linked_shop'); ?>",
                method: "POST",
                data: {
                    shop_id:shop_id,
                    society_id:society_id,
                },
                success: function(data){
                    toastr.success('Shop Unlinked Successfully..');
                    $("#changeaction"+shop_id).html(data);
                },
            });
        }
    }
</script>