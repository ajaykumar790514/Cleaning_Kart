<input type="hidden" value="<?= $banner_id; ?>" id="bannerid">
<div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Title</th>
                <!-- <th class="jsgrid-header-cell jsgrid-align-center">Type</th> -->
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            <?php $i=1; foreach($home_header as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?= $i++; ?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->title ?></td>
                <!-- <td class="jsgrid-cell jsgrid-align-center"><input type='checkbox' id="btn<?= $value->id;?>" onclick="link_header(<?= $value->id;?>)"></td> -->
                <td class="jsgrid-cell jsgrid-align-center"><input type='checkbox' value='1' class="checkbtn" id="btn<?= $value->id;?>" onclick="link_header(<?= $value->id;?>)"/>
                <label for="btn<?= $value->id;?>"></label></td>
                
            </tr> 
            <?php } ?>
        </table>

</div>
<script type="text/javascript">
    function link_header(hid)
    {
        var bannerid = $('#bannerid').val();
    $.ajax({
        url: "<?php echo base_url('master-data/link_header'); ?>",
        method: "POST",
        data: {
            hid:hid,
            bannerid:bannerid
        },
        success: function(data){
            $(".checkbtn").prop("checked", false);
            $(".checkbtn").prop("disabled", false);
            toastr.success('Header Linked Successfully..');
            $("#btn"+hid).prop("disabled", true);
            $("#btn"+hid).prop("checked", true);
        },
    });
    }
</script>