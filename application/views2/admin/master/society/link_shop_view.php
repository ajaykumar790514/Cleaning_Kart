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
    <input type="hidden" value="<?= $society_id; ?>" id="society_id">
</div>


<div id="table_view">

     
    </div>
<!--Available shops table view-->
<div class="col-12" id="available_shops">
        <?php if(!empty($shops)) { ?>  
            <table class="table table-striped base-style" style="border:1px solid black">
                <thead >
                    <tr >
                        <th class="text-center">Business</th>
                        <th class="text-center">Shop</th>
                        <!-- <th class="text-center">Inside</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($shops as $shop) {?>
                        <tr>
                            <td class="text-center"><?= $shop->title;?></td>
                            <td class="text-center"><?= $shop->shop_name;?></td>
                            <!-- <td class="text-center" id="changeaction<?= $shop->id ?>">
                                <?php if($flg==1){?> 
                                    <input type='checkbox' value='1' class="checkbtn" id="btn<?= $shop->id;?>" onclick="remove_inside(<?= $value->id;?>)" checked>
                                    <label for="btn<?= $shop->id;?>"></label>
                                <?php } else { ?>
                                    <input type='checkbox' value='1' class="checkbtn" id="btn<?= $shop->id;?>" onclick="add_inside(<?= $value->id;?>)">
                                <label for="btn<?= $shop->id;?>"></label>
                            <?php } ?>
                            </td> -->
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?> 
            <h4 class="text-center">No Record Found</h4>
        <?php } ?>
    </div>
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
        var society_id = $('#society_id').val(); 
        $.ajax({
            url: "<?php echo base_url('master-data/fetch_society_shops'); ?>",
            method: "POST",
            data: {
                business_id:business_id,
                society_id:society_id
            },
            success: function(data){
                $('#available_shops').hide();
                $("#table_view").html(data);
            },
        });
    }
</script>