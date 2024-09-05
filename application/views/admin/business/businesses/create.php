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
                number: true,
            },
            alter_contact:{
                minlength:10,
                maxlength:10,
                number: true
            },
            email:{
                email:true,
                remote:"<?=$remote?>null/email"
            },
            city:"required",
            state:"required",
            address:"required",
            password:"required",
            username: {
                required:true,
                remote:"<?=$remote?>null/username"
            }
        },
        messages: {
            username: {
                required : "Please enter username!",
                remote : "Username already exists!"
            },
            email: {
                remote : "Email already exists!"
            }
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= "multipart/form-data">
<div class="modal-body">
    
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Image:</label>
                    <input type="file" name="pic" class="form-control" size="55550" accept=".png, .jpg, .jpeg, .gif" >
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
                    <label class="control-label">Owner Name:</label>
                    <input type="text" class="form-control" name="owner_name">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Contact Number:</label>
                    <input type="number" class="form-control" name="owner_contact">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Alternate Contact Number:</label>
                    <input type="number" class="form-control" name="alter_contact">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Email Id:</label>
                    <input type="email" class="form-control" name="email">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">DOB:</label>
                    <input type="date" name="dob" class="form-control">
                </div>
            </div>
        
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Username:</label>
                    <input type="text" class="form-control" name="username">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Password:</label>
                    <!-- <input type="text" class="form-control" name="password" value="<?= base64_encode(random_bytes(18)); ?>" readonly> -->
                    <input type="text" class="form-control" name="password" value="<?= mt_rand(100000, 999999); ?>" readonly>
                </div>
            </div>
            <div class="col-6">
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
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">City:</label>
                    <select class="form-control select2 city" style="width:100%;" name="city" id="city">
                    
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Address:</label>
                    <textarea cols="92" rows="5" class="form-control" name="address"></textarea>
                </div>
            </div>
        </div>

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>

<script type="text/javascript">
   function fetch_city(state)
   {
    $.ajax({
        url: "<?php echo base_url('business-store/fetch_city'); ?>",
        method: "POST",
        data: {
            state:state
        },
        success: function(data){
            $(".city").html(data);
        },
    });
   }
</script>