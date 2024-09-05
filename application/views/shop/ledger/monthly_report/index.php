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
            <li class="breadcrumb-item active"><?=$title?></li>
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
                                <h3 class="card-title" id="test"><?=$title?></h3>
                                <h6 class="card-subtitle"></h6>
                            </div>

                           

                            
                        </div>
                    </div>


                    <div class="col-12 p-hide">
                        <form action="<?=$tb_url?>" class="tb-filter" method="post">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="control-label">Select Month:</label>
                                <input type="month" id="month" name="month" class="form-control" max="<?=date('Y-m')?>" value="<?=date('Y-m')?>">
                            </div>
                        </div>

                        <div class="col-4" id="vendor-div">
                            <div class="form-group"  >
                                <input type="hidden" name="Id" id="Id">
                                <fieldset class="vendor">
                                    <input type='checkbox' name='is_Vendor' id="is_Vendor" />
                                    <label for="is_Vendor" class="control-label">Vendor:</label>
                                </fieldset>
                                <label id="this_Vendor" style="display: none;" class="control-label">Vendor:</label>
                                <select class="form-control" style="width:100%;" name="business_id" id="VendorId" disabled>
                                    <option value="">Select Vendor</option>
                                    <?php foreach ($vendor as $value) { ?>
                                        <option value="<?php echo $value->id; ?>">
                                            <?php echo $value->name; ?>(<?php echo $value->vendor_code; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-4" id="customer-div">
                            <div class="form-group">
                                <fieldset class="customer">
                                    <input type='checkbox' name='is_Customer' id="is_Customer" />
                                    <label for="is_Customer" class="control-label">Customer:</label>
                                </fieldset>
                                <label id="this_Customer" style="display: none;" class="control-label">Customer:</label>
                                <select class="form-control" style="width:100%;" name="business_id" id="CustomerId" disabled>
                                    <option value="">Select Customer</option>
                                    <?php foreach ($customer as $value) { ?>
                                        <option value="<?php echo $value->id; ?>">
                                            <?php echo $value->name; ?>(<?php echo $value->vendor_code; ?>)
                                        </option>
                                    <?php } ?>
                                </select>
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
<script type="text/javascript">
    
        $('#is_Vendor').click(function(e) {
        ;
        if ($('#is_Vendor').is(':checked') == true) {
            $(".customer").hide();
            $("#this_Customer").show();
            $("#VendorId").removeAttr('disabled', false);
        } else {
            $("#VendorId").attr('disabled', true);
            $("#VendorId").val('');
            $(".customer").show();
            $("#this_Customer").hide();
        }
    })
    $('#i_Vendor').click(function(e) {
        if ($('#i_Vendor').is(':checked') == true) {
            $(".customers").hide();
            $("#thi_Customer").show();
            $("#Vendord").removeAttr('disabled', false);
        } else {
            $("#Vendord").attr('disabled', true);
            $("#Vendord").val('');
            $(".customers").show();
            $("#thi_Customer").hide();
        }
    })
    $('#is_Customer').click(function(e) {
        ;
        if ($('#is_Customer').is(':checked') == true) {
            $("#CustomerId").removeAttr('disabled', false);
            $("#this_Vendor").show();
            $(".vendor").hide();
        } else {
            $("#CustomerId").attr('disabled', true);
            $("#CustomerId").val('');
            $(".vendor").show();
            $("#this_Vendor").hide();
        }
    })
    $('#i_Customer').click(function(e) {
        if ($('#i_Customer').is(':checked') == true) {
            $("#Customerd").removeAttr('disabled', false);
            $("#thi_Vendor").show();
            $(".vendors").hide();
        } else {
            $("#Customerd").attr('disabled', true);
            $("#Customerd").val('');
            $(".vendors").show();
            $("#thi_Vendor").hide();
        }
    })

</script>

<?php $this->load->view('shop/reports/filters_js'); ?>


<!-- //###### ANKIT MAIN CONTENT  ######// -->

