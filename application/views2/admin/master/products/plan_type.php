<style>
.more {display: none;}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            business_id: { required : true },
            shop_id   : { required : true },
        },
        messages: {
            business_id: { required : "Please select business!" },
            shop_id   : { required : "Please select shop!" },
        }
    }); 
});
</script>

<form class="ajaxsubmit needs-validation" method="post" action="<?=$action_url?>">
<!-- <?php print_r($shops); ?> -->
    <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label class="control-label">Business:</label>
            <select class="form-control select2" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
            <option value="">Select Business</option>
            <?php foreach ($business as $busi) { ?>
            <option value="<?php echo $busi->id; ?>">
                <?php echo $busi->title; ?>(<?php echo $busi->owner_name; ?>)
            </option>
            <?php } ?>
            </select>
        </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Shop:</label>
                <select class="form-control shop_id" style="width:100%;" name="shop_id" id="shop_id" onchange="check_existence(this.value);">
                
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Plan type:</label>
                <select class="form-control plan_type select2" style="width:100%;" name="plan_id[]" id="plan_id" multiple data-selected-text-format="count>2" required>
                <?php foreach ($plan_types as $plan) { ?>
                <option value="<?php echo $plan->id; ?>">
                    <?php echo $plan->plan; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
    
    <div class="col-12">
        <div class="form-group">
            <input type="hidden" class="form-control" name="pid" id="pid" value="<?= $pid; ?>">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <input type="hidden" class="form-control" name="flag" id="flag" value="0">
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <input id="btnsubmit" type="submit" class="btn btn-danger waves-light" value="Add"><i id="loader" class=""></i>

    </div>
    </div>
</form>

<script>
    function check_existence(shop_id){
        var pid = $('#pid').val();
                $.ajax({
                    url: "<?php echo base_url('master-data/products/check_plan_type_existence'); ?>",
                    method: "POST",
                    data: {
                        shop_id:shop_id,
                        pid:pid
                    },
                    dataType: "json",
                    success: function(response){
                        var checkbox_value = [];
                            $.each(response.data2, function(index2,value2){
                                checkbox_value.push(value2.plan_type_id);
                        });
                        $.each(response.data, function(index,value){
                            if(checkbox_value.includes(value.plan_id))
                            {
                                $('#plan_id option[value=' + value.plan_id + ']').attr('selected', true);
                            }
                            $('#btnsubmit').val('Update');
                            $('#flag').val('1');
                        });
                    },
                });
    }
</script>
<script>
    $(document).ready(function(){
        $('.plan_type').selectpicker();
    })
</script>
