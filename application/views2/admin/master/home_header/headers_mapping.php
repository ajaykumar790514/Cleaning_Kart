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
                            <li class="breadcrumb-item"><a href="<?php echo base_url('home-header'); ?>">Home Header</a></li>
                            <li class="breadcrumb-item active">Headers Mapping</li>
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
                                                <h3 class="card-title" id="test">Home Header Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-headers-mapping" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content" id="mapping">
                                                         
                                                        </div>
                                                    </div>
                                                </div>
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-headers-mapping" onclick="add_mapping(<?php echo $headerid;?>)">Add Headers Items</button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Header</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Product Name</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Product Photo</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Product Code</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                </tr>
                                                <?php $i=1; foreach($headers_mapping as $value){ ?>
                                                <tr class="jsgrid-filter-row">
                                                    <th class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></th>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->title;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->prod_name;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <img src="<?php echo IMGS_URL.$value->img; ?>" alt="image" height="100">
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->product_code;?></td>
                                                    
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <a href="<?php echo base_url('delete-header-mapping/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                <?php } ?>  
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
<script type="text/javascript">
$(document).ready(function() {
    $(".needs-validation").validate({
        rules: {
            business_id:"required",
            shop_id:"required",
            title:"required",
            type:"required"
        },
    }); 
});
</script>


<script type="text/javascript">
   function add_mapping(headerid)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/add_mapping'); ?>",
        method: "POST",
        data: {
            headerid:headerid
        },
        success: function(data){
            $("#mapping").html(data);
        },
    });
    // $("#mapping").load("<?php echo base_url('master-data/add_mapping'); ?>"+headerid)
   }
</script>
<script type="text/javascript">
   function fetch_category(parent_id)
   {
    //    alert(business_id);
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_category'); ?>",
        method: "POST",
        data: {
            parent_id:parent_id
        },
        success: function(data){
            $(".parent_cat_id").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function fetch_products(parent_cat_id)
   {
    var headerid = $('#headerid').val();
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_products'); ?>",
        method: "POST",
        data: {
            parent_cat_id:parent_cat_id,
            headerid:headerid
        },
        success: function(data){
            $("#available_products").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function map_product(pid)
   {
    var headerid = $('#headerid').val();
    $.ajax({
        url: "<?php echo base_url('master-data/map_product'); ?>",
        method: "POST",
        data: {
            pid:pid,
            headerid:headerid
        },
        success: function(data){
            // fetch_products();
            $("#changeaction2"+pid).html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function remove_map_product(pid)
   {
    var headerid = $('#headerid').val();
    $.ajax({
        url: "<?php echo base_url('master-data/remove_map_product'); ?>",
        method: "POST",
        data: {
            pid:pid,
            headerid:headerid
        },
        success: function(data){
            // fetch_products();
            $("#changeaction2"+pid).html(data);
        },
    });
   }
</script>