                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-wrapper">
                <div class="container-fluid" style="max-width: 100% !important;">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data'); ?>">Master</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div><!--
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>THIS MONTH</small></h6>
                                    <h4 class="m-t-0 text-info">$58,356</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                                    <h4 class="m-t-0 text-primary">$48,356</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div>
                        </div>
                    </div>-->
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex flex-wrap">
                                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                                <h3 class="card-title" id="test">Category Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-category" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Category</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('add-category'); ?>" method="post" enctype= multipart/form-data>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Tax Slab:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="tax_id">
                                                                            <option value="">Select Tax Slab</option>
                                                                            <?php foreach ($tax_slabs as $value) { ?>
                                                                            <option value="<?php echo $value->id; ?>,<?php echo $value->slab; ?>">
                                                                                <?php echo $value->slab; ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Parent Category:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="parent_id">
                                                                            <option value="">--Select--</option>
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
                                                                                <label class="control-label">Category Name:</label>
                                                                                <input type="text" class="form-control" name="name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="control-label">Image</label>
                                                                                <input type="file" class="form-control" name="icon">
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
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD">
                                                            </div>
                                                            
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-category" >Add Category</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Name</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Image</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Desc</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                    
                                                </tr>
                                                <?php
                                               $i=1;
                                                foreach($parent_cat as $value)
                                                {
                                                    if($value->is_parent=="0")
                                                    {
                                                    ?>
                                                <tr class="jsgrid-filter-row">
                                                    <th class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></th>
                                                    <td class="jsgrid-cell"><strong class="float-left"><?php echo $value->name;?></strong> </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <?php if(!empty($value->icon)) { ?>
                                                        <img src="<?php echo base_url($value->icon);?>" alt="<?php echo $value->name;?>" height="50" width="50">
                                                        <?php } ?> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-left"><?php $desc = strip_tags( $value->description);
    $desc = substr($desc,0,15);
    echo $desc; ?>.... 
    <?php if(strlen($value->description) > 15){ ?>   
    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $value->id; ?>">Read More</button>
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
                                                    <a  data-toggle="modal" href="#" data-target="#edit-category<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('delete-category/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
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
                                                        <?php if(!empty($cat->icon)) { ?>
                                                        <img src="<?php echo base_url($cat->icon);?>" alt="<?php echo $cat->name;?>" height="50" width="50">
                                                        <?php } ?> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-left">
                                                    <?php $desc = strip_tags( $cat->description);
    $desc = substr($desc,0,15);
    echo $desc; ?>.... <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#read-desc<?php echo $cat->id; ?>">Read More</button>
    
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $cat->id; ?>">
                                                        <?php if($cat->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $cat->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $cat->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a  data-toggle="modal" href="#" data-target="#edit-category<?php echo $cat->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('delete-category/' . $cat->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
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
                                                     <!--Edit parent category modal-->
                                                    <div id="edit-category<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Category</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validationedit" action="<?php echo base_url('edit-category/'.$value->id); ?>" method="post" enctype="multipart/form-data">
                                                                
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Tax Slab:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="tax_id">
                                                                            <option value="">Select Tax Slab</option>
                                                                            <?php foreach ($tax_slabs as $slab) { ?>
                                                                            <option value="<?php echo $slab->id; ?>,<?php echo $slab->slab; ?>" <?php if($slab->id == $value->tax_id){echo "selected";} ?>>
                                                                                <?php echo $slab->slab; ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="recipient-name" class="control-label">Category Name:</label>
                                                                            <input type="text" name="name" class="form-control" value="<?php echo $value->name;?>">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Image</label>
                                                                            <input type="file" name="icon" class="form-control">
                                                                        </div>
                                                                            <img src="<?php echo base_url($value->icon); ?>" alt="<?php echo $value->name; ?>" height="50">
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Description:</label>
                                                                            <textarea class="form-control" name="description" rows="4" cols="50"><?php echo $value->description; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                       
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="UPDATE">
                                                            </div>
                                                            </form>


                                                        </div>
                                                    </div>
                                                </div> 
<!--/Edit parent category modal-->
                                                <!--Edit category modal-->
                                                <div id="edit-category<?php echo $cat->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Category</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('edit-category/'.$cat->id); ?>" method="post" enctype="multipart/form-data">
                                                                
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Parent Category:</label>
                                                                            <select class="form-control select2" style="width:100%;" name="parent_id" required>
                                                                            <option value="">--Select--</option>
                                                                            <?php foreach ($parent_cat as $parent) { ?>
                                                                            <option value="<?php echo $parent->id; ?>" <?php if($parent->id == $cat->is_parent){echo "selected";} ?>>
                                                                                <?php echo $parent->name; ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Tax Slab:</label>
                                                                        <select class="form-control select2" style="width:100%;" name="tax_id">
                                                                        <option value="">Select Tax Slab</option>
                                                                        <?php foreach ($tax_slabs as $slab) { ?>
                                                                        <option value="<?php echo $slab->id; ?>,<?php echo $slab->slab; ?>" <?php if($slab->id == $cat->tax_id){echo "selected";} ?>>
                                                                            <?php echo $slab->slab; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label for="recipient-name" class="control-label">Category Name:</label>
                                                                                <input type="text" name="name" class="form-control" value="<?php echo $cat->name;?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Image</label>
                                                                                <input type="file" name="icon" class="form-control">
                                                                            </div>
                                                                                <img src="<?php echo base_url($cat->icon); ?>" alt="<?php echo $cat->name; ?>" height="50">
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Description:</label>
                                                                                <textarea class="form-control" name="description" rows="4" cols="50"><?php echo $cat->description; ?></textarea>
                                                                            </div>
                                                                        </div> 
                                                                       
                                                                    </div>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-danger waves-light" type="submit" value="UPDATE">
                                                            </div>
                                                            </form>


                                                        </div>
                                                    </div>
                                                </div> 
                            <!--/edit cat modal-->
                                                </tr> 
                                                      <?php  }

                                                 }
                                                    }
                                                }
                                               ?>
                                                    
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

                <!-- $config['file_name'] = date("Y-m-d").'-'.rand(100, 1000000);
        $config['upload_path'] = 'application/photo/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif|pdf';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!empty($_FILES['img']['name']) && count(array_filter($_FILES['img']['name'])) > 0) {
            //upload images
            $filesCount = count($_FILES['img']['name']); 
                for($i = 0; $i < $filesCount; $i++)
                {
                    $_FILES['imgs']['name'] = $_FILES['img']['name'][$i];
                    $_FILES['imgs']['type'] = $_FILES['img']['type'][$i];
                    $_FILES['imgs']['tmp_name'] = $_FILES['img']['tmp_name'][$i];
                    $_FILES['imgs']['size'] = $_FILES['img']['size'][$i];
                    $_FILES['imgs']['error'] = $_FILES['img']['error'][$i];

                    if ($this->upload->do_upload('imgs')) {
                        $image_data = $this->upload->data();
                        $fileName = "application/photo/" . $image_data['file_name'];
                    }
                    $data['img'] = $fileName;
                   $this->db->insert('products_subcategory', $data);
                }
                 
                // return true;
        }
        return $this->db->insert_id('products_subcategory', $data);
        // else {
        //    return false;
        // } -->

<script type="text/javascript">
    $(document).ready(function() {
   
    $(".needs-validationedit").validate({
        rules: {
            tax_id:"required",
            description:"required",
            icon:"required",
            name:{
                required:true,
                remote:"<?=$remote?>null"
            }
        },
        messages: {
            tax_id:"Please Select Tax Slab!",
            description:"Please Enter Description!",
            icon:"Please Select Image!",
            name: {
                required : "Please enter name.",
                remote : "Category already exists!"
            }
        }
    }); 
    $(".needs-validation").validate({
        rules: {
            tax_id:"required",
            description:"required",
            icon:"required",
            name:{
                required:true,
                remote:"<?=$remote?>null"
            }
        },
        messages: {
            tax_id:"Please Select Tax Slab!",
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