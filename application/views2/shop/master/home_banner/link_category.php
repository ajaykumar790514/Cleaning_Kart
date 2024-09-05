
<input type="hidden" value="<?= $banner_id; ?>" id="bannerid">
<div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            <?php $i=1; foreach($sub_categories as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?= $i++; ?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?php if($value->is_parent!='0')
                {
                    echo '<b>'.$value->cat_name.'</b>('. $value->parent_name.')';
                } ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><input type='checkbox' value='1' class="checkbtn" id="btn<?= $value->id;?>" onclick="link_category(<?= $value->id;?>)"/>
                <label for="btn<?= $value->id;?>"></label></td>
               
                
          
            </tr> 
            <?php } ?>
        </table>

            
    </div>

<script type="text/javascript">
    function link_category(cid)
    {
        var bannerid = $('#bannerid').val();
    $.ajax({
        url: "<?php echo base_url('shop-master-data/link_category'); ?>",
        method: "POST",
        data: {
            cid:cid,
            bannerid:bannerid
        },
        success: function(data){
            $(".checkbtn").prop("checked", false);
            $(".checkbtn").prop("disabled", false);
            toastr.success('Category Linked Successfully..');
            $("#btn"+cid).prop("disabled", true);
            $("#btn"+cid).prop("checked", true);
        },
    });
    }
</script>