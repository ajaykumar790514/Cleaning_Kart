
<form class="ajaxsubmit reload-page" action="<?=$action_url?>" method="post">

<div class="modal-body">
    
    <div class="row">
    <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Site Key</label>
                    <input type="text" class="form-control" name="site_key" value="<?= $value->site_key;?>">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="control-label">Secret Key</label>
                    <input type="text" class="form-control" name="secret_key" value="<?= $value->secret_key;?>">
                </div>
            </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    <button id="btnsubmit" type="submit" class="btn btn-primary waves-light" ><i id="loader" class=""></i>Update</button>
</div>

</form>