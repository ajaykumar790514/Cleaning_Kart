<form class="ajaxsubmit needs-validation" method="post" action="<?=$action_url?>">

    <div class="row">
       

    <div class="col-6">
        <div class="form-group">
            <label class="control-label">Delivery Period:</label>
            <input type="text" class="form-control" name="delivery_period" id="delivery_period" value="<?php if(!empty($flags)){echo $flags->delivery_period;}?>">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label class="control-label">Cancellation Period (In Days):</label>
            <input type="number" class="form-control" name="cancellation_period" id="cancellation_period" value="<?php if(!empty($flags)){echo $flags->cancellation_period;}?>">
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="control-label">Cancellation Content:</label>
            <textarea id="cancellation_content" cols="92" rows="5" class="form-control" name="cancellation_content"><?php if(!empty($flags)){echo $flags->cancellation_content;}?></textarea>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <input type='checkbox' name='is_cod' id="is_cod" <?php if(!empty($flags)) {if($flags->is_cod == '1' ){echo "checked";} } ?>>
        <label for="is_cod">COD</label>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <input type='checkbox' name='is_cancellation' id="is_cancellation" <?php if(!empty($flags)) {if($flags->is_cancellation == '1' ){echo "checked";} } ?>/>
        <label for="is_cancellation">Cancellation</label>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <input type='checkbox' name='is_featured' id="is_featured" <?php if(!empty($flags)) {if($flags->is_featured == '1' ){echo "checked";} } ?>/>
        <label for="is_featured">Featured</label>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <input type="hidden" class="form-control" name="pid" value="<?= $pid; ?>">
        </div>
    </div>
    
    </div>
    
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <?php if(!empty($flags)){ ?>
        <button id="editbtn" type="button" class="btn btn-danger waves-light" onclick="edit_flags(<?= $pid; ?>)"><i id="loader" class=""></i>Update</button>
        <?php } else { ?>
            <button id="btnsubmit" type="submit" class="btn btn-danger waves-light"><i id="loader" class=""></i>Add</button>

        <?php }?>
    </div>
    </div>
</form>


<script>
    function edit_flags(pid){
        if($("#is_cod").prop("checked") == true)
        {
            var is_cod = 1;
        }
        else
        {
            var is_cod = 0;
        }
        if($("#is_cancellation").prop("checked") == true)
        {
            var is_cancellation = 1;
        }
        else
        {
            var is_cancellation = 0;
        }
        if($("#is_featured").prop("checked") == true)
        {
            var is_featured = 1;
        }
        else
        {
            var is_cod = 0;
        }
        var delivery_period = $('#delivery_period').val();
        var cancellation_period = $('#cancellation_period').val();
        var cancellation_content = $('#cancellation_content').val();
        $.ajax({
            url: "<?php echo base_url('shop-master-data/product_flags/edit-flags'); ?>",
            method: "POST",
            data: {
                pid:pid,
                is_cod:is_cod,
                is_cancellation:is_cancellation,
                is_featured:is_featured,
                delivery_period:delivery_period,
                cancellation_period:cancellation_period,
                cancellation_content:cancellation_content,
            },
            success: function(data){
                $("#showModal").modal('hide');
                // $("#showModal .modal-body").html(data);
                toastr.success('Updated Successfully..');
            },
        });
    }
</script>