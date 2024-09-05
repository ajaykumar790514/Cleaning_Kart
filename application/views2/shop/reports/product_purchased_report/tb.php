<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
#reset-data
{
    background-color:red;
}
</style>
<div class="row">
    <div class="col-md-6 text-left">
        <!-- <span>Showing <?=$page+1?> to <?=$page+count($product_purchased_report)?> of <?=$total_rows?> entries</span> -->
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
            <!-- <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?=$search?>" placeholder="Search..."> -->
        </div>
        <div class="col-md-8 text-right" style="float: left;">
            <!-- <?=$links?> -->
        </div>
        

    </div>
</div>

<div class="row">
        <div class="col-4">
            <div class="form-group">
            <label class="control-label">From date:</label>
            <input type="date" class="form-control" name="from_date" id="from_date" value="<?=$from_date?>">
            </div>
            <div id="msg"></div>
        </div>

        <div class="col-4">
            <div class="form-group">
            <label class="control-label">To date:</label>
            <input type="date" class="form-control" name="to_date" id="to_date" value="<?=$to_date?>" onchange="filter_purchased_product(this.value)">
            </div>
        </div>
        <div class="col-3 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
        </div>
        <!-- <div class="col-4">
            <div class="form-group">
            <label class="control-label">Status:</label>
            <select class="form-control" style="width:100%;" name="status_id" id="status_id" onchange="filter_by_status(this.value)">
            <option value="">Select</option>
            <?php foreach ($order_status as $status) { ?>
            <option value="<?php echo $status->id; ?>" <?php if(!empty($statusid)) { if($statusid==$status->id) {echo "selected"; } }?>>
                <?php echo $status->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div> -->
</div>
<div id="datatable">
    <?php if(!empty($to_date)) { ?>
    <div class="row">
                <div class="col-md-12">
                <a href="<?= base_url('reports/product_purchased_report/export_to_excel/'.$from_date.'/'.$to_date); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a>
                </div>
            </div>
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Model</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Quantity</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Total</th>
            </tr>
            
            <?php $i=$page; foreach($product_purchased_report as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->prod_name;?> (<?php echo $value->unit_value.' '.$value->unit_type;?>)</td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->product_code;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->quantity.' '.$value->unit_type;?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?php echo $value->total;?></td>
                
            </tr> 
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($product_purchased_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
   function filter_purchased_product(to_date)
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
    if(from_date>to_date)
    {
        msg = "From date should be less than to date";
        document.getElementById('msg').style.color='red';
        document.getElementById('msg').innerHTML=msg;
        return;
    }
    $.ajax({
        url: "<?php echo base_url('reports/product_purchased_report/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date
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


