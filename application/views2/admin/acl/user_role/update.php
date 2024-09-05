<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            description:"required",
            seq:"required",
            name:{
                required:true,
            }
        },
        messages: {
            description:"Please Enter Description!",
            seq:"Please Enter Sequence!",
            name: {
                required : "Please enter name.",
            }
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Name:</label>
                <input type="text" class="form-control" name="name" value="<?= $value->name ?>">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea class="form-control" name="description" rows="4" cols="50"><?= $value->description ?></textarea>
            </div>
        </div>  
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Update</button>
    </div>

</form>
