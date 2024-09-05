<form class="ajaxsubmit needs-validation reload-page">
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Reward Point:</label>
                <input type="number" class="form-control" name="rewards" id="rewards">
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" onclick="add_reward_point(<?= $cust_id; ?>)"><i id="loader" class=""></i>Add</button>
</div>
<input type="hidden" value="<?= $admin_reward; ?>" id="admin_reward">
<input type="hidden" value="<?= $cust_reward; ?>" id="cust_reward">
</form>

<script>
    function add_reward_point(cust_id) {
        var rewards = $("#rewards").val();
        var admin_reward = $("#admin_reward").val();
        var cust_reward = $("#cust_reward").val();
        if(parseInt(rewards) > parseInt(admin_reward))
        {
            toastr.error('Reward Point should be less than '+admin_reward);
            return;
        }
        else if(rewards == '0')
        {
            toastr.error('Reward Point should be grater than 0');
            return;
        }
        $.ajax({
        url: "<?php echo base_url('customers-acquisition/add_reward_point'); ?>",
        method: "POST",
        data: {
            cust_id:cust_id,
            rewards:rewards,
            cust_reward:cust_reward,
        },
        success: function(data){
            toastr.success('Reward Added Successfully..');
            $("#showModal").modal('hide');
            $("#reward_point"+cust_id).html(data);
        },
    });
}
</script>