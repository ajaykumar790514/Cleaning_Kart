<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($products)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <div class="col-md-4" style="float: left; margin: 12px 0px;">
        </div>
        <div class="col-md-8 text-right" style="float: left;">
            <?=$links?>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-3">
            <div class="form-group">
            <label class="control-label">Parent Categories:</label>
            <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_sub_categories(this.value)">
            <option value="">Select</option>
            <?php foreach ($parent_cat as $parent) { ?>
            <option value="<?php echo $parent->id; ?>" <?php if(!empty($parent_id)) { if($parent_id==$parent->id) {echo "selected"; } }?>>
                <?php echo $parent->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Sub Categories:</label>
                
                <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" value="<?=$cat_id?>" onchange="fetch_products(this.value)">
                    <?php if($cat_id!=='null') { ?>
                        <?php foreach ($sub_cat as $scat) { ?>
                        <option value="<?php echo $scat->id; ?>" <?php if(!empty($cat_id)) { if($cat_id==$scat->id) {echo "selected"; } }?>>
                            <?php echo $scat->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>                                  
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Categories:</label>
                
                <select class="form-control child_cat_id" style="width:100%;" name="cat_id" id="cat_id" value="<?=$cat_id?>" onchange="fetch_products_by_cat(this.value)">
                    <?php if($child_cat_id!=='null') { ?>
                        <?php foreach ($child_cat as $ccat) { ?>
                        <option value="<?php echo $ccat->id; ?>" <?php if(!empty($child_cat_id)) { if($child_cat_id==$ccat->id) {echo "selected"; } }?>>
                            <?php echo $ccat->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>                                  
                </select>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Search:</label>
                <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?php if($search!='null'){echo $search;}?>" placeholder="Search...">
            </div>
        </div>
        <div class="col-3 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
            </div>
        </div>
</div>
<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Image</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Search Keyword</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Quantity</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Description</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
            
            <?php $i=$page; foreach($products as $value){ ?>
            <tr class="jsgrid-filter-row">
                <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                <td class="jsgrid-cell jsgrid-align-center">
                
                <?php if($value->is_cover == '1'){ ?>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$value->name?>" data-url="<?=$image_url?><?=$value->cover_id?>" >
                        <img src="<?php echo IMGS_URL.$value->thumbnail; ?>" alt="cover" height="50">
                    </a>
                <?php  } ?>

                </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <?php foreach ($categories as $cat) {
                        if($cat->id == $value->parent_cat_id){
                            echo $cat->name;;
                        } 
                    } ?>
                </td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->name;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->search_keywords;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->product_code;?></td>
                <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->unit_value;?> <?php echo $value->unit_type;?></td>
                <td class="jsgrid-cell jsgrid-align-left">
                                                        <?php $desc = strip_tags( $value->description);
        $desc = substr($desc,0,15);
        echo $desc; ?>
        <?php if(strlen($value->description) > 15){ ?> 
        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $value->id; ?>">Read More</button>
        <?php } ?>
        
                                                        </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    <a title="Product Flags" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Product Flags ( <?=$value->name?> )" data-url="<?=$pf_url?><?=$value->id?>" >
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    <a title="Subscription plan type" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Subscription plan type ( <?=$value->name?> )" data-url="<?=$plan_type_url?><?=$value->id?>" >
                        <i class="fa fa-plus"></i>
                    </a>
                </td>
            </tr> 
            <!--Read Description modal-->
            <div id="read-desc<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog  modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b>Description</b>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <?php echo $value->description; ?>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
        <!--/Read Description modal-->
            <?php } ?>    
        </table>

            
    </div>
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($products)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script type="text/javascript">
   function fetch_products(cat_id)
   {
    var parent_id = $('#parent_id').val();
    var search = $('#tb-search').val();
    $.ajax({
        url: "<?php echo base_url('shop-master-data/product_flags/tb'); ?>",
        method: "POST",
        data: {
            cat_id:cat_id,
            parent_id:parent_id,
            search:search
        },
        success: function(data){
            $("#tb").html(data);
            //ajax method for loading main categories
            var parent_cat_id = $('#parent_cat_id').val();
            $.ajax({
                url: "<?php echo base_url('shop-master-data/fetch_cat'); ?>",
                method: "POST",
                data: {
                    parent_cat_id:parent_cat_id
                },
                success: function(data){
                    $(".child_cat_id").html(data);
                },
            });
        },
    });
   }
   function fetch_products_by_cat(child_cat_id)
   {
    var parent_id = $('#parent_id').val();
    var search = $('#tb-search').val();
    var parent_cat_id = $('#parent_cat_id').val();
        $.ajax({
            url: "<?php echo base_url('shop-master-data/product_flags/tb'); ?>",
            method: "POST",
            data: {
                child_cat_id:child_cat_id,
                parent_id:parent_id,
                search:search,
                cat_id:parent_cat_id,
            },
            success: function(data){
                $("#tb").html(data);
               
            },
        });
        
   }
   function fetch_sub_categories(parent_id)
   {
    $.ajax({
        url: "<?php echo base_url('shop-master-data/fetch_sub_categories'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id //cat1 id
        },
        success: function(data){
            $(".parent_cat_id").html(data);

            var cat_id = $('#parent_cat_id').val(); //cat2 id
            if(parent_id == '')
            {
                $.ajax({
                    url: "<?php echo base_url('shop-master-data/product_flags/tb'); ?>",
                    method: "POST",
                    data: {
                        cat_id:cat_id,
                        parent_id:parent_id,
                    },
                    success: function(data){
                    $("#tb").html(data);
                    },
                });
            }
        },
    });
   };
</script>
