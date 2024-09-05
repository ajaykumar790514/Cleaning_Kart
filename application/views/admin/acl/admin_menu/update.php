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
<div class="col-6">
            <div class="form-group">
                <label class="control-label">Title:</label>
                <input type="text" class="form-control" name="title" value="<?= $value->title; ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="control-label">Icon class:</label>
                <input type="text" class="form-control" name="icon_class" value="<?= $value->icon_class; ?>">
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="control-label">Parent Menu:</label>
                <select class="form-control select2" style="width:100%;" name="parent">
                <option value="<?= $value->parent; ?>">--Select--</option>
                <?php foreach ($parent_menus as $parent) { ?>
                    <option value="<?= $parent->id; ?>" <?php if($parent->id == $value->parent){echo "selected";}?>>
                    <?php echo $parent->title; ?>
                </option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="control-label">Url:</label>
                <input type="text" class="form-control" name="url" value="<?= $value->url; ?>">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Indexing:</label>
                <input type="number" class="form-control" name="indexing" value="<?= $value->indexing; ?>">
            </div>
        </div>
            
    </div>



<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <!-- <input type="submit" class="btn btn-primary waves-light" type="submit" value="UPDATE"> -->
    <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Update</button>

</div>

</form>