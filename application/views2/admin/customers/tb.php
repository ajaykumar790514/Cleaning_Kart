<style>
.fa {
  margin-left: -12px;
  margin-right: 8px;
}
</style>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($customers)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
            <!-- <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?=$search?>" placeholder="Search..."> -->
        </div>
        <!-- <div class="col-md-8 text-right" style="float: left;">
            <?=$links?>
        </div> -->
        <div class="col-md-8" style="float: left; margin: 12px 0px;">
            <a class="btn btn-primary " data-toggle="modal" href="#" data-target="#send-notification" >Send Notification</a>
        </div>
        
        <div id="send-notification" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                    
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Send Notifications</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            
                                                            <h4 class="text-success text-left ml-3 mt-3" id="successmsg"></h4>
                                                            <div class="modal-body">
                                                                    
                                                            <form action="" method="post">
                                                            
                                                                    <div class="row">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label" style="float:left;">Title</label>
                                                                                <input type="text" class="form-control" name="title" id="title">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label" style="float:left;">Description</label>
                                                                                <textarea id="body" cols="90" rows="5" name="body" id="body"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                             
                                                            
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <!-- <input type="button" class="btn btn-primary waves-light" type="submit" value="Send to All" onclick="send_notifications()"> -->
                                                                <button id="btnsubmit" class="btn btn-primary" onclick="send_notifications()">
  <i id="loader" class=""></i>Send To All
</button>
                                                            </div>
                                                            
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
    </div>
</div>
<div class="row">
        <div class="col-3">
            <div class="form-group">
            <label class="control-label">From date:</label>
            <input type="date" class="form-control" name="from_date" id="from_date" value="<?=$from_date?>">
            </div>
            <div id="msg"></div>
        </div>

        <div class="col-3">
            <div class="form-group">
            <label class="control-label">To date:</label>
            <input type="date" class="form-control" name="to_date" id="to_date" value="<?=$to_date?>" onchange="filter_customers(this.value)">
           
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
            <label class="control-label">Search:</label>
                <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?php if($search!=='null'){echo $search;}?>" placeholder="Search...">
           
            </div>
        </div>
        <div class="col-3 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
</div>
<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Customer Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Gender</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Mobile</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Email</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Address</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Photo</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Date/Time</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Rewards</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Action</th>
            </tr>
            
            <?php $i=$page; foreach($customers as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->fname .' '.$value->lname;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->gender;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->mobile;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->email;?></td>
                <td class="jsgrid-cell jsgrid-align-center">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Customer Address ( <?=$value->fname.' '.$value->lname;?>  )" data-url="<?=$address_url?><?=$value->mobile?>" >
                        <i class="fa fa-address-card"></i>
                    </a>
                </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php if(!empty($value->photo)) { ?>
                        <img src="<?php echo IMGS_URL.$value->photo; ?>" alt="profile" height="50">
                    <?php } else {?>
                        <img src="<?php echo IMGS_URL.'avatar.png'; ?>" alt="cover" height="50">
                        <?php } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo date('Y-m-d H:i',strtotime($value->added));?></td>
                <td class="jsgrid-cell jsgrid-align-center" id="reward_point<?= $value->id; ?>"><?php echo $value->rewards;?></td>
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <?php if($value->isActive==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                    <?php }?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Add Reward Points ( <?=$value->fname?> )" data-url="<?=$reward_url?><?=$value->id?>" title="Add Reward Points">
                        <i class="fa fa-plus"></i>
                    </a>
                </td>
            </tr> 
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($customers)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('customers-acquisition/change_cust_status/'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
    });
    }
</script>

<script>
    function send_notifications()
    {
        var element = document.getElementById("loader");
        element.className = 'fa fa-spinner fa-spin';
        $("#btnsubmit").prop('disabled', true);
        var title = $("#title").val();
        var body = $("#body").val();

        $.ajax({
        url: "<?php echo base_url('customers-acquisition/send_notifications'); ?>",
        method: "POST",
        data: {
            title:title,
            body:body,
        },
        success:function(data){
            if(data)
            {
                var element = document.getElementById("loader");
                element.classList.remove("fa-spinner");
                $("#btnsubmit").prop('disabled', false);
                $("#successmsg").html(data);
            }
            
            // $("#showModal .modal-body").html(data);
        }
    });
    }
</script>
<script type="text/javascript">
   function filter_customers(to_date)
   {
    if(document.getElementById('from_date').value == 0)
    {
        alert('Please Select From Date');
        document.getElementById('from_date').focus();
        $('#to_date').prop('value',0);
        return false;
    }
    var from_date = $("#from_date").val();
    var search = $("#tb-search").val();
    if(from_date>=to_date)
    {
        msg = "From date should be less than to date";
        document.getElementById('msg').style.color='red';
        document.getElementById('msg').innerHTML=msg;
        return;
    }
    $.ajax({
        url: "<?php echo base_url('customers-acquisition/tb'); ?>",
        method: "POST",
        data: {
            from_date:from_date,
            to_date:to_date,
            search:search
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