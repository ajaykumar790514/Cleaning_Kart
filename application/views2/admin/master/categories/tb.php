<!-- <input type="text" id="tb-search" placeholder="enter product name"> -->

<div id="result">

</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($parent_cat)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<div class="row">
        <div class="col-3">
            <div class="form-group">
            <label class="control-label">Parent Categories:</label>
            <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" onchange="fetch_sub_categories(this.value)">
            <option value="">Select</option>
            <?php foreach ($parent_cat_list as $parent) { ?>
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
            <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" onchange="fetch_results(this.value)">
            <?php if(!empty($cat_id)) { ?>
            <?php foreach ($sub_cat as $scat) { ?>
            <option value="<?php echo $scat->id; ?>" <?php if(!empty($cat_id)) { if($cat_id==$scat->id) {echo "selected"; } }?>>
                <?php echo $scat->name; ?>
            </option>
            <?php } ?>
            <?php }?>                                            
            </select>
           
            </div>
        </div>
    </div>
<div id="grid_table">
    <table class="jsgrid-table" id="tab1">
            <tr class="jsgrid-header-row">
                <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                <th class="jsgrid-header-cell jsgrid-align-center cat_table_heading">Name</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Image</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Desc</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Sequence</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
            </tr>
        
            <?php
                                               $i=$page;
                                                foreach($parent_cat as $value)
                                                {
                                                    if($value->is_parent=="0")
                                                    {
                                                    ?>
        <tr class="jsgrid-filter-row">
                                                    <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                                                    <td class="jsgrid-cell"><strong class="float-left"><?php echo $value->name;?></strong> </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <?php if(!empty($value->thumbnail)) { ?>
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$value->name?>" data-url="<?=$image_url?><?=$value->id?>" >
                                                        <img src="<?php echo IMGS_URL.$value->thumbnail;?>" alt="<?php echo $value->name;?>" height="50" width="50">
                                                    </a>
                                                        <?php } ?> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-left"><?php $desc = strip_tags( $value->description);
    $desc = substr($desc,0,15);
    echo $desc; ?>
    <?php if(strlen($value->description) > 15){ ?>   
        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $value->id; ?>">Read More</button>
    <?php } ?>
    </td>
    
    <th class="jsgrid-cell jsgrid-align-center"><?php echo $value->seq;?></th>
    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                        <td class="jsgrid-cell jsgrid-align-center">
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category ( <?=$value->name?> )" data-url="<?=$update_url?><?=$value->id?>" >
                    <i class="fa fa-edit"></i>
                </a>

                <a href="<?php echo base_url('master-data/delete_category/'.$value->id); ?>" onclick="return confirm('Do you want to delete this?')">
                    <i class="fa fa-trash"></i>
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
    <?php
                                                 foreach($categories as $cat)
                                                 {
                                                        if($cat->is_parent==$value->id)
                                                        { ?>
                                                         <tr class="jsgrid-filter-row">
                                                    <th class="jsgrid-cell jsgrid-align-center"></th>
                                                    <td class="jsgrid-cell jsgrid-align-left"><p class="text-xs"><i class="fas fa-arrow-right ml-3"></i> <?php echo $cat->name;?> </p></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                  
                
                                                        <?php if(!empty($cat->thumbnail)) { ?>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$cat->name?>" data-url="<?=$image_url?><?=$cat->id?>" >
                                                            <img src="<?php echo IMGS_URL.$cat->thumbnail;?>" alt="<?php echo $cat->name;?>" height="50" width="50">
                                                            </a>
                                                        <?php } ?> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-left">
                                                    <?php $desc = strip_tags( $cat->description);
    $desc = substr($desc,0,15);
    echo $desc; ?>

    <?php if(strlen($cat->description) > 15){ ?>   
        .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $cat->id; ?>">Read More</button>
    <?php } ?>
    
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $cat->seq;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $cat->id; ?>">
                                                        <?php if($cat->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $cat->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $cat->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category ( <?=$cat->name?> )" data-url="<?=$update_url?><?=$cat->id?>" >
                    <i class="fa fa-edit"></i>
                </a>

                <a href="<?php echo base_url('master-data/delete_category/' . $cat->id); ?>" onclick="return confirm('Do you want to delete this?')">
                    <i class="fa fa-trash"></i>
                </a>
                                                    </td>
                                                    <!--Read Description modal-->
                                                <div id="read-desc<?php echo $cat->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Description</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php echo $cat->description; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    <!--/Read Description modal-->
    </tr> 
                                                      <?php 
                                                      
                                                      foreach($categories as $subcat)
                                                      {
                                                          if($subcat->is_parent == $cat->id)
                                                          { ?>
                                                              <tr class="jsgrid-filter-row">
                                                    <th class="jsgrid-cell jsgrid-align-center"></th>
                                                    <td class="jsgrid-cell jsgrid-align-left"><p class="text-xs"><i class="fas fa-arrow-right ml-5"></i> <?php echo $subcat->name;?> </p></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                  
                
                                                        <?php if(!empty($subcat->thumbnail)) { ?>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="<?=$subcat->name?>" data-url="<?=$image_url?><?=$subcat->id?>" >
                                                            <img src="<?php echo IMGS_URL.$subcat->thumbnail;?>" alt="<?php echo $subcat->name;?>" height="50" width="50">
                                                            </a>
                                                        <?php } ?> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-left">
                                                    <?php $desc = strip_tags( $subcat->description);
    $desc = substr($desc,0,15);
    echo $desc; ?>
    <?php if(strlen($subcat->description) > 15){ ?>   
    .... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $subcat->id; ?>">Read More</button>
    <?php } ?>
    
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $subcat->seq;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $subcat->id; ?>">
                                                        <?php if($subcat->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $subcat->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $subcat->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Update Category ( <?=$subcat->name?> )" data-url="<?=$update_url?><?=$subcat->id?>" >
                    <i class="fa fa-edit"></i>
                </a>

                <a href="<?php echo base_url('master-data/delete_category/' . $subcat->id); ?>" onclick="return confirm('Do you want to delete this?')">
                    <i class="fa fa-trash"></i>
                </a>
                                                    </td>
                                                    <!--Read Description modal-->
                                                <div id="read-desc<?php echo $subcat->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Description</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?php echo $subcat->description; ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
    <!--/Read Description modal-->
    </tr> 
                                                        <?php  }
                                                      }
                                                    }

                                                 }
                                                    }
                                                }
                                               ?>   
    </table>

        
</div>
<div class="row">
    <div class="col-md-6 text-left">
        <span>Showing <?=$page+1?> to <?=$page+count($parent_cat)?> of <?=$total_rows?> entries</span>
    </div>
    <div class="col-md-6 text-right">
        <?=$links?>
    </div>
</div>
<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('master-data/change_cat_status'); ?>",
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
<script type="text/javascript">
   function fetch_results(cat_id)
   {
        var parent_id = $('#parent_id').val();
        $.ajax({
            url: "<?php echo base_url('master-data/categories/tb'); ?>",
            method: "POST",
            data: {
                cat_id:cat_id,  //cat2 id
                parent_id:parent_id,    //cat1 id
            },
            success: function(data){
                $("#tb").html(data);
               
            },
        });
        
   };

   
function fetch_sub_categories(parent_id)
   {
    //ajax function for loading table by category 1
    var cat_id = $('#parent_cat_id').val(); //cat2 id
    $.ajax({
        url: "<?php echo base_url('master-data/categories/tb'); ?>",
        method: "POST",
        data: {
            cat_id:cat_id,   //cat2 id
            parent_id:parent_id,   //cat1 id
        },
        success: function(data){
            $("#tb").html(data);
            //ajax function for loading sub categories
            $.ajax({
                url: "<?php echo base_url('master-data/fetch_sub_categories'); ?>",
                method: "POST",
                data: {
                    parent_id:parent_id //cat1 id
                },
                success: function(data){
                    $(".parent_cat_id").html(data);


                },
            });
        },
    });
   

   }


</script>
