<link rel="stylesheet" type="text/css" media="print" href="public/assets/css/ledger-prints.css" />
<style type="text/css">
    #datatable table th{
    border-top: 1px solid black;
    border-bottom: 1px solid black;
}
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('reports'); ?>">Reports</a></li>
            <li class="breadcrumb-item active">Cash Report</li>
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
                    <div class="col-12 p-hide">
                        <div class="d-flex flex-wrap">
                            <div class="float-left col-md-6 col-lg-6 col-sm-6">
                                <h3 class="card-title" id="test">Cash Report</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>

                           

                            
                        </div>
                    </div>


                    <div class="col-12 p-hide">
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

