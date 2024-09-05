<style type="text/css">
    .form-group {
    margin-bottom: 10px;
}
</style>
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="stocks">Sale Return</a></li>
            
        </ol>
    </div>
</div>

<div class="row">       
    <!-- Column -->
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap">
                            <div class="float-left col-md-10 col-lg-10 col-sm-12">
                                <h3 class="card-title" id="test">Sale Return</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>
                            
                        </div>
                    </div>

                    <div class="col-12">
                        <form action="<?=$tb_url?>" class="tb-filter" method="post">

                            <div class="col-2">
                                <div class="form-group">
                                <label class="control-label">Customers:</label>
                                <select class="form-control" style="width:100%;" name="customer_id" id="customer_id">
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
                                <select class="form-control" style="width:100%;" name="parent_id" id="parent_id">
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
                                    <label class="control-label">Categories:</label>
                                    
                                    <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" >
                                         <option value="">Select Parent Category First</option>                               
                                    </select>
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                <label class="control-label">Product : </label>
                                <select class="form-control" style="width:100%;" name="product_id" id="product_id" >
                                <option value="">Select Category First</option>
                                
                                </select>
                                </div>
                            </div>

                            

                           
                            <div class="col-1">
                                <div class="form-group">
                                <label class="control-label"><br></label>
                                <input type="submit" class="form-control btn btn-primary text-white" id="reset-data" value="Filter">    
                                <!-- <button type="reset" class="btn btn-danger" id="reset-data">Reset</button> -->
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                <label class="control-label"><br></label>
                                <input type="reset" class="form-control btn btn-danger text-white" id="reset-data" value="Reset">    
                                <!-- <button type="reset" class="btn btn-danger" id="reset-data">Reset</button> -->
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-group">
                                <label class="control-label"><br></label>
                                <input type="button" class="form-control btn btn-primary text-white" id="add-sale-return" value="Add Sale Return" data-toggle="modal" data-target="#showModal" data-whatever="Add Sale Return" data-url="<?=base_url()?>sale_return/return"> 
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

<input type="hidden" name="tb" value="<?=@$tb_url?>">
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
          <div class="modal-header py-1">
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

function loadtb(){
    $('.tb-filter').submit();
}

// loadtb();

$(document).on('click', '.pag-link', function(event){
    document.body.scrollTop = 0; 
    document.documentElement.scrollTop = 0;
    var search = $('#tb-search').val();
    $.post($(this).attr('href'),{search:search})
    .done(function(data){
        $('#tb').html(data);
    })
    return false;
})

$('body').on("submit", '.ajaxsubmit', function(event) {
  
    event.preventDefault(); 
    $this = $(this);
    $this.find('[type=submit]').prop('disabled',true);

    if ($this.hasClass("needs-validation")) {
        if (!$this.valid()) {
            return false;
        }
    }
    
    
    $.ajax({
      url: $this.attr("action"),
      type: $this.attr("method"),
      data:  new FormData(this),
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        console.log(data);
        

        data = JSON.parse(data);
        
        if (data.res=='success') {
            
            
            if($this.hasClass("add-form")) {
                $('#showModal').modal('hide');
            }
            
            if ($this.hasClass("reload-tb")) {
                loadtb();
            }

          

            
        }
        alert(data.msg);
        // alert_toastr(data.res,data.msg);
      }
    })
    $this.find('[type=submit]').prop('disabled',false);
    return false;
})

$('body').on('input','[name=return_qty],[name=return_rate]',function(){
    var form = $(this).parents('form');
    var return_qty = parseFloat(form.find('[name=return_qty]').val());
    var return_rate = parseFloat(form.find('[name=return_rate]').val());
    form.find('[name=return_total]').val(parseFloat(return_qty*return_rate).toFixed(2));

    // console.log('qty '+return_qty);
    // console.log('rate '+return_rate);
    // console.log('total ' + return_qty*return_rate);
})


</script>

<?php $this->load->view('shop/reports/filters_js'); ?>