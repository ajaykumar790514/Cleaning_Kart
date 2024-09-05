<table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Shop Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            <?php $i=1; foreach($shops as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?= $i++; ?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->shop_name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><input type='checkbox' value='1' class="checkbtn" id="btn<?= $value->id;?>" onclick="link_shop(<?= $value->id;?>)"/>
                <label for="btn<?= $value->id;?>"></label></td>
                
          
            </tr> 
            <?php } ?>
        </table>

<script type="text/javascript">
    function link_shop(sid)
    {
        var bannerid = $('#bannerid').val();
    $.ajax({
        url: "<?php echo base_url('master-data/link_shop'); ?>",
        method: "POST",
        data: {
            sid:sid,
            bannerid:bannerid,
        },
        success: function(data){
            $(".checkbtn").prop("checked", false);
            $(".checkbtn").prop("disabled", false);
            toastr.success('Shop Linked Successfully..');
            $("#btn"+sid).prop("disabled", true);
            $("#btn"+sid).prop("checked", true);
        },
    });
    }
</script>