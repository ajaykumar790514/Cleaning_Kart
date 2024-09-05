<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            parent_id:"required",
            parent_cat_id:"required",
            unit_value:"required",
            unit_type:"required",
            description:"required",                                   
            unit_type_id:"required",                                     
            name:"required",                                     
            product_code:"required",
            tax_id:"required",                                                       
            expiry_date:"required",                                                                                          mfg_date:"required", 
        },
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>

<div class="modal-body">
    
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Title:</label>
                <input type="text" class="form-control" name="title" value="<?= $value->title; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="recipient-name" class="control-label">Photo</label>
                <input type="file" class="form-control" name="photo">
            </div>
            <?php if(!empty($value->photo)) { ?>
                    <img src="<?php echo IMGS_URL.$value->photo;?>" alt="news photo" height="50">
                <?php } ?> 
        </div>
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Priority:</label>
                    <select class="form-control select2" style="width:100%;" name="priority">
                        <option value="">--Select--</option>
                        <option value="0.3" <?php if($value->priority == '0.3'){echo "selected";} ?>>Low</option>
                        <option value="0.7"  <?php if($value->priority == '0.7'){echo "selected";} ?>>Medium</option>
                        <option value="1.0"  <?php if($value->priority == '1.0'){echo "selected";} ?>>High</option>
                    
                    </select>
                </div>
            </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Meta Keyword:</label>
                <input type="text" class="form-control" name="meta_keyword" value="<?= $value->meta_keyword; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Meta Description:</label>
                <input type="text" class="form-control" name="meta_description" value="<?= $value->meta_description; ?>">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea id="textarea1" cols="92" rows="5" class="form-control" name="description"><?= $value->description; ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>