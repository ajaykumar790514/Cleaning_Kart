
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($shops)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
            <?=$links?>
    </div>
</div>
<!-- <div class="row">
    <div class="col-3">
        <div class="form-group">
            <label class="control-label">State:</label>
            <select class="form-control select2" style="width:100%;" name="state" id="state" onchange="fetch_city(this.value)">
            <option value="">Select State</option>
            <?php foreach ($states as $state) { ?>
            <option value="<?php echo $state->id; ?>" <?php if(!empty($state_id)) { if($state_id==$state->id) {echo "selected"; } }?>>
                <?php echo $state->name; ?>
            </option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="control-label">City:</label>
            <select class="form-control select2 city" style="width:100%;" name="city" id="city" onchange="filter_shops(this.value)">
            <?php if($city_id!=='null') { ?>
                        <?php foreach ($cities as $city) { ?>
                        <option value="<?php echo $city->id; ?>" <?php if(!empty($city_id)) { if($city_id==$city->id) {echo "selected"; } }?>>
                            <?php echo $city->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>          
            </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="control-label">Business:</label>
            <select class="form-control select2" style="width:100%;" name="business_id" id="business_id" onchange="filter_shop_by_business(this.value)">
            <option value="">--Select--</option>
            <?php foreach ($businesses as $business) { ?>
            <option value="<?php echo $business->id; ?>" <?php if(!empty($business_id)) { if($business_id==$business->id) {echo "selected"; } }?>>
                <?php echo $business->title; ?>
            </option>
            <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <input type="text" class="form-control mt-4" name="tb-search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search...">
    </div>
</div> -->
<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <!-- <th class="jsgrid-header-cell jsgrid-align-center">Shop Categories</th> -->
                <th class="jsgrid-header-cell jsgrid-align-center">Shop Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">State</th>
                <th class="jsgrid-header-cell jsgrid-align-center">City</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Pin Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Address</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Email ID</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Contact</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Delivery Range</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Description</th>
                <!-- <th class="jsgrid-header-cell jsgrid-align-center">Status</th> -->
                <!-- <th class="jsgrid-header-cell jsgrid-align-center">Actions</th> -->
            </tr>
            
            <?php $i=$page; foreach($shops as $value){ ?>
           
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <!-- <td class="jsgrid-cell jsgrid-align-center"><?php print_r($scat_id);?></td> -->
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->shop_name;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->state_name;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->city_name;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->pin_code;?></td>
                <td class="jsgrid-cell jsgrid-align-left">
                    <?php $addr = strip_tags( $value->address);
                        $addr = substr($addr,0,15);
                        echo $addr; ?>
                        <?php if(strlen($value->address) > 15){ ?> 
                        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-address<?php echo $value->id; ?>">Read More</button>
                    <?php } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->email;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->contact;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->delivery_range;?></td>
                <td class="jsgrid-cell jsgrid-align-left">
                <?php $desc = strip_tags( $value->description);
                $desc = substr($desc,0,15);
                echo $desc; ?>
                <?php if(strlen($value->description) > 15){ ?> 
                .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $value->id; ?>">Read More</button>
                <?php } ?>
                </td>
                <!-- <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <?php if($value->isActive==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                    <?php }?>
                </td> -->
                <!-- <td class="jsgrid-cell jsgrid-align-center">
                    

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Shop ( <?=$value->shop_name?> )" data-url="<?=$update_url?><?=$value->id?>" >
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="javscript:void(0)" onclick="delete_shop(<?php echo $value->id;?>)"><i class="fa fa-trash"></i>
                    </a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Shop Details ( <?=$value->shop_name;?>  )" data-url="<?=$details_url?><?=$value->id?>" >
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Shop Images ( <?=$value->shop_name?> )" data-url="<?=$simg_url?><?=$value->id?>" ><i class="fa fa-image"></i></a>
                </td> -->
            </tr> 
            <!--Read Address modal-->
            <div id="read-address<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <b>Address</b>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <?php echo $value->address; ?>
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
        <!--/Read Address modal-->
        <!--Read Description modal-->
        <div id="read-desc<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <b>Description</b>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <?php echo $value->description; ?>
                        </div>
                        <div class="modal-footer">
                            
                        </div>
                    </div>
                </div>
            </div>
        <!--/Read Description modal-->
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($shops)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>

<script>
    function delete_shop(shopid){
        if(confirm('Do you want to delete?') == true)
        {
            $.ajax({
                url: "<?php echo base_url('business-store/shops/delete_shop/'); ?>",
                method: "POST",
                data: {
                    shopid:shopid
                },
                success: function(data){
                    $("#tb").html(data);
                },
            });
        }
    }
</script>
<script type="text/javascript">
   function fetch_city(state)
   {
    $.ajax({
        url: "<?php echo base_url('business-store/fetch_city'); ?>",
        method: "POST",
        data: {
            state:state
        },
        success: function(data){
            $(".city").html(data);
        },
    });
   }
   function filter_shops(city_id)
   {
    var search = $('#tb-search').val();
    var state_id = $('#state').val();
    var business_id = $('#business_id').val();
        $.ajax({
            url: "<?php echo base_url('business-store/shops/tb'); ?>",
            method: "POST",
            data: {
                state_id:state_id, 
                city_id:city_id, 
                search:search,  
                business_id:business_id,  
            },
            success: function(data){
                $("#tb").html(data);
            },
        });
        
   }
   function filter_shop_by_business(business_id)
   {
    var search = $('#tb-search').val();
    var city_id = $('#city').val();
    var state_id = $('#state').val();
        $.ajax({
            url: "<?php echo base_url('business-store/shops/tb'); ?>",
            method: "POST",
            data: {
                state_id:state_id, 
                city_id:city_id, 
                search:search,  
                business_id:business_id,  
            },
            success: function(data){
                $("#tb").html(data);
            },
        });
        
   }
   function change_status(id)
    {
        if(confirm('Are you sure?') == true)
        {
            $.ajax({
                url: "<?php echo base_url('master-data/change_shop_status'); ?>",
                method: "POST",
                data: {
                    id:id
                },
                success:function(data){
                    $("#status"+id).html(data);
                }
            });
        }
    }

</script>
