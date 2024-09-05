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
        <table class="jsgrid-table table table-sm table-borderd" >
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Purchase Date</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Invoice no</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Product Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Brand</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Hsn/Sac</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Vendor Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Vendor Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Quantity</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Unit Type</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Expiry Date</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">MRP</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Total MRP Value</th>
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
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">GSTIN</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Address</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Software Parent Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Software Sub-Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center table-heading">Product Category</th>
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
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->invoice_no; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->product_code; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->brand_name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->product_name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->sku; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->vendor_name; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->vendor_code; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->qty; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->unit_type; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->expiry_date; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->mrp; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= ($value->mrp*$value->qty); ?></td>
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
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->AdditionalDiscount; ?> %</td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->gstin; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->vendor_address; ?></td>
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
                <td class="jsgrid-cell jsgrid-align-center">Bill</td>
            </tr> 
            <?php } ?>  
 
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
 