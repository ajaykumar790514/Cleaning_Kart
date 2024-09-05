<style>
    .fa {
    margin-left: -12px;
    margin-right: 8px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $(".needs-validation").validate({
            rules: {
                title:"required",
                photo:"required",
                description:"required",
                meta_keyword:"required",                 
                meta_description:"required",              
            },
        }); 
    });
</script>

<form class="ajaxsubmit needs-validation reload-tb" action="<?=$action_url?>" method="post" enctype= multipart/form-data>
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Title:</label>
                    <input type="text" class="form-control" name="title">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Photo</label>
                    <input type="file" class="form-control" name="photo">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Priority:</label>
                    <select class="form-control select2" style="width:100%;" name="priority">
                        <option value="">--Select--</option>
                        <option value="0.3">Low</option>
                        <option value="0.7">Medium</option>
                        <option value="1.0">High</option>
                    
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Meta Keyword:</label>
                    <input type="text" class="form-control" name="meta_keyword">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Meta Description:</label>
                    <input type="text" class="form-control" name="meta_description">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <label class="control-label">Description:</label>
                    <textarea id="textarea1" cols="92" rows="5" class="form-control" name="description"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        <button id="btnsubmit" type="submit" class="btn btn-danger waves-light" ><i id="loader" class=""></i>Add</button>
    </div>
</form>
        
