<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
#reset-data
{
    background-color:red;
}
h4
{
    color:blue;
}
</style>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($stock_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
        </div>
        <div class="col-md-8 text-right" style="float: left;">
            <?=$links?>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-3">
       <a href='<?= base_url("reports/product_stock_report/export_to_excel/{$vendor_id}/{$parent_id}/{$parent_cat_id}/{$product_id}/{$brand_id}/{$tb_search}"); ?>' class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a>
    </div>
    <div class="col-md-3 mt-1">
        <h4>Total Value = ₹ <?=(@$stock_result->total_purchase) ? round($stock_result->total_purchase,2) : 0 ;?></h4>
    </div>
    <div class="col-md-3 mt-1">
        <h4>Total Stock = ₹ <?=(@$stock_result->total_stock) ?  round($stock_result->total_stock,2) : 0  ?></h4>
    </div>
</div>
<div id="datatable">
    <div id="grid_table" class="table-responsive">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Purchase Rate</th>

                <th class="jsgrid-header-cell jsgrid-align-center">Sale Price ( Online Sale Price )</th>
                
                    <th class="jsgrid-header-cell jsgrid-align-center">Invoice No</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Pack Size</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Stock</th>
            </tr>
            
            <?php $i=$page; foreach($stock_report as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->product_code;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><b><?php echo $value->prod_name;?></b> (<?php echo $value->cat_name;?>)</td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?php echo $value->purchase_rate;?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?php echo $value->selling_rate;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->invoice_no;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->unit_value.' '.$value->unit_type;?></td>
                <th class="jsgrid-cell jsgrid-align-center"><?php echo $value->qty;?></th>
                
            </tr> 
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($stock_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<script type="text/javascript">
   function fetch_data(cat_id)
   {
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var parent_id = $('#parent_id').val();
    var search = $('#tb-search').val();

    $.ajax({
        url: "<?php echo base_url('reports/product_stock_report/tb'); ?>",
        method: "POST",
        data: {
            cat_id:cat_id,
            parent_id:parent_id,
            search:search
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
</script>
<script>
           $('#reset-data').click(function(){
                location.reload();
            })
    </script>

