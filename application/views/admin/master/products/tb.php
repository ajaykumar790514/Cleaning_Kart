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
</div>
<div id="datatable">
    <div id="grid_table">
        <table class="jsgrid-table">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete Selected</button></th>
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Image</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Category</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Search Keyword</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Code</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Product Quantity</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Description</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
            
            <?php $i=$page; foreach($products as $value){ ?>
            <tr class="jsgrid-filter-row">
                <td class="jsgrid-cell jsgrid-align-center">
                    <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                    <label for="multiple_delete<?= $value->id; ?>"></label>
                </td>
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
                            echo $cat->name;
                        } 
                        if($cat->id == $value->sub_cat_id){
                            echo '('.$cat->name.')';
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
                <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                            <?php if($value->active==1) { ?>
                                                        <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                        <?php } else {?>
                                                            <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                            <?php }?>
                                                        </td>
                <td class="jsgrid-cell jsgrid-align-center">
                    

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Product ( <?=$value->name?> )" data-url="<?=$update_url?><?=$value->id?>" >
                        <i class="fa fa-edit"></i>
                    </a>

                    <a href="javscript:void(0)" onclick="delete_product(<?php echo $value->id;?>)"><i class="fa fa-trash"></i>
                    </a>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Property value ( <?=$value->name?> )" data-url="<?=$pv_url?><?=$value->id?>" >
                        <i class="fa fa-plus"></i>
                    </a>

                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Property Images ( <?=$value->name?> )" data-url="<?=$pimg_url?><?=$value->id?>" ><i class="fa fa-image"></i></a>

                    <a title="Product Flags" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Product Flags ( <?=$value->name?> )" data-url="<?=$pf_url?><?=$value->id?>" >
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    <a title="Subscription plan type" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Subscription plan type ( <?=$value->name?> )" data-url="<?=$plan_type_url?><?=$value->id?>" >
                        <i class="fa fa-plus-circle"></i>
                    </a>
                    <a title="Product Mapping" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Map Products ( <?=$value->name?> )" data-url="<?=$map_url?><?=$value->id?>" >
                        <i class="fa fa-plus"></i>
                    </a>
                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Duplicate Product ( <?=$value->name?> )" data-url="<?=$duplicate_url?><?=$value->id?>" title="Duplicate Product">
                        <i class="fa fa-copy"></i>
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
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('master-data/change_product_status'); ?>",
        method: "POST",
        data: {
            id:id
        },
        success:function(data){
            $("#status"+id).html(data);
        }
    });
    }

</script>
<script>
    function delete_product(pid){
        if(confirm('Do you want to delete?') == true)
        {
            $('#tb').load("<?php echo base_url('master-data/products/delete_product/')?>"+pid );
            toastr.success('Product Deleted Successfully..')
        }
    };

</script>
<script type="text/javascript">
   function fetch_products(cat_id)
   {
    var parent_id = $('#parent_id').val();
    var search = $('#tb-search').val();
        $.ajax({
            url: "<?php echo base_url('master-data/products/tb'); ?>",
            method: "POST",
            data: {
                cat_id:cat_id,  //cat2 id
                parent_id:parent_id,    //cat1 id
                search:search,
            },
            success: function(data){
                $("#tb").html(data);
                //ajax method for loading child categories
                var parent_cat_id = $('#parent_cat_id').val();
                    $.ajax({
                        url: "<?php echo base_url('master-data/fetch_cat'); ?>",
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
            url: "<?php echo base_url('master-data/products/tb'); ?>",
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
   $('.delete_checkbox').click(function(){
        if($(this).is(':checked'))
        {
        $(this).closest('tr').addClass('removeRow');
        }
        else
        {
        $(this).closest('tr').removeClass('removeRow');
        }
    });
   $('#delete_all').click(function(){
        var checkbox = $('.delete_checkbox:checked');
        var table = 'products_subcategory';
            if(checkbox.length > 0)
            {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>master/multiple_delete",
                method:"POST",
                data:{checkbox_value:checkbox_value,table:table},
                success:function()
                {
                    $('.removeRow').fadeOut(1500);
                }
            })
            }
            else
            {
            alert('Select atleast one record');
            }
   })
</script>