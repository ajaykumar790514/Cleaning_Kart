<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            shop_category_id :"required",
            business_id :"required",
            shop_name:"required",
            state:"required",
            city:"required",
            pin_code:"required",                                           
            address:"required",                                          
            open_time:"required",                                       
            close_time:"required",                                                    
            cod_limit:"required",                                           
            gstin:"required",                                         
            photo:"required",                                   
            contact: {
                required:true,
                minlength:10,
                maxlength:10,
                number: true,
                remote:"<?=$remote?>null/contact"
            },
            alternate_contact: {
                minlength:10,
                maxlength:10,
                number: true,
            },
            email: {
                email:true,
                remote:"<?=$remote?>null/email"
            }
        },
        messages: {
            contact: {
                remote : "Shop is already registered with this contact"
            },
            email: {
                remote : "Email already exists!"
            }
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post">
<div class="modal-body">
        <div class="row">
        <div class="col-md-12">
                <div class="form-group">
                    <label for="">Select Location</label>
                    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                    <div id="map" style="width: auto; height: 400px;"></div>  
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" id="longitude" class="form-control" name="longitude" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" id="latitude" class="form-control" name="latitude" readonly>
                </div>
            </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Shop Category:</label>
                <select class="form-control shop_cat select2" style="width:100%;" name="shop_category_id[]" multiple data-selected-text-format="count>2" required>
                <?php foreach ($shop_cat as $shop) { ?>
                <option value="<?php echo $shop->id; ?>">
                    <?php echo $shop->name; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Business:</label>
                <select class="form-control select2" style="width:100%;" name="business_id">
                <option value="">--Select--</option>
                <?php foreach ($businesses as $business) { ?>
                <option value="<?php echo $business->id; ?>">
                    <?php echo $business->title; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Shop Name</label>
                    <input type="text" class="form-control" name="shop_name">
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
                    <label class="control-label">Contact Number:</label>
                    <input type="number" class="form-control" name="contact">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Alternate Contact Number:</label>
                    <input type="number" class="form-control" name="alternate_contact">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Open Time:</label>
                    <input type="time" class="form-control" name="open_time">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Close Time:</label>
                    <input type="time" class="form-control" name="close_time">
                </div>
            </div>
            
            <div class="col-2">
                <div class="form-group">
                <input type='checkbox' name='isDelivery' value='1' id="isDelivery"/>
                <label for="isDelivery">Delivery</label>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                <input type='checkbox' name='is_cod' value='1' id="is_cod"/>
                <label for="is_cod">COD</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                <input type='checkbox' name='is_online_payments' value='1' id="is_online_payments"/>
                <label for="is_online_payments">Online Payment</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                <input type='checkbox' name='is_live' value='1' id="is_live"/>
                <label for="is_live">Open/Close</label>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                <input type='checkbox' name='is_security' value='1' id="is_security"/>
                <label for="is_security">Security</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Photo:</label>
                    <input type="file" name="photo[]" class="form-control" size="55550" accept=".png, .jpg, .jpeg, .gif" multiple="" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Payment Gateway Name:</label>
                    <input type="text" class="form-control" name="payment_gateway_name">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Payment Key Id:</label>
                    <input type="text" class="form-control" name="key_id">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Payment Key Secret:</label>
                    <input type="text" class="form-control" name="key_secret">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">GST in:</label>
                    <input type="text" class="form-control" name="gstin">
                </div>
            </div>
            
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">COD Limit:</label>
                    <input type="number" class="form-control" name="cod_limit">
                </div>
            </div>
            <!-- <div class="col-6">
                <div class="form-group">
                    <label class="control-label">District</label>
                    <input type="text" class="form-control" name="district" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Locality</label>
                    <input type="text" class="form-control" name="locality" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Longitude:</label>
                    <input type="text" class="form-control" name="longitude" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Latitude:</label>
                    <input type="text" class="form-control" name="latitude" readonly>
                </div>
            </div> -->
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Delivery Range(KM):</label>
                    <input type="number" class="form-control" name="delivery_range">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Logo:</label>
                    <input type="file" class="form-control" name="logo">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Description:</label>
                    <textarea cols="92" rows="5" class="form-control" name="description"></textarea>
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
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Pin Code</label>
                    <input type="number" class="form-control" name="pin_code">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Password:</label>
                    <input type="text" class="form-control" name="password" value="<?= mt_rand(100000, 999999); ?>" readonly>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Site Key</label>
                    <input type="text" class="form-control" name="site_key">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Secret Key</label>
                    <input type="text" class="form-control" name="secret_key">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Address:</label>
                    <textarea cols="92" rows="5" class="form-control" name="address"></textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Analytics Code</label>
                    <textarea cols="92" rows="5" class="form-control" name="analytics_code"></textarea>
                </div>
            </div>
        </div>

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <!-- <input class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>

<script src="http://maps.google.com/maps/api/js?key=AIzaSyCpnibB5v9t1-bGn0ub8_a-c50BwKrCwR4&libraries=places&callback=initAutocomplete"
async defer
></script>

<script>
    $(document).ready(function(){
        $('.shop_cat').selectpicker();
    })
</script>
