<style>
.more {display: none;}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            business_id: { required : true },
            shop_id   : { required : true },
            cancellation_content   : { required : true }
        },
        messages: {
            business_id: { required : "Please select business!" },
            shop_id   : { required : "Please select shop!" },
            cancellation_content   : { required : "Please enter cancellation content!" }
        }
    }); 
});
</script>
<table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Shop Name</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Cancellation Content</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($cancellation_data as $val) {?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $val->shop_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <?php $desc = strip_tags( $val->cancellation_content);
    $desc = substr($desc,0,15); ?>
   <span id="less<?php echo $val->id;?>"><?php echo $desc; ?></span><span id="dots<?php echo $val->id;?>">...</span><span id="more<?php echo $val->id;?>" class="more"><?php echo $val->cancellation_content;?></span>   
    <button class="btn btn-primary btn-sm" onclick="myFunction(<?php echo $val->id;?>)" id="myBtn<?php echo $val->id;?>">Read more</button> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                            <input type="hidden" value="<?= $pid?>" id="pid"> 
                                                            <input type="hidden" id="prodcancellation<?=$val->id?>" value="<?=$val->cancellation_content?>" />            
                <a href="javscript:void(0)" id="editbtn" onclick="edit_cancellation('<?=$val->id; ?>','<?=$val->shop_id; ?>','<?=$val->business_id; ?>')"><i class="fa fa-edit"></i>
                </a>
                <a href="javscript:void(0)" onclick="delete_cancellation(<?php echo $val->id;?>)"><i class="fa fa-trash"></i>
                </a>
                
               
                                                    </td>
                                                </tr>
                                                <?php }?>
                                                     
                                                </table>
<form class="ajaxsubmit needs-validation" method="post">

    <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label class="control-label">Business:</label>
            <select class="form-control select2" style="width:100%;" name="business_id" id="business_id" onchange="fetch_shop(this.value)">
            <option value="">Select Business</option>
            <?php foreach ($business as $busi) { ?>
            <option value="<?php echo $busi->id; ?>">
                <?php echo $busi->title; ?>(<?php echo $busi->owner_name; ?>)
            </option>
            <?php } ?>
            </select>
        </div>
        </div>
        <div class="col-6">
        <div class="form-group">
            <label class="control-label">Shop:</label>
            <select class="form-control shop_id" style="width:100%;" name="shop_id" id="shop_id">
            
            </select>
        </div>
    </div>
    
    <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Cancellation Content:</label>
                    <textarea id="cancellation_content" cols="92" rows="5" class="form-control" name="cancellation_content"></textarea>
                </div>
            </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" onclick="add_cancellation(<?= $pid;?>)"><i id="loader" class=""></i>Add</button>
        <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" id="add" /> -->
        <input type="button" class="btn btn-danger waves-light" value="Update" id="update" hidden />
    </div>
    </div>
</form>

<script>
    function delete_cancellation(pcid){
        if(confirm('Do you want to delete?') == true)
        {
            $('#showModal .modal-body').load("<?php echo base_url('master-data/products/delete_cancellation/')?>"+pcid+"/"+<?=$pid?> );
            toastr.success('Cancellation Deleted Successfully..');
        }
    }
</script>
<script>
    function myFunction(id) {
        // alert(id);
    var dots = document.getElementById("dots"+id);
    var moreText = document.getElementById("more"+id);
    var lessText = document.getElementById("less"+id);
    var btnText = document.getElementById("myBtn"+id);

    if (dots.style.display === "none") {
        dots.style.display = "inline";
        btnText.innerHTML = "Read more"; 
        moreText.style.display = "none";
        lessText.style.display = "inline";
    } else {
        dots.style.display = "none";
        btnText.innerHTML = "Read less"; 
        moreText.style.display = "inline";
        lessText.style.display = "none";
    }
    }
</script>

<script>
    function edit_cancellation(id,shop_id,business_id){
        prodcancellation=$('#prodcancellation'+id).val();
        $('#business_id').val(business_id);
        $('#cancellation_content').val(prodcancellation);
        var pid = $('#pid').val();
        
        $('#btnsubmit').hide();
        $("#update").prop('hidden', false);
        $("#shop_id").prop('disabled', true);
        $("#business_id").prop('disabled', true);
        $("#update").click(function(){
            var cancellation_content = $('#cancellation_content').val();

                $.ajax({
                    url: "<?php echo base_url('master-data/products/edit_cancellation'); ?>",
                    method: "POST",
                    data: {
                        id:id,
                        cancellation_content:cancellation_content,
                        pid:pid
                    },
                    success: function(data){
                        $("#showModal .modal-body").html(data);
                        toastr.success('Cancellation Updated Successfully..');
                    },
                });
        });
    }
</script>
<script>
    function add_cancellation(pid){
        var shop_id = $('#shop_id').val();
        var cancellation_content = $('#cancellation_content').val();
        
            var cancellation_content = $('#cancellation_content').val();

                $.ajax({
                    url: "<?php echo base_url('master-data/products/add-cancellation'); ?>",
                    method: "POST",
                    data: {
                        shop_id:shop_id,
                        cancellation_content:cancellation_content,
                        pid:pid
                    },
                    success: function(data){
                            $("#showModal .modal-body").html(data);
                    },
                });
    }
    <?php if($flag=='1'){?> toastr.error('Cancellation Content is already there. First Remove it..'); <?php }else if($flag=='0'){?> toastr.success('Cancellation Added Successfully..'); 
    <?php }?>
</script>