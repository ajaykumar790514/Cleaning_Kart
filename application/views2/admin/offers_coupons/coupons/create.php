<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {   
            title:"required",
            description:"required",
            discount_type:"required",
            value:"required",
            expiry_date:"required",
            start_date:"required",
            business_id:"required",
            offer_created_by:"required",
            // minimum_coupan_amount: { lessThan: "#max" },
            // minimum_coupan_amount:"required",
            maximum_coupan_discount_value:"required",
            code:{
                required:true,
                remote:"<?=$remote?>null/code"
            }
            // expiry_date: { greaterThan: "#start_date" }
        },
        messages: {
            code: {
                required : "Please Enter Coupon Code.",
                remote : "Code already exists!"
            }
        }
    }); 

});
</script>

<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
    
        <div class="row">
        
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Coupon Code</label>
                    <input type="text" class="form-control" name="code">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Title</label>
                    <input type="text" class="form-control" name="title">
                </div>
            </div>
            
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Discount Type:</label>
                    <select class="form-control" style="width:100%;" name="discount_type">
                        <option value="">--Select--</option>
                        <option value="0">Fixed</option>
                        <option value="1">Percentage</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Value:</label>
                    <input type="number" class="form-control" name="value">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Image:</label>
                    <input type="file" name="photo" class="form-control"
size="55550" accept=".png, .jpg, .jpeg, .gif" >
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Start Date:</label>
                    <input type="date" min="<?= date('Y-m-d'); ?>" name="start_date" id="start_date" class="form-control" onchange="validate_date()">
                    <div id="msg"></div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Expiry Date:</label>
                    <input type="date" min="<?= date('Y-m-d'); ?>" name="expiry_date" id="expiry_date" class="form-control" onchange="validate_date()">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Minimum Coupon Amount:</label>
                    <input type="number" name="minimum_coupan_amount" id="min" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Maximum Coupon Amount:</label>
                    <input type="number" name="maximum_coupan_discount_value" id="max" class="form-control">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Business:</label>
                    <select class="form-control" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
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
                    <select class="form-control shop_id" style="width:100%;" name="offer_created_by" id="shop_id">
                    
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Description:</label>
                    <textarea cols="92" rows="5" class="form-control" name="description"></textarea>
                </div>
            </div>
            
            
        </div>

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" />
</div>

</form>

<script type="text/javascript">
   function fetch_shop(business_id)
   {
    $.ajax({
        url: "<?php echo base_url('offers-coupons/fetch_shop'); ?>",
        method: "POST",
        data: {
            business_id:business_id
        },
        success: function(data){
            $(".shop_id").html(data);
        },
    });
   }
</script>
<script>
    var from = $("#start_date").val();
var to = $("#expiry_date").val();
// alert(from);
if(Date.parse(from) > Date.parse(to)){
   alert("Invalid Date Range");
}
</script>

 