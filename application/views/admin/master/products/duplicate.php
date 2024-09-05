<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            parent_cat_id:"required",
            parent_id:"required",
            unit_value:"required",
            unit_type:"required",
            description:"required",                                   
            unit_type_id:"required",                                     
            name:"required",           
            tax_id:"required",                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
            expiry_date:"required",                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
            mfg_date:"required", 
            product_code: {
                required:true,
                remote:"<?=$remote?>null/product_code"
            },
        },
        messages: {
            product_code: {
                required : "Please enter product code!",
                remote : "Product code already exists!"
            },
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>

    <div class="row">
    <div class="col-4">
            <div class="form-group">
            <label class="control-label">Parent Categories:</label>
            <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_sub_categories(this.value)" required>
            <option value="">Select</option>
            <?php foreach ($parent_cat as $parent) { ?>
            <option value="<?php echo $parent->id; ?>" <?php if($parent->id == $value->is_parent){echo "selected";} ?>>
                <?php echo $parent->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
            <label class="control-label">Sub Categories:</label>
                <select class="form-control select2 parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_update_category(this.value)" required>
                    <option value="<?php echo $value->cat_id; ?>">
                        <?php echo $value->cat_name; ?>
                    </option>
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
            <label class="control-label">Categories:</label>
                <select class="form-control select2 update_cat_id" style="width:100%;" name="cat_id" id="cat_id">
                    <option value="<?php echo $value->main_cat_id; ?>">
                        <?php echo $value->main_cat_name; ?>
                    </option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Product Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo $value->name; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Search Keyword:</label>
                <input type="text" class="form-control" name="search_keywords" value="<?php echo $value->search_keywords; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Product Code:</label>
                <input type="text" class="form-control" name="product_code" value="<?php echo $value->product_code; ?>">
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Product Quantity:</label>
                <input type="number" class="form-control" name="unit_value" value="<?php echo $value->unit_value; ?>">
            </div>
        </div>
        <div class="col-6">
        <div class="form-group">
        <label class="control-label">Quantity Type:</label>
        <select class="form-control select2" style="width:100%;" name="unit_type_id">
        <option value="">Select Quantity Type</option>
        <?php foreach ($unit_type as $unit) { ?>
        <option value="<?php echo $unit->id; ?>,<?php echo $unit->name; ?>" <?php if($unit->id == $value->unit_type_id){echo "selected";} ?>>
            <?php echo $unit->name; ?>
        </option>
        <?php } ?>
        </select>
    </div>
        </div>
       
            <div class="col-6">
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
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Hsn/Sac Code:</label>
                    <input type="text" class="form-control" name="sku" value="<?php echo $value->sku; ?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Application</label>
                    <input type="file" name="application" class="form-control">
                </div>
                <?php if(!empty($value->application)) { ?>
                    <img src="<?php echo IMGS_URL.$value->application;?>" alt="<?php echo $value->name; ?>" height="50">
                <?php } ?> 
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Product Image:</label>
                    <input type="file" name="img[]" class="form-control"
size="55550" accept=".png, .jpg, .jpeg, .gif" multiple="" required>
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                <label class="control-label">Brand Name:</label>
                    <select class="form-control select2" style="width:100%;" name="brand_id">
                    <option value="">Select Brand</option>
                    <?php foreach ($brands as $brand) { ?>
                    <option value="<?php echo $brand->id; ?>,<?php echo $brand->name; ?>" <?php if($brand->id == $value->brand_id){echo "selected";} ?>>
                        <?php echo $brand->name; ?>
                    </option>
                    <?php } ?>
                    </select>
                </div>
            </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea id="" cols="92" rows="5" name="description"><?=$value->description?></textarea>
            </div>
        </div>
    </div>

<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Create</button>
    <!-- <input id="btnsubmit" type="submit" class="btn btn-primary waves-light" type="submit" value="UPDATE"> -->
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