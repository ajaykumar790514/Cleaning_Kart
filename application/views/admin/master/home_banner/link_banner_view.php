<div class="row">
        <div class="col-6 ">
            <div class="form-group">
            <label class="control-label">Link Type:</label>
            <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_items(this.value)">
            <option value="">Select</option>
            <option value="3">Home Header</option>
            <option value="2">Category</option>
            <option value="1">Product</option>
            
            </select>
            <input type="hidden" value="<?= $banner_id; ?>" id="bannerid">
            </div>
        </div>
</div>
<div class="row" id="content">
        <?php if(!empty($banners->link_id)) { 
            if($banners->link_type == '1')
            {
                $type = 'Product';
                $name = $linked_item->name;
            }
            else if($banners->link_type == '2')
            {
                $type = 'Category';
                $name = $linked_item->name;
            }
            else if($banners->link_type == '3')
            {
                $type = 'Header';
                $name = $linked_item->title;
            }
            ?>
            <p class="ml-3" style="color:blue">This Banner is linked with <strong><?php echo $type.' - '.$name; ?></strong></p>
            <?php } ?>
</div>

<div id="table_view">

     
    </div>

<script type="text/javascript">
   function fetch_items(link_id)
   {
    var bannerid = $('#bannerid').val(); 
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_items'); ?>",
        method: "POST",
        data: {
            link_id:link_id,
            bannerid:bannerid
        },
        success: function(data){
            $('#content').hide();
            $("#table_view").html(data);
        },
    });
   }
</script>