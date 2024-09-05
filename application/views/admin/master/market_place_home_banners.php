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
                            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data/'.$menu_id); ?>">Master Data</a></li>
                            <li class="breadcrumb-item active">Market Place Home Banners</li>
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
                                                <h3 class="card-title" id="test">Home Banners Data</h3>
                                                <h6 class="card-subtitle"></h6>
                                            </div>
                                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                                <div id="add-market-place-home-banner" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Add Home Banners</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <form class="needs-validation" action="<?php echo base_url('master-data/add_market_place_home_banners'); ?>" method="post" enctype= multipart/form-data>
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="recipient-name" class="control-label">Image</label>
                                                                            <input type="file" class="form-control" name="img" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Sequence:</label>
                                                                            <input type="number" class="form-control" name="seq" value="0">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Banner Type:</label>
                                                                            <select class="form-control" style="width:100%;" name="banner_type" id="banner_type" required>
                                                                        <option value="">Select</option>
                                                                        <option value="1">Top Banner</option>
                                                                        <option value="0">Other Banner</option>
                                                                        </select>
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
                                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#add-market-place-home-banner" >Add Home Banner</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="grid_table">
                                            <table class="jsgrid-table">
                                                <tr class="jsgrid-header-row">
                                                    <th class="jsgrid-header-cell jsgrid-align-center"><button type="button" name="delete_all" id="delete_all" class="btn btn-danger btn-xs">Delete Selected</button></th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">S.No.</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Image</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Sequence</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Status</th>
                                                    <th class="jsgrid-header-cell jsgrid-align-center">Actions</th>
                                                    
                                                </tr>
                                                <?php
                                               $i=1;
                                                foreach($home_banners as $value)
                                                {
                                                    ?>
                                                <tr class="jsgrid-filter-row">
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                        <input type="checkbox" class="delete_checkbox" value="<?= $value->id; ?>" id="multiple_delete<?= $value->id; ?>" />
                                                        <label for="multiple_delete<?= $value->id; ?>"></label>
                                                    </td>
                                                    <th class="jsgrid-cell jsgrid-align-center"><?php echo $i++;?></th>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <?php if(!empty($value->img)) { ?>
                                                        <img src="<?php echo IMGS_URL.$value->img;?>" alt="image" height="50" width="50">
                                                        <?php } ?> 
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center"><?php echo $value->seq;?></td>
                                                    <td class="jsgrid-cell jsgrid-align-center" id="status<?php echo $value->id; ?>">
                                                        <?php if($value->active==1) { ?>
                                                    <button class="btn btn-success" onclick="change_status(<?php echo $value->id;?>)">Active</button>
                                                    <?php } else {?>
                                                        <button class="btn btn-danger" onclick="change_status(<?php echo $value->id;?>)">Inactive</button>
                                                        <?php }?>
                                                    </td>
                                                    <td class="jsgrid-cell jsgrid-align-center">
                                                    <a  data-toggle="modal" href="#" data-target="#edit-market-place-home-banner<?php echo $value->id; ?>" ><i class="fa fa-edit"></i></a>
                                                        <a href="<?php echo base_url('master-data/delete_market_place_home_banners/' . $value->id); ?>" onclick="return confirm('Do you want to delete this?')"><i class="fa fa-trash"></i></a>
                                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Link Banner" data-url="<?=$link_banner_url?><?=$value->id?>" >
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </td>
                                                </tr> 
                                                 <!--Link Banner modal-->
  <div class="modal fade text-left" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel21">......</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              
          </div>
          <!-- <div class="modal-footer">
              <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
          </div> -->
      </div>
  </div>
</div>
<!--/Link Banner modal-->
                                                <!--Edit home banner modal-->
                                                <div id="edit-market-place-home-banner<?php echo $value->id; ?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b>Update Home Banner</b>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="needs-validationedit" action="<?php echo base_url('master-data/edit_market_place_home_banners/'.$value->id); ?>" method="post" enctype="multipart/form-data">
                                                                
                                                                <div class="row">
                                                                   
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Banner Type:</label>
                                                                        <select class="form-control shop_id" style="width:100%;" name="banner_type" id="banner_type" required>
                                                                            <option value="">Select</option>
                                                                            <option value="1" <?php if($value->banner_type == 1){echo "selected";}?>>Top Banner</option>
                                                                            <option value="0" <?php if($value->banner_type == 0){echo "selected";}?>>Other Banner</option>
                                                                        </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label for="recipient-name" class="control-label">Image</label>
                                                                            <input type="file" class="form-control" name="img">
                                                                        </div>
                                                                        <?php if(!empty($value->img)){?>
                                                                        <img src="<?php echo IMGS_URL.$value->img; ?>" alt="image" height="50">
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Sequence:</label>
                                                                            <input type="number" class="form-control" name="seq" value="<?php echo $value->seq; ?>" required>
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
<!--/Edit home banner modal-->
                                                      <?php
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


<script type="text/javascript">
    $(document).ready(function() {

    $(".needs-validation").validate({
        rules: {
            business_id:"required",
            shop_id:"required",
            img:"required",
            seq:"required",
            banner_type:"required"
        },

    }); 
});
</script>


<script>
    function change_status(id)
    {
        $.ajax({
        url: "<?php echo base_url('master-data/change_homebanner_status'); ?>",
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
   function fetch_shop(business_id)
   {
    //    alert(business_id);
    $.ajax({
        url: "<?php echo base_url('master-data/fetch_shop'); ?>",
        method: "POST",
        data: {
            business_id:business_id
        },
        success: function(data){
            $(".shop_id").html(data);
        },
    });
   }
</script>
<script type="text/javascript">
   function link_banner(banner_id)
   {
    $.ajax({
        url: "<?php echo base_url('master-data/link_banner'); ?>",
        method: "POST",
        data: {
            banner_id:banner_id
        },
        success: function(data){
            $(".shop_id").html(data);
        },
    });
   }
</script>
<script>
  $('#showModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    var data_url  = button.data('url') 
    var modal = $(this)
    $('#showModal .modal-title').text(recipient)
    $('#showModal .modal-body').load(data_url);
})

            //multiple delete
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
        var table = 'home_banners';
            if(checkbox.length > 0)
            {
            var checkbox_value = [];
            $(checkbox).each(function(){
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url:"<?php echo base_url(); ?>master-data/multiple_delete",
                method:"POST",
                data:{checkbox_value:checkbox_value,table:table},
                success:function(data)
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