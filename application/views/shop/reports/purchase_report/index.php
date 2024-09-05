
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('reports'); ?>">Reports</a></li>
            <li class="breadcrumb-item active">Purchase Report</li>
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
                                <h3 class="card-title" id="test">Purchase Data</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>

                           

                            
                        </div>
                    </div>

                    <div class="col-12">
                        <form action="<?=$tb_url?>" class="tb-filter" method="post">
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">From date:</label>
                <input type="date" class="form-control" name="from_date" id="from_date" value="<?php if(!empty($from_date)){echo $from_date; }?>">
            </div>
            <div id="msg"></div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label class="control-label">To date:</label>
                <input type="date" class="form-control" name="to_date" id="to_date" value="<?php if(!empty($to_date)){echo $to_date; }?>" onchange="filter_purchase_report(this.value)">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
            <label class="control-label">Vendor:</label>
            <select class="form-control" style="width:100%;" name="vendor_id" id="vendor_id" onchange="filter_by_vendor(this.value)">
            <option value="">Select</option>
            <?php foreach ($vendor_list as $vendor) { ?>
            <option value="<?php echo $vendor->id; ?>" <?php if(!empty($vendor_id)) { if($vendor_id==$vendor->id) {echo "selected"; } }?>>
                <?php echo $vendor->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
            <label class="control-label">Brand:</label>
            <select class="form-control" style="width:100%;" name="brand_id" id="brand_id" onchange="filter_by_brand(this.value)">
            <option value="">Select</option>
            <?php foreach ($brands as $brand) { ?>
            <option value="<?php echo $brand->id; ?>" <?php if(!empty($brand_id)) { if($brand_id==$brand->id) {echo "selected"; } }?>>
                <?php echo $brand->name; ?>
            </option>
            <?php } ?>
            </select>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label class="control-label">Search:</label>
                <input type="text" class="form-control" name="tb-search" id="tb-search" value="<?php if(@$search!='null'){echo @$search;}?>" placeholder="Search...">
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                <label class="control-label">Parent Categories:</label>
                <select class="form-control" style="width:100%;" name="parent_id" id="parent_id" >
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
                
                <select class="form-control parent_cat_id" style="width:100%;" name="parent_cat_id" id="parent_cat_id" >
                    <?php if($parent_cat_id!=='null') { ?>
                        <?php foreach ($sub_cat as $scat) { ?>
                        <option value="<?php echo $scat->id; ?>" <?php if(!empty($parent_cat_id)) { if($parent_cat_id==$scat->id) {echo "selected"; } }?>>
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
                
                <select class="form-control child_cat_id" style="width:100%;" name="sub_cat_id" id="sub_cat_id" >
                    <?php if($child_cat_id!=='null') { ?>
                        <?php foreach ($child_cat as $ccat) { ?>
                        <option value="<?php echo $ccat->id; ?>" <?php if($child_cat_id!='null') { if($child_cat_id==$ccat->id) {echo "selected"; } }?>>
                            <?php echo $ccat->name; ?>
                        </option>
                        <?php } ?>
                    <?php }?>                                  
                </select>
            </div>
        </div>
        <div class="col-2 mt-4">
            <div class="form-group">
            <button class="btn btn-danger" id="reset-data">Reset</button>
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

function loadtb(url=null){
    if (url!=null) {
        var tbUrl = url;
    }
    else{
        var tbUrl = $('[name="tb"]').val();
    }

    if (tbUrl!='') {
        $('#tb').load(tbUrl);
    }
}

loadtb();

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

$(document).on("submit", '.ajaxsubmit', function(event) {
    event.preventDefault(); 
    $this = $(this);

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
        // return false;

        data = JSON.parse(data);
        
        if (data.res=='success') {
            if(!$this.hasClass("update-form")) {
                $('[type="reset"]').click();
            }
            
            if ($this.hasClass("reload-tb")) {
                loadtb();
            }

            if ($this.hasClass("reload-page")) {
                setTimeout(function() {
                    window.location.reload();
                }, 1000); 
            }

            if ($this.hasClass("btn-click")) {
                setTimeout(function() {
                    var btn_target = $this.attr("btn-target");
                    $(btn_target).click();
                }, 1000); 
            }
        }
        alert(data.msg);
        // alert_toastr(data.res,data.msg);
      }
    })
    return false;
})
</script>
<!-- //###### ANKIT MAIN CONTENT  ######// -->

<script type="text/javascript">
function getid(proid) {
    $("#pro_content"+proid).load("<?php echo base_url('master-data/view_product_images/') ?>"+proid)
}

var timer;
        var timeout = 100;
        
            
        $(document).on('keyup', '#tb-search', function(event){
            if(event.keyCode == 13)
            {
            $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
            clearTimeout(timer);
            timer = setTimeout(function(){
                var search  = $('#tb-search').val();
                var from_date = $("#from_date").val();
                var to_date = $('#to_date').val();
                var vendor_id = $("#vendor_id").val();
                var brand_id = $("#brand_id").val();
                var parent_id  = $('#parent_id').val();
                var parent_cat_id  = $('#parent_cat_id').val();
                var cat_id  = $('#cat_id').val();
                // console.log(search);
                var tbUrl = $('[name="tb"]').val();
                $.post(tbUrl,{search:search,from_date:from_date,to_date:to_date,vendor_id:vendor_id,brand_id:brand_id,
                parent_id:parent_id,
                parent_cat_id:parent_cat_id,
                child_cat_id:cat_id,})
                .done(function(data){
                    $('#tb').html(data);
                    if($('#tb-search').val()!== '')
                    {
                        document.getElementById("tb-search").focus();
                        var search  = $('#tb-search').val();
                        $('#tb-search').val('');
                        $('#tb-search').val(search);
                    }

                })
            }, timeout);
            
            
            return false;
            
        }
        })
        
</script>

<?php $this->load->view('shop/reports/filters_js'); ?>
<!-- <script>
    if($('#tb-search').val()!== '')
                {
                    document.getElementById("from_date").focus();
                }
</script> -->

