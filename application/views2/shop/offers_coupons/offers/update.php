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
            offer_created_by:"required"
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation update-form reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
<div class="row">
        
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?= $value->title; ?>">
            </div>
        </div>
        
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Discount Type:</label>
                <select class="form-control" style="width:100%;" name="discount_type">
                    <option value="">--Select--</option>
                    <option value="0" <?php if($value->discount_type == '0') {
                                                                            echo "selected";
                                                                        } ?>>Fixed</option>
                    <option value="1" <?php if($value->discount_type == '1') {
                                                                            echo "selected";
                                                                        } ?>>Percentage</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Value:</label>
                <input type="number" class="form-control" name="value" value="<?= $value->value; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Image:</label>
                <input type="file" name="photo" class="form-control"
size="55550" accept=".png, .jpg, .jpeg, .gif" >
            </div>
            <?php if(!empty($value->photo)) { ?>
                <img src="<?php echo IMGS_URL.$value->photo;?>" alt="<?php echo $value->title; ?>" height="50">
                <?php } ?>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control" min="<?= date('Y-m-d'); ?>" value="<?= $value->start_date; ?>" onchange="validate_date()">
                <div id="msg"></div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Expiry Date:</label>
                <input type="date" name="expiry_date" id="expiry_date" class="form-control" min="<?= date('Y-m-d'); ?>" value="<?= $value->expiry_date; ?>" onchange="validate_date()">
            </div>
        </div>
                                                   
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea cols="92" rows="5" class="form-control" name="description"><?= $value->description; ?></textarea>
            </div>
        </div>
        
        
    </div>

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <input type="submit" class="btn btn-danger waves-light" type="submit" value="Update" />
</div>

</form>

