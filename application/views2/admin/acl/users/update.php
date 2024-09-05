<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            userName:"required",
            role_id:"required",                                          
            fullName:"required",                                          
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
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Username:</label>
                <input type="text" class="form-control" name="userName" value="<?= $value->userName; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Full Name:</label>
                <input type="text" class="form-control" name="fullName" value="<?= $value->fullName; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?= $value->email; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Mobile:</label>
                <input type="number" class="form-control" name="contact" value="<?= $value->contact; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">User Role:</label>
                <select class="form-control select2" style="width:100%;" name="role_id">
                <option value="">--Select--</option>
                <?php foreach ($user_roles as $roles) { ?>
                <option value="<?php echo $roles->id; ?>" <?php if($roles->id == $value->role_id){echo "selected";} ?>>
                    <?php echo $roles->name; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Photo:</label>
                <input type="file" class="form-control" name="photo">
            </div>
            <?php if(!empty($value->photo)) { ?>
                <img src="<?php echo IMGS_URL.$value->photo;?>" alt="<?php echo $value->userName; ?>" height="50">
            <?php } ?> 
        </div>
    </div>



<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
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