<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {   
            title:"required",
            owner_name:"required",
            owner_contact:{
                required:true,
                minlength:10,
                maxlength:10,
                number: true
            },
            alter_contact:{
                minlength:10,
                maxlength:10,
                number: true
            },
            email:{
                email:true
            },
            owner_contact:"required",
            city:"required",
            state:"required",
            address:"required",
            
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation update-form reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
        <div class="row">
        <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Image:</label>
                    <input type="file" name="pic" class="form-control"
size="55550" accept=".png, .jpg, .jpeg, .gif" >
                </div>
                <?php if(!empty($value->pic)) { ?>
                <img src="<?php echo IMGS_URL.$value->pic;?>" alt="<?php echo $value->owner_name; ?>" height="50">
                <?php } ?>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $value->title; ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Owner Name:</label>
                    <input type="text" class="form-control" name="owner_name" value="<?php echo $value->owner_name; ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Contact Number:</label>
                    <input type="number" class="form-control" name="owner_contact" value="<?php echo $value->owner_contact; ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Alternate Contact Number:</label>
                    <input type="text" class="form-control" name="alter_contact" value="<?php echo $value->alter_contact; ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Email Id:</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $value->email; ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">DOB:</label>
                    <input type="date" name="dob" class="form-control" value="<?php echo $value->dob; ?>">
                </div>
            </div>
            <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">State:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="state" id="state" onchange="fetch_city(this.value)">
                                                                            <option value="">Select State</option>
                                                                            <?php foreach ($states as $state) { ?>
                                                                            <option value="<?php echo $state->id; ?>" <?php if($state->id == $value->state){echo "selected";} ?>>
                                                                                <?php echo $state->name; ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">City:</label>
                                                                        <select class="form-control select2 city" style="width:100%;" name="city" id="city">
                                                                        <option value="<?php echo $value->city; ?>">
                                                                    <?php echo $value->city_name; ?>
                                                                    </option>
                                                                        </select>
                                                                    </div>
                                                                    </div>
                                                                    <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Address:</label>
                    <textarea cols="92" rows="5" class="form-control" name="address"><?php echo $value->address; ?></textarea>
                </div>
            </div>
        </div>

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>
<script type="text/javascript">
   function fetch_category(parent_id)
   {
    //    alert(business_id);
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
   }
</script>