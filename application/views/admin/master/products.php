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
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
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
                                                <h3 class="card-title" id="test">Product Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-product" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Product</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('add-product'); ?>" method="post" enctype= multipart/form-data>
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                        <div class="form-group">
                                                                        <label class="control-label">Categories:</label>
                                                                        <select class="form-control select2" style="width:100%;" name="parent_cat_id">
                                                                        <option value="">Select Category</option>
                                                                        <?php foreach ($categories as $cat) { ?>
                                                                        <option value="<?php echo $cat->id; ?>">
                                                                            <?php echo $cat->name; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                        </div>
                                                                        </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Product Name:</label>
                                                                                <input type="text" class="form-control" name="name">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Product Image:</label>
                                                                                <input type="file" name="img[]" class="form-control"
                                                size="55550" accept=".png, .jpg, .jpeg, .gif" multiple="">
                                                                            </div>
                                                                        </div>
                                                                    
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Search Keyword:</label>
                                                                                <input type="text" class="form-control" name="search_keywords">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Product Code:</label>
                                                                                <input type="text" class="form-control" name="product_code" >
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Product Quantity:</label>
                                                                                <input type="text" class="form-control" name="unit_value">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                        <div class="form-group">
                                                                        <label class="control-label">Quantity Type:</label>
                                                                        <select class="form-control select2" style="width:100%;" name="unit_type">
                                                                        <option value="">Select Quantity Type</option>
                                                                        <?php foreach ($unit_type as $unit) { ?>
                                                                        <option value="<?php echo $unit->id; ?>">
                                                                            <?php echo $unit->name; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Description:</label>
                                                                                <textarea id="" cols="92" rows="5" name="description"></textarea>
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
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-product" >Add Product</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <span>Showing <?=$page+1?> to <?=$page+$per_page?> of <?=$total_rows?> entries</span>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <?=$links?>
                                            </div>
                                        </div>
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
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=$page; foreach($products as $value){ ?>
                                                <tr class="jsgrid-filter-row">
                                                    <th class="jsgrid-cell jsgrid-align-center"><?=++$i?></th>
                                                    <td class="jsgrid-cell jsgrid-align-center"></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->search_keywords;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->product_code;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->unit_value;?> <?php echo $value->unit_type;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->description;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a  data-toggle="modal" href="#" data-target="#edit-product<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('delete-product/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                        <a  data-toggle="modal" href="#" data-target="#add-property-value<?php echo $value->id; ?>" ><i class="fa fa-plus"></i></a>
                                                        <a  data-toggle="modal" href="#" data-target="#view-product-images<?php echo $value->id; ?>" onclick="getid(<?php echo $value->id; ?>);"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                </tr> 
                                                <div id="edit-product<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                    
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Product</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                    
                                                            <form action="<?php echo base_url('edit-product/'.$value->id); ?>" method="post" enctype= multipart/form-data>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Categories:</label>
                                                                        <select class="form-control select2" style="width:100%;" name="tax_id">
                                                                        <option value="">Select Category</option>
                                                                        <?php foreach ($categories as $cat) { ?>
                                                                        <option value="<?php echo $cat->id; ?>" <?php if($cat->id == $value->parent_cat_id){echo "selected";} ?>>
                                                                            <?php echo $cat->name; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Product Name:</label>
                                                                                <input type="text" class="form-control" name="name" value="<?php echo $value->name; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Search Keyword:</label>
                                                                                <input type="text" class="form-control" name="search_keywords" value="<?php echo $value->search_keywords; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Product Code:</label>
                                                                                <input type="text" class="form-control" name="product_code" value="<?php echo $value->product_code; ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Product Quantity:</label>
                                                                                <input type="text" class="form-control" name="unit_value" value="<?php echo $value->unit_value; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                        <div class="form-group">
                                                                        <label class="control-label">Quantity Type:</label>
                                                                        <select class="form-control select2" style="width:100%;" name="unit_type">
                                                                        <option value="">Select Quantity Type</option>
                                                                        <?php foreach ($unit_type as $unit) { ?>
                                                                        <option value="<?php echo $unit->id; ?>" <?php if($unit->id == $value->unit_type_id){echo "selected";} ?>>
                                                                            <?php echo $unit->name; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Description:</label>
                                                                                <textarea id="" cols="92" rows="5" name="description"><?php echo $value->description; ?></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                <input type="submit" class="btn btn-primary waves-light" type="submit" value="UPDATE">
                                                            </div>
                                                            
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> 
                                                <!--Add property modal-->
                                                <div id="add-property-value<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Property Value</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="<?php echo base_url('add-property-value/'.$value->id); ?>" method="post" enctype= multipart/form-data>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Properties:</label>
                                                                        <select class="form-control select2" style="width:100%;" name="props_id">
                                                                        <option value="">Select Property</option>
                                                                        <?php foreach ($properties as $prop) { ?>
                                                                        <option value="<?php echo $prop->id; ?>">
                                                                            <?php echo $prop->name; ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Property Value</label>
                                                                                <input type="text" class="form-control" name="value">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                        <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" />
                                                                    </div>
                                                                
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <!--/Add property modal-->
                                                <!--View product image-->
                                                <div id="view-product-images<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Product Images</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                <div id="pro_content<?php echo $value->id; ?>" class="modal-body">
                                                                    <div class="col-12">
                                                                        <div class="row">
                                                                        
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <!--/View product image modal-->


                                                <?php } ?>    
                                                </table>

                                                
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <span>Showing <?=$page+1?> to <?=$page+$per_page?> of <?=$total_rows?> entries</span>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <?=$links?>
                                            </div>
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

    <script type="text/javascript">
    function getid(proid) {
        $("#pro_content"+proid).load("<?php echo base_url('master-data/view_product_images/') ?>"+proid)
    }
    // $(document).ready(function(){
    // $("#view-product-images").load("<?php echo base_url('master-data/view_product_images'); ?>")
    // })

$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            name: {
                required:true,
                remote:"<?=$remote?>null"
            }
            product_code: {
                required:true,
                remote:"<?=$remote?>null/product_code"
            }
        },
        messages: {
            name: {
                required : "Please enter name!",
                remote : "Product already exists!"
            }
            product_code: {
                required : "Please enter name!",
                remote : "Product code already exists!"
            }
        }
    }); 
});
</script>
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