<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
</style>
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
            tax_id:"required",     expiry_date:"required",                                                     
            mfg_date:"required",                                                                                             
            name: {
                required:true,
            },
            product_code: {
                required:true,
                remote:"<?=$remote?>null/product_code"
            },
           
        },
        messages: {
            name: {
                required : "Please enter name!",
            },
            product_code: {
                required : "Please enter product code!",
                remote : "Product code already exists!"
            },
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
    
        
    <div class="row">
        <div class="col-4">
            <div class="form-group">
            <label class="control-label">Parent Categories:</label>
            <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_sub_categories(this.value)">
            <option value="">Select</option>
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
                <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_category(this.value)">
                                                                            
                </select>
            </div>
        </div>
        <div class="col-4">
            <div class="form-group">
                <label class="control-label">Categories:</label>
                <select class="form-control cat_id" style="width:100%;" name="cat_id" id="cat_id">
                                                                            
                </select>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Product Name:</label>
                    <input type="text" class="form-control" name="name">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Product Image:</label>
                    <input type="file" name="img[]" class="form-control"
size="55550" accept=".png, .jpg, .jpeg, .gif" multiple="" required>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Search Keyword:</label>
                    <input type="text" class="form-control" name="search_keywords">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Product Code:</label>
                    <input type="text" class="form-control" name="product_code" >
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                <label class="control-label">Brand Name:</label>
                    <select class="form-control select2" style="width:100%;" name="brand_id">
                    <option value="">Select Brand</option>
                    <?php foreach ($brands as $brand) { ?>
                    <option value="<?php echo $brand->id; ?>,<?php echo $brand->name; ?>">
                        <?php echo $brand->name; ?>
                    </option>
                    <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Product Quantity:</label>
                    <input type="number" class="form-control" name="unit_value">
                </div>
            </div>
            <div class="col-6">
            <div class="form-group">
            <label class="control-label">Quantity Type:</label>
            <select class="form-control select2" style="width:100%;" name="unit_type_id">
            <option value="">Select Quantity Type</option>
            <?php foreach ($unit_type as $unit) { ?>
            <option value="<?php echo $unit->id; ?>,<?php echo $unit->name; ?>">
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
                    <?php foreach ($tax_slabs as $value) { ?>
                    <option value="<?php echo $value->id; ?>,<?php echo $value->slab; ?>">
                        <?php echo $value->slab; ?>
                    </option>
                    <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Hsn/Sac Code:</label>
                    <input type="text" class="form-control" name="sku" >
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Application</label>
                    <input type="file" class="form-control" name="application">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Description:</label>
                    <textarea id="" cols="92" rows="5" class="form-control" name="description"></textarea>
                </div>
            </div>
        </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
</div>

</form>
            

