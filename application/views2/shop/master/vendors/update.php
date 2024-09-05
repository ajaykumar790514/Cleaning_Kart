<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            name:"required",
            mobile: {
                required:true,
                minlength:10,
                maxlength:10,
                number: true,
            },
            altenate_mobile: {
                minlength:10,
                maxlength:10,
                number: true,
            },
            state:"required",
            city:"required",
            address:"required",   
            gstin: {
                required:true,
                // remote:"<?=$remote?>null/gstin"
            },
            vendor_code: {
                required:true,
                // remote:"<?=$remote?>null/vendor_code"
            },
        },
        messages: {
            vendor_code: {
                remote : "Vendor Code Already Exists!!"
            },
            gstin: {
                remote : "GSTIN Already Exists!!"
            },
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post">

<div class="modal-body">
    
        
    <div class="row">
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?= $value->name;?>">
                </div>
        </div>
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Email:</label>
                    <input type="email" class="form-control" name="email" value="<?= $value->email;?>">
                </div>
        </div>
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Mobile:</label>
                    <input type="number" class="form-control" name="mobile" value="<?= $value->mobile;?>">
                </div>
        </div>
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Alternate Mobile:</label>
                    <input type="number" class="form-control" name="alternate_mobile" value="<?= $value->alternate_mobile;?>">
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
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">GSTIN:</label>
                    <input type="text" class="form-control" name="gstin" value="<?= $value->gstin;?>" readonly>
                </div>
        </div>
        <div class="col-6">
                    <div class="form-group">
                        <label class="control-label">Vendor Code:</label>
                        <input type="text" class="form-control" name="vendor_code" value="<?= $value->vendor_code;?>" readonly>
                    </div>
            </div>
            <div class="col-12">
                    <div class="form-group">
                        <label class="control-label">Pincode:</label>
                        <input type="number" class="form-control" name="pincode" value="<?= $value->pincode;?>">
                    </div>
            </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Address:</label>
                <textarea cols="92" rows="5" class="form-control" name="address"><?= $value->address;?></textarea>
            </div>
        </div>
    
</div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Update</button>
    </div>

</form>
