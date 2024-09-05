<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            description:"required",
            icon:"required",
            name:{
                required:true,
                remote:"<?=$remote?>null"
            }
        },
        messages: {
            description:"Please Enter Description!",
            icon:"Please Select Image!",
            name: {
                required : "Please enter name.",
                remote : "Category already exists!"
            }
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Parent Category:</label>
                <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_sub_categories(this.value)">
                <option value="">--Select--</option>
                <?php foreach ($parent_cat as $parent) { ?>
                <option value="<?php echo $parent->id; ?>">
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
                                                
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Category Name:</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Tax Slab:</label>
                <select class="form-control select2" style="width:100%;" name="tax_id">
                <option value="">Select Tax Slab</option>
                <?php foreach ($tax_slabs as $value) { ?>
                <option value="<?php echo $value->id; ?>,<?php echo $value->slab; ?>">
                    <?php echo $value->slab; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Sequence:</label>
                <input type="number" class="form-control" name="seq">
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label for="recipient-name" class="control-label">Image</label>
                <input type="file" class="form-control" name="icon">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea class="form-control" name="description" rows="4" cols="50"></textarea>
            </div>
        </div>
            
        </div>
 
        

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" value="ADD" /> -->
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