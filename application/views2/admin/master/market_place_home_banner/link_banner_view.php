<div class="row">
    <div class="col-4">
        <div class="form-group">
            <label class="control-label">State:</label>
            <select class="form-control select2" style="width:100%;" name="state" id="state" onchange="fetch_city(this.value)">
            <option value="">Select State</option>
            <?php foreach ($states as $state) { ?>
            <option value="<?php echo $state->id; ?>">
                <?php echo $state->name; ?>
            </option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="control-label">City:</label>
        <select class="form-control select2 city" style="width:100%;" name="city" id="city" onchange="fetch_business(this.value)"> 

        </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label class="control-label">Business:</label>
        <select class="form-control select2 business" style="width:100%;" name="business" id="business" onchange="fetch_shop(this.value)"> 

        </select>
        </div>
    </div>
    <input type="hidden" value="<?= $banner_id; ?>" id="bannerid">
</div>
<div class="row" id="content">
        <?php if(!empty($banners->link_id)) { ?>
            <p class="ml-3" style="color:blue">This Banner is linked with <strong><?php echo 'Shop '.$linked_item->shop_name; ?></strong></p>
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
<script type="text/javascript">
   function fetch_city(state)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_city'); ?>",
        method: "POST",
        data: {
            state:state
        },
        success: function(data){
            $(".city").html(data);
        },
    });
   };
   function fetch_business(cityid)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_business'); ?>",
        method: "POST",
        data: {
            cityid:cityid
        },
        success: function(data){
            $(".business").html(data);
        },
    });
   };
   function fetch_shop(business_id)
    {
        var bannerid = $('#bannerid').val(); 
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_shops'); ?>",
        method: "POST",
        data: {
            business_id:business_id,
            bannerid:bannerid
        },
        success: function(data){
            $('#content').hide();
            $("#table_view").html(data);
        },
    });
    }
</script>