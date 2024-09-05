<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            description:"required",
            name:{
                required:true,
                remote:"<?=$remote?>null"
            }
        },
        messages: {
            name: {
                remote : "Role already exists!"
            }
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Name:</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea class="form-control" name="description" rows="4" cols="50"></textarea>
            </div>
        </div>
        </div>
 
        

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>
            
