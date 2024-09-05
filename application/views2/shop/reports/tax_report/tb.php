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
        <!-- <span>Showing <?=$page+1?> to <?=$page+count($tax_report)?> of <?=$total_rows?> entries</span> -->
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
                <input type="date" class="form-control" name="to_date" id="to_date" value="<?php if(!empty($to_date)){echo $to_date; }?>" onchange="filter_tax_report(this.value)">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
            <label class="control-label">Status:</label>
            <select class="form-control" style="width:100%;" name="status_id" id="status_id" onchange="filter_by_status(this.value)">
            <option value="">Select</option>
            <?php foreach ($order_status as $status) { ?>
            <option value="<?php echo $status->id; ?>" <?php if(!empty($status_id)) { if($status_id==$status->id) {echo "selected"; } }?>>
                <?php echo $status->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>
        <div class="col-3 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
       
</div>
<div id="datatable">
    <?php if(!empty($to_date)) { ?>
        <div class="row">
            <div class="col-md-12">
            <a href="<?= base_url('reports/tax_report/export_to_excel/'.$from_date.'/'.$to_date.'/'.$status_id); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a>
            </div>
        </div>
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Date Start</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Date End</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Tax Title(IGST)</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Tax Title(CGST)</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Tax Title(SGST)</th>
                <th class="jsgrid-header-cell jsgrid-align-center">No. Orders</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Total</th>
            </tr>
            
            <?php $i=$page;$igst=0;$cgst = 0;$sgst = 0;$totaligst=0;$totalcgst=0;$totalsgst=0;$totalvalue=0;$totalorders=0; foreach($tax_report as $value){ 
                if($value->is_igst == 1)
                {
                    $igst = $igst + $value->order_tax;
                    $totaligst = $totaligst + $igst;
                }
                else if($value->is_igst == 0)
                {
                    $cgst = $cgst + ($value->order_tax/2);
                    $sgst = $sgst + ($value->order_tax/2);
                    $totalcgst = $totalcgst + $cgst;
                    $totalsgst = $totalsgst + $sgst;
                }
                $totalorders = $totalorders + $value->order_count;
                $totalvalue = $totalvalue + $value->total;
                ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= date_format_func($value->added);?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= date_format_func($value->added);?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($igst, 2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($cgst, 2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= round($sgst, 2); ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->order_count; ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= $value->total; ?></td>
                
            </tr> 
            <?php } ?>   
            
            <tr class="jsgrid-filter-row" class="table-light">
                <td class="jsgrid-cell jsgrid-align-center" colspan="2"></td>
                <th class="jsgrid-cell jsgrid-align-center">Total</th>
                <th class="jsgrid-cell jsgrid-align-center">₹ <?= round($totaligst,2); ?></th>
                <th class="jsgrid-cell jsgrid-align-center">₹ <?= round($totalcgst,2); ?></th>
                <th class="jsgrid-cell jsgrid-align-center">₹ <?= round($totalsgst,2); ?></th>
                <th class="jsgrid-cell jsgrid-align-center"><?= $totalorders; ?></th>
                <th class="jsgrid-cell jsgrid-align-center">₹ <?= round($totalvalue,2); ?></th>
                
            </tr>  
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($tax_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
   function filter_tax_report(to_date)
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
    var status_id = $("#status_id").val();
    if(from_date>to_date)
    {
        msg = "From date should be less than to date";
        document.getElementById('msg').style.color='red';
        document.getElementById('msg').innerHTML=msg;
        return;
    }
    $.ajax({
        url: "<?php echo base_url('reports/tax_report/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            status_id:status_id
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
</script>

<script type="text/javascript">
   function filter_by_status(status_id)
   {
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var from_date = $("#from_date").val();
    var to_date = $('#to_date').val();
    $.ajax({
        url: "<?php echo base_url('reports/tax_report/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            status_id:status_id
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }

    $('#reset-data').click(function(){
        location.reload();
    })
</script>

