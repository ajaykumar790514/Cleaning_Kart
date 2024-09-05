<input type="hidden" value="<?= $banner_id; ?>" id="bannerid">
<div class="row">
        <div class="col-6">
            <div class="form-group">
            <label class="control-label">Parent Categories:</label>
            <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_category(this.value)">
            <option value="">Select</option>
            <?php foreach ($parent_cat as $parent) { ?>
            <option value="<?php echo $parent->id; ?>" <?php if(!empty($parent_id)) { if($parent_id==$parent->id) {echo "selected"; } }?>>
                <?php echo $parent->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
            <label class="control-label">Categories:</label>
            <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_products(this.value)">
                                                  
            </select>
           
            </div>
        </div>
</div>

<div id="available_products">

     
    </div>

    <script type="text/javascript">
   function fetch_category(parent_id)
   {
    $.ajax({
        url: "<?php echo base_url('shop-master-data/fetch_category'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id
        },
        success: function(data){
            $(".parent_cat_id").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function fetch_products(parent_cat_id)
   {
    $.ajax({
        url: "<?php echo base_url('shop-master-data/get_products'); ?>",
        method: "POST",
        data: {
            parent_cat_id:parent_cat_id
        },
        success: function(data){
            $("#available_products").html(data);
        },
    });
   }
</script>