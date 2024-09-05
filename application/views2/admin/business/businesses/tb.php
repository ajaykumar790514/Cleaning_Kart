<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($businesses)?> of <?=$total_rows?> entries</span>
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
            <select class="form-control select2 city" style="width:100%;" name="city" id="city" onchange="filter_business(this.value)">
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
    <div class="col-md-3">
        <input type="text" class="form-control mt-4" name="tb-search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search...">
    </div>
</div> -->

<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Title</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Owner Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Image</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Contact No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Alternative contact</th>
                <th class="jsgrid-header-cell jsgrid-align-center">DOB</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Email ID</th>
                <th class="jsgrid-header-cell jsgrid-align-center">State</th>
                <th class="jsgrid-header-cell jsgrid-align-center">City</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Address</th>
                <!-- <th class="jsgrid-header-cell jsgrid-align-center">Status</th> -->
                <!-- <th class="jsgrid-header-cell jsgrid-align-center">Actions</th> -->
            </tr>
            
            <?php $i=$page; foreach($businesses as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->title;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->owner_name;?></td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php if(!empty($value->pic)) { ?>
                        <img src="<?php echo IMGS_URL.$value->pic; ?>" alt="cover" height="50">
                    <?php } else {?>
                        <img src="<?php echo IMGS_URL.'application/photo/avatar.png'; ?>" alt="cover" height="50">
                        <?php } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->owner_contact;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->alter_contact;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->dob;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->email;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->state_name;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->city_name;?></td>
                <td class="jsgrid-cell jsgrid-align-left"><?php echo $value->address;?></td>
                <!-- <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                    <?php if($value->status==1) { ?>
                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                    <?php } else {?>
                    <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                    <?php }?>
                </td> -->
                <!-- <td class="jsgrid-cell jsgrid-align-center">
                    

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Business ( <?=$value->owner_name?> )" data-url="<?=$update_url?><?=$value->id?>" >
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="javscript:void(0)" onclick="delete_business(<?php echo $value->id;?>)"><i class="fa fa-trash"></i>
                    </a>
                    <a href="<?= base_url('shops/'.$value->id) ?>" title="Go to Shop"><i class="fa fa-arrow-right"></i>
                    </a>

                </td> -->
            </tr> 
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($businesses)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script>
    function delete_business(bid){
        if(confirm('Do you want to delete?') == true)
        {
            $('#tb').load("<?php echo base_url('businesses/delete_business/')?>"+bid );
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
   function filter_business(city_id)
   {
    var search = $('#tb-search').val();
    var state_id = $('#state').val();
        $.ajax({
            url: "<?php echo base_url('businesses/tb'); ?>",
            method: "POST",
            data: {
                state_id:state_id, 
                city_id:city_id, 
                search:search,  
            },
            success: function(data){
                $("#tb").html(data);
            },
        });
        
   }
   function change_status(id)
    {
        alert('By disabling / enabling business all shops status will change accordingly');
        if(confirm('Are you sure?') == true)
        {
            $.ajax({
                url: "<?php echo base_url('business-store/change_business_status'); ?>",
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

