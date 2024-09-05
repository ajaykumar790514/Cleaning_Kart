<div class="modal-header">
    <b>Add Header Items</b>
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
    <form class="needs-validation" action="" method="post">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                <label class="control-label">Parent Categories:</label>
                <select class="form-control select2" style="width:100%;" name="parent_id" onchange="fetch_category(this.value)">
                <option value="">Select</option>
                <?php foreach ($parent_cat as $parent) { ?>
                <option value="<?php echo $parent->id; ?>">
                    <?php echo $parent->name; ?>
                </option>
                <?php } ?>
                </select>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                <label class="control-label">Categories:</label>
                <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_products(this.value)">
                </select>                                                     
                        
                </div>
                <input type="hidden" value="<?php echo $headerid; ?>" id="headerid">
        
            </div>
            <div class="col-12" id="available_products">
                
            </div>
        </div>
    </form>
    
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
</div>
                                                            