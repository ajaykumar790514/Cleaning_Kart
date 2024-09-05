<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
.jsgrid-table
{
    width:202%;
}
h4
{
    color:blue;
}
#reset-data
{
    background-color:red;
}
.jsgrid-table {
    width: 100%;
}
</style>
<div class="row">
    <div class="col-md-6 text-left">
        <!-- <span>Showing <?=$page+1?> to <?=$page+count($sales_report)?> of <?=$total_rows?> entries</span> -->
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

        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Date: <span><b class="text-primary day_name"></b></span></label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="<?php if(!empty($to_date)){echo $to_date; }?>" onchange="filter_subscription()"  min="<?= date('Y-m-d'); ?>">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Plan type:</label>
                <select class="form-control" style="width:100%;" name="plan_type_id" id="plan_type" onchange="filter_subscription()">
                <option value="">Select</option>
                <?php foreach ($plan_types as $plan) { ?>
                <option value="<?php echo $plan->id; ?>" <?php if($plan_type_id!='null') { if($plan_type_id==$plan->id) {echo "selected"; } }?>>
                    <?php echo $plan->plan; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Delivery Slot:</label>
                <select class="form-control" style="width:100%;" name="time_slot_id" id="delivery_slot" onchange="filter_subscription()">
                <option value="">Select</option>
                <?php foreach ($delivery_slots as $slots) { ?>
                <option value="<?= $slots->id; ?>" <?php if($time_slot_id!='null') { if($time_slot_id==$slots->id) {echo "selected"; } }?>>
                    
                    <?= date('h:i a',strtotime($slots->timestart)).'-'.date('h:i a',strtotime($slots->timeend)); ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Customers:</label>
                <select class="form-control" style="width:100%;" name="user_id" id="user_id" onchange="filter_subscription()">
                <option value="">Select</option>
                <?php if(!empty($to_date)){
                    $customers = array();
                    foreach($subscriptions as $subscr){ 
                        foreach($subscr as $val){
                            $customer_id = $val->customer_id;
                            if(!in_array($val->customer_id,$customers))
                            {
                                array_push($customers,$customer_id);
                ?>
                <option value="<?= $val->customer_id; ?>"  <?php if($user_id!='null') { if($user_id==$val->customer_id) {echo "selected"; } }?>>
                    <?= $val->fname.'('.$val->mobile.')'; ?>
                </option>
                <?php } }}}?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Products:</label>
                <select class="form-control" style="width:100%;" name="product_id" id="product_id" onchange="filter_subscription()">
                <option value="">Select</option>
                <?php if(!empty($to_date)){
                    $products = array();
                    foreach($subscriptions as $subscr){ 
                        foreach($subscr as $val){
                            $prod_id = $val->product_id;
                            if(!in_array($val->product_id,$products))
                            {
                                array_push($products,$prod_id);
                ?>
                <option value="<?= $val->product_id; ?>" <?php if($product_id!='null') { if($product_id==$val->product_id) {echo "selected"; } }?>>
                    <?= $val->product_name; ?>
                </option>
                <?php } }}}?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
            <label class="control-label">Status:</label>
                <select class="form-control" style="width:100%;" name="status_id" id="status_id" onchange="filter_subscription()">
                    <option value="">Select</option>
                    <?php foreach ($order_status as $status) { ?>
                    <option value="<?php echo $status->id; ?>" <?php if($status_id!='null') { if($status_id==$status->id) {echo "selected"; } }?>>
                        <?php echo $status->name; ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Pincodes:</label>
                <select class="form-control" style="width:100%;" name="address_id" id="address_id" onchange="filter_subscription()">
                <option value="">Select</option>
                <?php if(!empty($to_date)){
                    $pincodes = array();
                    foreach($subscriptions as $subscr){ 
                        foreach($subscr as $val){
                            $addr_id = $val->address_id;
                            if(!in_array($val->address_id,$pincodes))
                            {
                                array_push($pincodes,$addr_id);
                ?>
                <option value="<?= $val->address_id; ?>" <?php if($address_id!='null') { if($address_id==$val->address_id) {echo "selected"; } }?>>
                    <?= $val->pincode;; ?>
                </option>
                <?php } }}}?>
                </select>
            </div>
        </div>
        <!-- <div class="col-2">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div> -->
</div>
<!-- <?php foreach($subscriptions as $subscription){ 
                foreach($subscription as $value){$flag1='0';
                foreach($all_subs as $abc)
                {
                    if( $abc->user_id == $value->user_id && $abc->product_id == $value->product_id && $abc->date == $to_date)
                    {
                        $flag1='1';
                    }
                }
                if($flag1 == '1')
                {
                    if($value->plan_type_id == '3')
                    {
                        echo $value->plan;
                    }
                }
                if($flag1 == '0')
                {
                    echo $value->plan;
                }
                // echo $flag1;
            }}
                ?> -->
<div id="datatable">
<?php if(!empty($to_date)) { ?>
    <div class="col-md-3">
        <h4>Total Quantity = <?= $total_quantity; ?></h4>
    </div>
    <div class="col-md-2">
        <a href="<?= base_url('subscriptions/export_to_excel/'.$to_date.'/'.$plan_type_id.'/'.$time_slot_id.'/'.$user_id.'/'.$product_id."/".$status_id."/".$address_id); ?>" class="btn btn-primary btn-sm mb-3"><i class="fas fa-arrow-down"></i> Export to Excel</a>
    </div>
    <div id="grid_table" class="table-responsive">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Customer name/number</th>
                <th class="jsgrid-header-cell jsgrid-align-center" style="width: 240px;">Address</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Quantity</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Delivery Slot</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Plan type</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Order Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
 
            <?php $i=$page;$flag='0'; foreach($subscriptions as $subscription){ 
                foreach($subscription as $value){$flag='0';$flag1='0';
                foreach($all_subs as $abc)
                {
                    if( $abc->user_id == $value->user_id && $abc->product_id == $value->product_id && $abc->date == $to_date)
                    {
                        $flag1='1';
                    }
                }
             
                foreach($vacations as $vacation)
                {
                    if( $vacation->customer_id == $value->user_id && $vacation->vacation_date == $to_date)
                    {
                        $flag='1';
                    }
                }
                if($flag!='1' && $flag1 == '1')
                {
                    if($value->plan_type_id == '3')
                    {
                ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i;?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->fname .' '.$value->lname.'('.$value->mobile.')';?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->house_no.','.$value->address.','.$value->pincode.','.$value->address_contact.','.$value->address_contact_name.','.$value->nickname; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->product_name; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->qty; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= date('h:i a',strtotime($value->timestart)).'-'.date('h:i a',strtotime($value->timeend)); ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->plan; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center status<?=$value->sid ?>"><?= $value->order_status; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php if($value->sid == $value->order_sid){ ?>
                    <button class="btn btn-sm btn-success">Order generated</button>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Product ( <?=$value->product_name?> )" data-url="<?=$update_status_url?><?=$value->sid?>/<?=$value->status_id;?>" >
                        <i class="fa fa-edit"></i>
                        </a>
                    <?php } else {?>
                        <button class="btn btn-sm btn-primary order_button<?=$value->sid ?>" onclick="create_subscription_order(<?=$value->sid;?>,'<?=$to_date;?>',<?=$value->status_id;?>)">Generate order</button>
                    <?php }?>
                    
                </td>
                
            </tr> 
            <?php }}
        if($flag!='1' && $flag1 == '0')
        { 
            $order_flag = '0';
            $order_status_id = '';
            $order_status_name = '';
            foreach($order_details as $odetail)
            {
                if($odetail->order_sid == $value->sid && $odetail->order_date == $to_date)
                {
                    $order_flag = '1';
                    $order_status_id = $odetail->status;
                    $order_status_name = $odetail->status_name;
                }
            }
            ?>
<tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i;?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->fname .' '.$value->lname.'('.$value->mobile.')';?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->house_no.','.$value->address.','.$value->pincode.','.$value->address_contact.','.$value->address_contact_name.','.$value->nickname; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->product_name; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->qty; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= date('h:i a',strtotime($value->timestart)).'-'.date('h:i a',strtotime($value->timeend)); ?> </td>
                <td class="jsgrid-cell jsgrid-align-center"><?= $value->plan; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center status<?=$value->sid ?>"><?= $order_status_name; ?> </td>
                <td class="jsgrid-cell jsgrid-align-center tb-action<?=$value->sid ?>">
                    <?php if($order_flag == '1'){ ?>
                    <button class="btn btn-sm btn-success">Order generated</button>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Product ( <?=$value->product_name?> )" data-url="<?=$update_status_url?><?=$value->sid?>/<?=$order_status_id;?>" >
                        <i class="fa fa-edit"></i>
                        </a>
                    <?php } else {?>
                        <button class="btn btn-sm btn-primary order_button<?=$value->sid ?>" onclick="create_subscription_order(<?=$value->sid;?>,'<?=$to_date;?>',<?=$value->status_id;?>)">Generate order</button>
                    <?php }?>
                    
                </td>
                
            </tr> 

      <?php  }
        }} ?>    

        </table>

    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($subscriptions)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<?php } ?>
<script type="text/javascript">
   function filter_subscription()
   {
    var to_date = $("#to_date").val();
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var d = new Date(to_date);
    var dayName = days[d.getDay()];
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    // var to_date = $("#to_date").val();
    var time_slot_id = $("#delivery_slot").val();
    var plan_type_id = $("#plan_type").val();
    var user_id = $("#user_id").val();
    var product_id = $("#product_id").val();
    var status_id = $("#status_id").val();
    var address_id = $("#address_id").val();
    $.ajax({
        url: "<?php echo base_url('subscriptions/tb'); ?>",
        method: "POST",
        data: {
            to_date:to_date,
            time_slot_id:time_slot_id,
            plan_type_id:plan_type_id,
            user_id:user_id,
            product_id:product_id,
            status_id:status_id,
            address_id:address_id,
        },
        success: function(data){
            $("#tb").html(data);
            $(".day_name").html('('+dayName+')');
        },
    });
   }
   function filter_by_plan_type(plan_type_id)
   {
    
    if(document.getElementById('to_date').value == 0)
    {
        alert('Please Select Date');
        document.getElementById('to_date').focus();
        $('#plan_type').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var to_date = $("#to_date").val();
    var time_slot_id = $("#delivery_slot").val();
    var user_id = $("#user_id").val();
    var product_id = $("#product_id").val();
    var status_id = $("#status_id").val();
    var address_id = $("#address_id").val();
    $.ajax({
        url: "<?php echo base_url('subscriptions/tb'); ?>",
        method: "POST",
        data: {
            plan_type_id:plan_type_id,
            to_date:to_date,
            time_slot_id:time_slot_id,
            user_id:user_id,
            status_id:status_id,
            address_id:address_id,
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
   function filter_by_delivery_slot(time_slot_id)
   {

    if(document.getElementById('to_date').value == 0)
    {
        alert('Please Select Date');
        document.getElementById('to_date').focus();
        $('#delivery_slot').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var to_date = $("#to_date").val();
    var plan_type_id = $("#plan_type").val();
    var user_id = $("#user_id").val();
    var product_id = $("#product_id").val();
    var status_id = $("#status_id").val();
    var address_id = $("#address_id").val();
    $.ajax({
        url: "<?php echo base_url('subscriptions/tb'); ?>",
        method: "POST",
        data: {
            time_slot_id:time_slot_id,
            plan_type_id:plan_type_id,
            to_date:to_date,
            user_id:user_id,
            product_id:product_id,
            status_id:status_id,
            address_id:address_id,
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
   function filter_by_customer(user_id)
   {
    if(document.getElementById('to_date').value == 0)
    {
        alert('Please Select Date');
        document.getElementById('to_date').focus();
        $('#delivery_slot').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var to_date = $("#to_date").val();
    var plan_type_id = $("#plan_type").val();
    var time_slot_id = $("#delivery_slot").val();
    var product_id = $("#product_id").val();
    var status_id = $("#status_id").val();
    var address_id = $("#address_id").val();
    $.ajax({
        url: "<?php echo base_url('subscriptions/tb'); ?>",
        method: "POST",
        data: {
            time_slot_id:time_slot_id,
            plan_type_id:plan_type_id,
            to_date:to_date,
            user_id:user_id,
            product_id:product_id,
            status_id:status_id,
            address_id:address_id,
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
   function filter_by_product(product_id)
   {
    if(document.getElementById('to_date').value == 0)
    {
        alert('Please Select Date');
        document.getElementById('to_date').focus();
        $('#delivery_slot').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var to_date = $("#to_date").val();
    var plan_type_id = $("#plan_type").val();
    var time_slot_id = $("#delivery_slot").val();
    var user_id = $("#user_id").val();
    var status_id = $("#status_id").val();
    var address_id = $("#address_id").val();
    $.ajax({
        url: "<?php echo base_url('subscriptions/tb'); ?>",
        method: "POST",
        data: {
            time_slot_id:time_slot_id,
            plan_type_id:plan_type_id,
            to_date:to_date,
            user_id:user_id,
            product_id:product_id,
            status_id:status_id,
            address_id:address_id,
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
   function filter_by_status(status_id)
   {
    if(document.getElementById('to_date').value == 0)
    {
        alert('Please Select Date');
        document.getElementById('to_date').focus();
        $('#delivery_slot').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var to_date = $("#to_date").val();
    var plan_type_id = $("#plan_type").val();
    var time_slot_id = $("#delivery_slot").val();
    var user_id = $("#user_id").val();
    var product_id = $("#product_id").val();
    var address_id = $("#address_id").val();
    $.ajax({
        url: "<?php echo base_url('subscriptions/tb'); ?>",
        method: "POST",
        data: {
            time_slot_id:time_slot_id,
            plan_type_id:plan_type_id,
            to_date:to_date,
            user_id:user_id,
            product_id:product_id,
            status_id:status_id,
            address_id:address_id,
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
   function filter_by_pincode(address_id)
   {
    if(document.getElementById('to_date').value == 0)
    {
        alert('Please Select Date');
        document.getElementById('to_date').focus();
        $('#delivery_slot').prop('value',0);
        return false;
    }
    $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
    var to_date = $("#to_date").val();
    var plan_type_id = $("#plan_type").val();
    var time_slot_id = $("#delivery_slot").val();
    var user_id = $("#user_id").val();
    var product_id = $("#product_id").val();
    var status_id = $("#status_id").val();
    $.ajax({
        url: "<?php echo base_url('subscriptions/tb'); ?>",
        method: "POST",
        data: {
            time_slot_id:time_slot_id,
            plan_type_id:plan_type_id,
            to_date:to_date,
            user_id:user_id,
            product_id:product_id,
            status_id:status_id,
            address_id:address_id,
        },
        success: function(data){
            $("#tb").html(data);
        },
    });
   }
   function create_subscription_order(sid,selected_date,status_id)
   {
    if(confirm('Are you sure?') == true)
    {
        $.ajax({
            url: "<?php echo base_url('subscriptions/create_subscription_order'); ?>",
            method: "POST",
            data: { sid:sid,selected_date:selected_date,status_id:status_id
            },
            success: function(data){
                $('.tb-action'+sid).html(data);
                $('.status'+sid).html('Order Placed');
                // $(".order_button"+sid).html('Order generated');
                // $(".order_button"+sid).removeAttr('onclick');
                // $(".order_button"+sid).removeClass('btn-primary');
                // $(".order_button"+sid).addClass('btn-success');
                
            },
        });
    }
   }
   $('#reset-data').click(function(){
        location.reload();
    })
</script>
<script>
       function update_order_status(sid)
        {
            var to_date = $("#to_date").val();
            var time_slot_id = $("#delivery_slot").val();
            var plan_type_id = $("#plan_type").val();
            var user_id = $("#user_id").val();
            var product_id = $("#product_id").val();
            var status_id = $("#status_id").val();
            var address_id = $("#address_id").val();
            if(confirm('Are you sure?') == true)
            {
                var order_status_id = $("#order-status option:selected").val();
                $.ajax({
                    url: "<?php echo base_url('subscriptions/update_order_status'); ?>",
                    method: "POST",
                    data: { 
                        sid:sid,
                        order_status_id:order_status_id,

                        to_date:to_date,
                        time_slot_id:time_slot_id,
                        plan_type_id:plan_type_id,
                        user_id:user_id,
                        product_id:product_id,
                        status_id:status_id,
                        address_id:address_id,
                    },
                    success: function(data){
                        $('#showModal').modal('hide');
                        $('#tb').html(data);
                        // $('.tb-action'+sid).html(data);
                        // // // $('.modal-body').html(data);
                        // // $('.status'+sid).html(data);
                        // toastr.success('Order Status Updated Successfully.');
                    },
                });
            }
        }
</script>


