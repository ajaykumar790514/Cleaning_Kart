<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('reports'); ?>">Reports</a></li>
            <li class="breadcrumb-item active">Pos Sales Report</li>
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
                            <div class="float-left col-md-6 col-lg-6 col-sm-6">
                                <h3 class="card-title" id="test">Pos Sales Data</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>

                           

                            
                        </div>
                    </div>


                    <div class="col-12">
                        <form action="<?=$tb_url?>" class="tb-filter" method="post">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="control-label">From date:</label>
                                <input type="date" class="form-control form-control-sm" name="from_date" id="from_date" >
                            </div>
                            <div id="msg"></div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label class="control-label">To date:</label>
                                <input type="date" class="form-control form-control-sm" name="to_date" id="to_date" >
                            </div>
                        </div>

                        <div class="col-2">
                                <div class="form-group">
                                <label class="control-label">Customers:</label>
                                <select class="form-control form-control-sm" style="width:100%;" name="customer_id" id="customer_id">
                                    <option value="">Select</option>
                                    <?php foreach ($customers as $customer) { ?>
                                        <option value="<?=$customer->id?>" >
                                            <?=$customer->name?>
                                        </option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                <label class="control-label">Parent Categories:</label>
                                <select class="form-control form-control-sm" style="width:100%;" name="parent_id" id="parent_id">
                                <option value="">Select</option>
                                <?php foreach ($parent_cat as $parent) { ?>
                                <option value="<?php echo $parent->id; ?>" >
                                    <?php echo $parent->name; ?>
                                </option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label class="control-label">Sub Categories:</label>
                                    
                                    <select class="form-control form-control-sm parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" >
                                         <option value="">Select Parent Category First</option>                               
                                    </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                    <label class="control-label">Categories:</label>
                                    
                                    <select class="form-control form-control-sm sub_cat_id" style="width:100%;" name="sub_cat_id" id="sub_cat_id" >
                                         <option value="">Select Sub Category First</option>                               
                                    </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                <label class="control-label">Product : </label>
                                <select class="form-control form-control-sm" style="width:100%;" name="product_id" id="product_id" >
                                <option value="">Select Brand First</option>
                                
                                </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                <label class="control-label">Brand : </label>
                                <select class="form-control form-control-sm" style="width:100%;" name="brand_id" id="brand_id" >
                                <option value="">Select</option>
                                <?php foreach ($brands as $brand) { ?>
                                <option value="<?=$brand->id?>" >
                                    <?=$brand->name?>
                                </option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>







                       
                        <div class="col-2">
                            <div class="form-group">
                            <label class="control-label">Status:</label>
                                <select class="form-control form-control-sm" style="width:100%;" name="status_id" id="status_id" onchange="filter_by_status(this.value)">
                                    <option value="">Select</option>
                                    <?php foreach ($order_status as $status) { ?>
                                    <option value="<?php echo $status->id; ?>" <?php if(!empty($status_id)) { if($status_id==$status->id) {echo "selected"; } }?>>
                                        <?php echo $status->name; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label class="control-label">Search:</label>
                                <input type="text" class="form-control form-control-sm" name="tb-search" id="tb-search" value="<?=set_value('tb-search')?>" placeholder="Search...">
                            </div>
                        </div>
                       
                        <div class="col-2" style="margin-top: 32px;">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-success">Filter</button>
                                <button class="btn btn-sm btn-danger" id="reset-data">Reset</button>
                            </div>
                        </div>
                        
                       
                    </form>
                </div>




                    <div class="col-12" id="tb">
                        
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

<!-- //###### ANKIT MAIN CONTENT  ######// -->
<input type="hidden" name="tb" value="<?=$tb_url?>">
<div class="modal fade text-left" id="showModal-xl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
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
      </div>
  </div>
</div>
<script type="text/javascript">








$('#showModal-xl').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    var data_url  = button.data('url') 
    var modal = $(this)
    $('#showModal-xl .modal-title').text(recipient)
    $('#showModal-xl .modal-body').load(data_url);
})

$('#showModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) 
    var recipient = button.data('whatever') 
    var data_url  = button.data('url') 
    var modal = $(this)
    $('#showModal .modal-title').text(recipient)
    $('#showModal .modal-body').load(data_url);
})

$(document).on('click','[data-dismiss="modal"]', function(event) {
    $('#showModal .modal-body').html('');
    $('#showModal .modal-body').text('');
})



</script>

<?php $this->load->view('shop/reports/filters_js'); ?>


<!-- //###### ANKIT MAIN CONTENT  ######// -->

<script type="text/javascript">
function getid(proid) {
    $("#pro_content"+proid).load("<?php echo base_url('master-data/view_product_images/') ?>"+proid)
}


</script>

