<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
.jsgrid-table
{
    width:166%;
}

h4
{
    color:blue;
}
#reset-data
{
    background-color:red;
}
</style>

<?php $page =0;   ?>
<div class="row">
    <div class="col-md-6 text-left">
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
            <!-- <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?=$search?>" placeholder="Search..."> -->
        </div>
        <div class="col-md-8 text-right" style="float: left;">
           
        </div>
       
    </div>
</div>
<div class="row">
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">From date:</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="<?php if(!empty($from_date)){echo $from_date; }?>">
            </div>
            <div id="msg"></div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label class="control-label">To date:</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="<?php if(!empty($to_date)){echo $to_date; }?>" onchange="filter_purchase_report(this.value)">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
            <label class="control-label">Vendor:</label>
            <select class="form-control" style="width:100%;" name="vendor_id" id="vendor_id" onchange="filter_by_vendor(this.value)">
            <option value="">Select</option>
            <?php foreach ($vendor_list as $vendor) { ?>
            <option value="<?php echo $vendor->id; ?>" <?php if(!empty($vendor_id)) { if($vendor_id==$vendor->id) {echo "selected"; } }?>>
                <?php echo $vendor->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
            <label class="control-label">Brand:</label>
            <select class="form-control" style="width:100%;" name="brand_id" id="brand_id" onchange="filter_by_brand(this.value)">
            <option value="">Select</option>
            <?php foreach ($brands as $brand) { ?>
            <option value="<?php echo $brand->id; ?>" <?php if(!empty($brand_id)) { if($brand_id==$brand->id) {echo "selected"; } }?>>
                <?php echo $brand->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Search:</label>
                <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search...">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Parent Categories:</label>
                <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_sub_categories(this.value)">
                <option value="">Select</option>
                <?php foreach ($parent_cat as $parent) { ?>
                <option value="<?php echo $parent->id; ?>" <?php if(!empty($parent_id)) { if($parent_id==$parent->id) {echo "selected"; } }?>>
                    <?php echo $parent->name; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Sub Categories:</label>
                
                <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id"  onchange="filter_by_subcategory(this.value)">
                    <?php if($parent_cat_id!=='null') { ?>
                        <?php foreach ($sub_cat as $scat) { ?>
                        <option value="<?php echo $scat->id; ?>" <?php if(!empty($parent_cat_id)) { if($parent_cat_id==$scat->id) {echo "selected"; } }?>>
                            <?php echo $scat->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>                                  
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Categories:</label>
                
                <select class="form-control child_cat_id" style="width:100%;" name="cat_id" id="cat_id" onchange="fetch_by_cat(this.value)">
                    <?php if($child_cat_id!=='null') { ?>
                        <?php foreach ($child_cat as $ccat) { ?>
                        <option value="<?php echo $ccat->id; ?>" <?php if($child_cat_id!='null') { if($child_cat_id==$ccat->id) {echo "selected"; } }?>>
                            <?php echo $ccat->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>                                  
                </select>
            </div>
        </div>
        <div class="col-2 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
       
</div>

<div id="datatable">
    <?php if(!empty($to_date)) { 
         $total_value_with_tax_sum = $purchase_result->total_value;
         $total_value_without_tax_sum = $total_value_with_tax_sum - $purchase_result->total_tax;
        ?>
        <div class="row mt-3">
            <div class="col-md-2">
            <a href="<?= base_url('reports/purchase_report/export_to_excel/'.$from_date.'/'.$to_date.'/'.$vendor_id."/".$search."/".$brand_id."/".$parent_id."/".$parent_cat_id."/".$child_cat_id); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a>
            </div>
            <div class="col-md-3 mt-1">
            <h4>Total without tax = ₹ <?= round($total_value_without_tax_sum,2); ?></h4>
            </div>
            <div class="col-md-3 mt-1">
            <h4>Total tax = ₹ <?= round($purchase_result->total_tax,2); ?></h4>
            </div>
            <div class="col-md-3 mt-1">
            <h4>Total with tax = ₹ <?= round($purchase_result->total_value,2); ?></h4>
            </div>
        </div>
    <div id="grid_table" class="table-responsive">
        <table class="jsgrid-table" >
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Purchase Date</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Brand</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Software Parent Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Software Sub-Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Product Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Product Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Expiry Date</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Hsn/Sac</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Vendor Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Invoice no</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">MRP</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total MRP Value</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Quantity</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Unit Type</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Unit Price without tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total without tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">UP/EXUP</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Tax rate</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Igst rate</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Cgst rate</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Sgst rate</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Igst value</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Cgst value</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Sgst value</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total value with tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Product Price / Piece</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Additional Discount</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Vendor Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">GSTIN</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Address</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Purchase Type</th>
                
            </tr>
            
            <?php $i=$page; foreach($purchase_report as $value){    
                $purchase_rate = $value->purchase_rate;
                $tax =  $value->tax_value;
                $inclusive_tax = $purchase_rate - ($purchase_rate * (100/ (100 + $tax)));

                $unit_price_without_tax =  $purchase_rate - $inclusive_tax;
                $total_tax = $inclusive_tax*$value->qty;

                $total_without_tax = $unit_price_without_tax * $value->qty;
                $total_value_with_tax = $total_without_tax + $total_tax;
                


                if($value->is_igst == 1)
                {
                    $igst = $value->tax_value;
                    $cgst = 0;$sgst = 0;
                    $cgst_val = 0;$sgst_val = 0;
                    $igst_val = $inclusive_tax;
                    $up_exup = 'EXUP';
                }
                else if($value->is_igst == 0)
                {
                    $cgst = $value->tax_value/2;
                    $sgst = $value->tax_value/2;
                    $cgst_val = $inclusive_tax/2;
                    $sgst_val = $inclusive_tax /2;
                    $igst=0;$igst_val=0;
                    $up_exup = 'UP';
                }

                ?>
                
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= date_format_func($value->invoice_date);?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->brand_name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php foreach ($categories as $cat) {
                        if($cat->id == $value->is_parent){
                            echo $cat->name;
                        } 
                    } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php foreach ($categories as $cat) {
                        if($cat->id == $value->sub_cat_id){
                            echo $cat->name;
                        } 
                    } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php foreach ($categories as $cat) {
                        if($cat->id == $value->parent_cat_id){
                            echo $cat->name;
                        } 
                    } ?>
                </td>
               
                
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->product_code; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->product_name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->expiry_date; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->sku; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->vendor_name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->invoice_no; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->mrp; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= ($value->mrp*$value->qty); ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->qty; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->unit_type; ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($unit_price_without_tax,2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($total_without_tax,2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $up_exup; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= round($value->tax_value, 2); ?> %</td>
                <td class="jsgrid-cell jsgrid-align-center"><?= round($igst, 2); ?> %</td>
                <td class="jsgrid-cell jsgrid-align-center"><?= round($cgst, 2); ?> %</td>
                <td class="jsgrid-cell jsgrid-align-center"><?= round($sgst, 2); ?> %</td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($igst_val, 2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($cgst_val, 2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($sgst_val, 2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($total_tax,2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($total_value_with_tax,2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= $value->purchase_rate; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->AdditionalDiscount; ?> %</td >
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->vendor_code; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->gstin; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->vendor_address; ?></td>
                <td class="jsgrid-cell jsgrid-align-center">Bill</td >
                
                
            </tr> 
            <?php } 
                           
            ?>  
 
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($purchase_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
   function filter_purchase_report(to_date)
   {
    if(document.getElementById('from_date').value == 0)
    {
        alert('Please Select From Date');
        document.getElementById('from_date').focus();
        $('#to_date').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
        var from_date = $("#from_date").val();
        var vendor_id = $("#vendor_id").val();
        var search  = $('#tb-search').val();
        var brand_id = $("#brand_id").val();
        var parent_id  = $('#parent_id').val();
        var parent_cat_id  = $('#parent_cat_id').val();
        var cat_id  = $('#cat_id').val();
        if(from_date>to_date)
        {
            msg = "From date should be less than to date";
            document.getElementById('msg').style.color='red';
            document.getElementById('msg').innerHTML=msg;
            return;
        }
        $.ajax({
            url: "<?php echo base_url('reports/purchase_report/tb'); ?>",
            method: "POST",
            data: {
                from_date:from_date,
                to_date:to_date,
                vendor_id:vendor_id,
                search:search,
                brand_id:brand_id,
                parent_id:parent_id,
                parent_cat_id:parent_cat_id,
                child_cat_id:cat_id,
            },
            success: function(data){
                debugger;
                $("#tb").html(data);
            },
        });
   }
</script>

<script type="text/javascript">
   function filter_by_vendor(vendor_id)
   {
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var from_date = $("#from_date").val();
    var to_date = $('#to_date').val();
    var search  = $('#tb-search').val();
    var brand_id = $("#brand_id").val();
    var parent_id  = $('#parent_id').val();
    var parent_cat_id  = $('#parent_cat_id').val();
    var cat_id  = $('#cat_id').val();

    $.ajax({
        url: "<?php echo base_url('reports/purchase_report/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            vendor_id:vendor_id,
            search:search,
            brand_id:brand_id,
            parent_id:parent_id,
            parent_cat_id:parent_cat_id,
            child_cat_id:cat_id,
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   };
   function filter_by_brand(brand_id)
   {
       $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');

        var from_date = $("#from_date").val();
        var to_date = $('#to_date').val();
        var vendor_id = $("#vendor_id").val();
        var search  = $('#tb-search').val();
        var parent_id  = $('#parent_id').val();
        var parent_cat_id  = $('#parent_cat_id').val();
        var cat_id  = $('#cat_id').val();

        $.ajax({
            url: "<?php echo base_url('reports/purchase_report/tb'); ?>",
            method: "POST",
            data: {
                from_date:from_date,
                to_date:to_date,
                vendor_id:vendor_id,
                brand_id:brand_id,
                search:search,
                parent_id:parent_id,
                parent_cat_id:parent_cat_id,
                child_cat_id:cat_id,
            },
            success: function(data){
                $("#tb").html(data);
            },
        });
   };
</script>
<script>
    $('#reset-data').click(function(){
        location.reload();
    });
    function fetch_sub_categories(parent_id)
   {
        var from_date = $("#from_date").val();
        var to_date = $('#to_date').val();
        var vendor_id = $("#vendor_id").val();
        var brand_id = $("#brand_id").val();
        var search  = $('#tb-search').val();
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_sub_categories'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id,    //cat1 id
        },
        success: function(data){
            $(".parent_cat_id").html(data);

            var cat_id = $('#parent_cat_id').val(); //cat2 id
            if(parent_id == '')
            {
                $.ajax({
                    url: "<?php echo base_url('reports/purchase_report/tb'); ?>",
                    method: "POST",
                    data: {
                        cat_id:cat_id,
                        parent_id:parent_id,
                        from_date:from_date,
                        to_date:to_date,
                        vendor_id:vendor_id,
                        brand_id:brand_id,
                        search:search,
                    },
                    success: function(data){
                    $("#tb").html(data);
                    
                    },
                });
            }
        },
    });
   };
   function filter_by_subcategory(parent_cat_id)
   {
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');

        var from_date = $("#from_date").val();
        var to_date = $('#to_date').val();
        var search  = $('#tb-search').val();
        var vendor_id  = $('#vendor_id').val();
        var brand_id  = $('#brand_id').val();
        var parent_id  = $('#parent_id').val();

        $.ajax({
            url: "<?php echo base_url('reports/purchase_report/tb'); ?>",
            method: "POST",
            data: {
                from_date:from_date,
                to_date:to_date,
                search:search,
                vendor_id:vendor_id,
                parent_cat_id:parent_cat_id,
                parent_id:parent_id,
                brand_id:brand_id
            },
            success: function(data){
                $("#tb").html(data);
                //ajax method for loading child categories
                    $.ajax({
                        url: "<?php echo base_url('master-data/fetch_cat'); ?>",
                        method: "POST",
                        data: {
                            parent_cat_id:parent_cat_id
                        },
                        success: function(data){
                            $(".child_cat_id").html(data);
                        },
                    });
            },
        });
  
   };
   function fetch_by_cat(child_cat_id)
   {
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');

        var from_date = $("#from_date").val();
        var to_date = $('#to_date').val();
        var search  = $('#tb-search').val();
        var vendor_id  = $('#vendor_id').val();
        var brand_id  = $('#brand_id').val();
        var parent_id  = $('#parent_id').val();
        var parent_cat_id  = $('#parent_cat_id').val();

        $.ajax({
            url: "<?php echo base_url('reports/purchase_report/tb'); ?>",
            method: "POST",
            data: {
                from_date:from_date,
                to_date:to_date,
                search:search,
                vendor_id:vendor_id,
                brand_id:brand_id,
                parent_cat_id:parent_cat_id,
                parent_id:parent_id,
                child_cat_id:child_cat_id,
            },
            success: function(data){
                $("#tb").html(data);
            },
        });
  
   }
</script>

