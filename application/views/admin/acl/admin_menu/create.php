<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            description:"required",
            icon:"required",
            name:{
                required:true,
                remote:"<?=$remote?>null"
            }
        },
        messages: {
            description:"Please Enter Description!",
            icon:"Please Select Image!",
            name: {
                required : "Please enter name.",
                remote : "Category already exists!"
            }
        }
    }); 
});
</script>
<form class="ajaxsubmit needs-validation reload-page" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
<div class="modal-body">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Title:</label>
                <input type="text" class="form-control" name="title">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Icon class:</label>
                <input type="text" class="form-control" name="icon_class">
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="control-label">Parent Menu:</label>
                <select class="form-control select2" style="width:100%;" name="parent">
                <option value="0">--Select--</option>
                <?php foreach ($parent_menus as $parent) { ?>
                <option value="<?php echo $parent->id; ?>">
                    <?php echo $parent->title; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="control-label">Url:</label>
                <input type="text" class="form-control" name="url">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Indexing:</label>
                <input type="number" class="form-control" name="indexing">
            </div>
        </div>
        </div>
 
        

</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
</div>

</form>
  