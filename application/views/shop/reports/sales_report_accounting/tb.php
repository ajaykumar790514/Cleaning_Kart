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
        <!-- <span>Showing <?php //$page+1?> to <?php //$page+count($stock_report)?> of <?php //$total_rows?> entries</span> -->
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
                <input type="date" class="form-control" name="to_date" id="to_date" value="<?php if(!empty($to_date)){echo $to_date; }?>" onchange="filter_sales_report(this.value)">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Group By:</label>
                <select class="form-control" style="width:100%;" name="group_by" id="group_by" onchange="fetch_by_group(this.value)">
                    <option value="Years" <?php if(!empty($group_by)){if($group_by == 'Years'){echo "selected";} }?>>Years</option>
                    <option value="Months" <?php if(!empty($group_by)){if($group_by == 'Months'){echo "selected";} }?>>Months</option>
                    <option value="Days" <?php if(!empty($group_by)){if($group_by == 'Days'){echo "selected";} }?>>Days</option>
                </select>
            </div>
        </div>
        <div class="col-2">
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
        <div class="col-2 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
</div>

<div id="datatable">
    <?php if(!empty($to_date)) { ?>
        <div class="row">
            <div class="col-md-12">
            <a href="<?= base_url('reports/sales_report_accounting/export_to_excel/'.$from_date.'/'.$to_date.'/'.$group_by.'/'.$status_id); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a>
            <!-- <button href="<?= base_url('sales-export'); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</button> -->
            </div>
        </div>
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Date Start</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Date End</th>
                <th class="jsgrid-header-cell jsgrid-align-center">No. Orders</th>
                <th class="jsgrid-header-cell jsgrid-align-center">No. Products</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Tax</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Total</th>
            </tr>
            
            <?php $i=$page; foreach($sales_report as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= date_format_func($value->min_date);?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= date_format_func($value->max_date);?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->order_count; ?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->total_products; ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= $value->total_tax; ?></td>
                <td class="jsgrid-cell jsgrid-align-center">₹ <?= $value->total; ?> </td>
                
            </tr> 
            <?php } ?>    
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($sales_report)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<?php } ?>
<script type="text/javascript">
   function filter_sales_report(to_date)
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
    var group_by = $("#group_by").val();
    var status_id = $("#status_id").val();
    if(from_date>to_date)
    {
        msg = "From date should be less than to date";
        document.getElementById('msg').style.color='red';
        document.getElementById('msg').innerHTML=msg;
        return;
    }
    $.ajax({
        url: "<?php echo base_url('reports/sales_report_accounting/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            group_by:group_by,
            status_id:status_id
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function fetch_by_group(group_by)
   {
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var status_id = $("#status_id").val();
    $.ajax({
        url: "<?php echo base_url('reports/sales_report_accounting/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            group_by:group_by,
            status_id:status_id
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function export_to_excel()
   {
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var group_by = $("#group_by").val();
    $.ajax({
        url: "<?php echo base_url('reports/sales_report_accounting/export_to_excel'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            group_by:group_by
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
    var group_by = $("#group_by").val();
    $.ajax({
        url: "<?php echo base_url('reports/sales_report_accounting/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            group_by:group_by,
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

