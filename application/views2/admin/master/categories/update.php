<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            userName:"required",
            role_id:"required",                                          
            contact: {
                required:true,
                minlength:10,
                maxlength:10,
                number: true,
            },
        },
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= "multipart/form-data">

<div class="row">
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Parent Category:</label>
                <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_sub_categories(this.value)">
                <option value="">--Select--</option>
                <?php foreach ($parent_cat as $parent) { ?>
                <option value="<?php echo $parent->id; ?>" <?php if($parent->id == $value->is_parent){echo "selected";}else if($parent->id == $value->subcat_is_parent){echo "selected";} ?>>
                    <?php echo $parent->name; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Sub Categories:</label>
                <select class="form-control sub_cat_id" style="width:100%;" name="sub_cat_id" id="sub_cat_id">
                    <option value="<?php echo $value->subcat_id; ?>">
                        <?php echo $value->subcat_name; ?>
                    </option>                   
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="recipient-name" class="control-label">Category Name:</label>
                <input type="text" name="name" class="form-control" value="<?php echo $value->name;?>">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Tax Slab:</label>
                <select class="form-control select2" style="width:100%;" name="tax_id">
                <option value="">Select Tax Slab</option>
                <?php foreach ($tax_slabs as $slab) { ?>
                <option value="<?php echo $slab->id; ?>,<?php echo $slab->slab; ?>" <?php if($slab->id == $value->tax_id){echo "selected";} ?>>
                    <?php echo $slab->slab; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Sequence:</label>
                <input type="number" class="form-control" name="seq" value="<?php echo $value->seq; ?>" required>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Image</label>
                <input type="file" name="icon" class="form-control">
            </div>
            <?php if(!empty($value->thumbnail)) { ?>
                <img src="<?php echo IMGS_URL.$value->thumbnail;?>" alt="<?php echo $value->name; ?>" height="50">
            <?php } ?> 
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea class="form-control" name="description" rows="4" cols="50"><?php echo $value->description; ?></textarea>
            </div>
        </div>
            
    </div>



<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <!-- <input type="submit" class="btn btn-primary waves-light" type="submit" value="UPDATE"> -->
    <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Update</button>

</div>

</form>
<script type="text/javascript">
   function fetch_category(parent_id)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_category'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id
        },
        success: function(data){
            $(".parent_cat_id").html(data);
        },
    });
   };
   function fetch_sub_categories(parent_id)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_sub_categories'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id
        },
        success: function(data){
            $(".sub_cat_id").html(data);
        },
    });
   }
</script>