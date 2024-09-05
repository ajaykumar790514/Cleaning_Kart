<table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Image</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            <?php $i=1; foreach($available_products as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?= $i++; ?></th>
                <td class="jsgrid-cell jsgrid-align-center"><img src="<?php echo IMGS_URL.$value->img; ?>" alt="image" height="100"></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->product_code; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><input type='checkbox' value='1' class="checkbtn" id="btn<?= $value->id;?>" onclick="link_product(<?= $value->id;?>)"/>
                <label for="btn<?= $value->id;?>"></label></td>
                
          
            </tr> 
            <?php } ?>
        </table>

<script type="text/javascript">
    function link_product(pid)
    {
        var bannerid = $('#bannerid').val();
    $.ajax({
        url: "<?php echo base_url('shop-master-data/link_product'); ?>",
        method: "POST",
        data: {
            pid:pid,
            bannerid:bannerid
        },
        success: function(data){
            $(".checkbtn").prop("checked", false);
            $(".checkbtn").prop("disabled", false);
            toastr.success('Product Linked Successfully..');
            $("#btn"+pid).prop("disabled", true);
            $("#btn"+pid).prop("checked", true);
        },
    });
    }
</script>