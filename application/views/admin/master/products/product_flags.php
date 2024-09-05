<style>
.more {display: none;}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            business_id: { required : true },
            shop_id   : { required : true },
            // delivery_period   : { required : true }
        },
        messages: {
            business_id: { required : "Please select business!" },
            shop_id   : { required : "Please select shop!" },
            // delivery_period   : { required : "Please enter Delivery Period!" }
        }
    }); 
});
</script>

<form class="ajaxsubmit needs-validation" method="post" action="<?=$action_url?>">
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
    
    <div class="col-4">
        <div class="form-group">
        <input type='checkbox' name='is_cod' id="is_cod" <?php if(!empty($flags)) {if($flags->is_cod == '1' ){echo "checked";} } ?>>
        <label for="is_cod">COD</label>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <input type='checkbox' name='is_cancellation' id="is_cancellation" <?php if(!empty($flags)) {if($flags->is_cancellation == '1' ){echo "checked";} } ?>/>
        <label for="is_cancellation">Cancellation</label>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <input type='checkbox' name='is_featured' id="is_featured" <?php if(!empty($flags)) {if($flags->is_featured == '1' ){echo "checked";} } ?>/>
        <label for="is_featured">Featured</label>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="control-label">Delivery Period:</label>
            <input type="text" class="form-control" name="delivery_period" id="delivery_period" value="<?php if(!empty($flags)){echo $flags->delivery_period;}?>">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="control-label">Cancellation Period (In Days):</label>
            <input type="number" class="form-control" name="cancellation_period" id="cancellation_period" value="<?php if(!empty($flags)){echo $flags->cancellation_period;}?>">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="control-label">Cancellation Content:</label>
            <textarea id="cancellation_content" cols="92" rows="5" class="form-control" name="cancellation_content"></textarea>
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
                    url: "<?php echo base_url('master-data/products/check_flag_existence'); ?>",
                    method: "POST",
                    data: {
                        shop_id:shop_id,
                        pid:pid
                    },
                    dataType: "json",
                    success: function(response){
                        $.each(response.data, function(index,value){
                            $('#delivery_period').val(value.delivery_period);
                            $('#cancellation_period').val(value.cancellation_period);
                            $('#cancellation_content').val(value.cancellation_content);
                            if(value.is_cod == '1')
                            {
                                $("#is_cod").prop("checked",true);
                            }
                            if(value.is_cancellation == '1')
                            {
                                $("#is_cancellation").prop("checked",true);
                            }
                            if(value.is_featured == '1')
                            {
                                $("#is_featured").prop("checked",true);
                            }
                            $('#btnsubmit').val('Update');
                            $('#flag').val('1');
                        });
                    },
                });
    }
</script>
