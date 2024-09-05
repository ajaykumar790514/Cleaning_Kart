<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('cash-Register/' . $menu_id); ?>">Transaction</a></li>
            <li class="breadcrumb-item active">Cash Register</li>
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
                                <h3 class="card-title" id="Cash-Register" style="margin-left: -16px;">Cash Register</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>
                            <div class="float-left col-md-6 col-lg-6 col-sm-6">
                                <button class="float-right btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" onclick="showModal1()" data-whatever="Add Cash Data">Add Cash Data</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <label class="control-label">From Date:</label>
                            <input type="date" class="form-control" name="from_date" id="from_date">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="control-label">To Date:</label>
                            <input type="date" onchange="loadtb()" class="form-control" name="to_date" id="to_date">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <fieldset class="vendors">
                                <input type='checkbox' onclick="loadtb(1)" name='is_Vendor' id="i_Vendor" />
                                <label for="i_Vendor" class="control-label">Vendor:</label>
                            </fieldset>
                            <label id="thi_Vendor" style="display: none;" class="control-label">Vendor:</label>
                            <select class="form-control" style="width:100%;" onchange="loadtb()" name="Vendord" id="Vendord" disabled>
                                <option value="">Select Vendor</option>
                                <?php foreach ($vendor as $value) { ?>
                                    <option value="<?php echo $value->id; ?>">
                                        <?php echo $value->name; ?>(<?php echo $value->vendor_code; ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <fieldset class="customers">
                                <input type='checkbox' name='is_Customer' onclick="loadtb(2)" id="i_Customer" />
                                <label for="i_Customer" class="control-label">Customer:</label>
                            </fieldset>
                            <label id="thi_Customer" style="display: none;" class="control-label">Customer:</label>
                            <select class="form-control" style="width:100%;" onchange="loadtb()" name="Customerd" id="Customerd" disabled>
                                <option value="">Select Customer</option>
                                <?php foreach ($customer as $value) { ?>
                                    <option value="<?php echo $value->id; ?>">
                                        <?php echo $value->name; ?>(<?php echo $value->vendor_code; ?>)
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-1" style="margin-top: 33px;">
                        <button class="float-right btn btn-danger btn-xm" id="reset-page">Reset</button>
                    </div>
                </div>
                <div class="col-12 p-0" id="tb">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
<div class="modal fade text-left" id="showModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel21"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script type="text/javascript">
                $('body').on('change','.cash-save-box input[type=checkbox]',function(event){
                    var _this = $(this);
                    if (event.target.checked) {
                        var _is_checked = 'checked';
                    }
                    else {
                        var _is_checked ='unchecked';
                    }
                    $('.cash-save-box input[type=checkbox]').each(function() {
                        $(this).removeAttr('checked',false);
                        $(this).parents('.form-group').find('select').prop('disabled',true);
                        
                        $(this).parents('.form-group').find('[tmp]').show();
                        $(this).parents('.form-group').find('fieldset').hide();
                    })

                    if (_is_checked == 'checked') {
                        setTimeout(function() {
                            _this.attr('checked',true);
                            _this.parents('.form-group').find('select').prop('disabled',false);
                            _this.parents('.form-group').find('[tmp]').hide();
                            _this.parents('.form-group').find('fieldset').show();
                        }, 500);
                    }
                    else {
                        $('.cash-save-box input[type=checkbox]').each(function() {
                            $(this).parents('.form-group').find('select').prop('disabled',true);
                            $(this).parents('.form-group').find('[tmp]').hide();
                            $(this).parents('.form-group').find('fieldset').show();
                        })
                        _this.parents('.form-group').find('select').val('');
                    }
                    // alert(_is_checked);
                    // _this.parents('.form-group').find('select').prop('disabled',false);
                    // alert(_this.attr('name'))
                })
            </script>

            <div class="modal-body">
                <div class="modal-body">
                    <div class="row cash-save-box">
                        <div class="col-6" id="vendor-div">
                            <div class="form-group"  >
                                <input type="hidden" name="Id" id="Id">
                                <fieldset class="vendor">
                                    <input type='checkbox' name='is_Vendor' id="is_Vendor"  />
                                    <label for="is_Vendor" class="control-label">Vendor:</label>
                                </fieldset>
                                <label tmp id="this_Vendor" style="display: none;" class="control-label">Vendor:</label>
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
                        <div class="col-6" id="customer-div">
                            <div class="form-group">
                                <fieldset class="customer">
                                    <input type='checkbox' name='is_Customer' id="is_Customer" />
                                    <label for="is_Customer" class="control-label">Customer:</label>
                                </fieldset>
                                <label tmp id="this_Customer" style="display: none;" class="control-label">Customer:</label>
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
                        <div class="col-6" id="vendor-div">
                            <div class="form-group"  >
                                <!-- <input type="hidden" name="Id" id="Id"> -->
                                <fieldset class="vendor">
                                    <input type='checkbox' name='is_Bank' id="is_Bank" />
                                    <label for="is_Bank" class="control-label">Bank Account:</label>
                                </fieldset>
                                <label tmp id="this_Bank" style="display: none;" class="control-label">Bank Account:</label>
                                <select class="form-control" style="width:100%;" name="bank_id" id="BankId" disabled>
                                    <option value="">Select Vendor</option>
                                    <?php 
                                    foreach ($bank_accounts as $key => $brow) {
                                       echo "<option value='$brow->id'> $brow->account_no ( $brow->branch_name )</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">Reference No:</label>
                                <input type="text" name="refno" onchange="checkrefno()" class="form-control" value="" id="refno">
                                <input type="text" name="refno" style="display:none;" onchange="editcheckrefno()" class="form-control" value="" id="editrefno">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">Amount:</label>
                                <input type="number" class="form-control" name="Amount" id="Amount" min="0" step="0.01" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">Payment Date:</label>
                                <input type="date" class="form-control" name="PaymentDate" id="PaymentDate">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">Dr./Cr.:</label>
                                <select class="form-control" name="dr_cr" id="dr_cr">
                                    <option value="">-- Select --</option>
                                    <option value="dr">Recipt</option>
                                    <option value="cr">Payment</option>
                                    
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">Narration :</label>
                                <input type="text" class="form-control" name="narration" id="narration">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <buton type="button" class="btn btn-danger waves-light" id="AddBtn" onclick="CashSubmit1()" value="" >ADD</buton>
                    <button type="button" class="btn btn-danger waves-light" style="display:none;" id="UpdateBtn" onclick="Cashupdate()"  >UPDATE</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // console.log("ready!");
    });

    function showModal1() {
        $('#showModal .modal-body').show();
        $("#Amount").val('');
        $("#refno").val('');
        $("#VendorId").val('');
        $("#CustomerId").val('');
        $("#PaymentDate").val('');
        $("#myModalLabel21").text("Add Cash Data");
        $("#UpdateBtn").hide();
        $("#AddBtn").show();
        $("#editrefno").hide();
        $("#refno").show();
        $("#customer-div").show();
        $("#vendor-div").show();
    }

    // $('#is_Vendor').click(function(e) {
    //     ;
    //     if ($('#is_Vendor').is(':checked') == true) {
    //         $(".customer").hide();
    //         $("#this_Customer").show();
    //         $("#VendorId").removeAttr('disabled', false);
    //     } else {
    //         $("#VendorId").attr('disabled', true);
    //         $("#VendorId").val('');
    //         $(".customer").show();
    //         $("#this_Customer").hide();
    //     }
    // })

    // $('#is_Customer').click(function(e) {
    //     ;
    //     if ($('#is_Customer').is(':checked') == true) {
    //         $("#CustomerId").removeAttr('disabled', false);
    //         $("#this_Vendor").show();
    //         $(".vendor").hide();
    //     } else {
    //         $("#CustomerId").attr('disabled', true);
    //         $("#CustomerId").val('');
    //         $(".vendor").show();
    //         $("#this_Vendor").hide();
    //     }
    // })

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
    $(document).on('click', '.pag-link', function(event) {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
        var search = $('#tb-search').val();
        $.post($(this).attr('href'), {
                search: search
            })
            .done(function(data) {
                ;
                $('#tb').html(data);
            })
        return false;
    })
    $('#reset-page').click(function(e) {
        location.reload();
    });
    var checkref = '';
    var editcheckref = '';

    function loadtb(id) {
        $("#tb").html('<div class="text-center"><img src="loader.gif"></div>');
        var Vid = ''
        var Cid = ''
        var vendorid = $("#Vendord").val();
        var customerid = $("#Customerd").val();
        if ($('#i_Vendor').is(':checked') == true) {
            Vid = id
        } else {
            Vid = null;
        }
        if ($('#i_Customer').is(':checked') == true) {
            Cid = id
        } else {
            Cid = null;
        }
        $.ajax({
            url: "<?php echo base_url('cash_register/cash/tb') ?>",
            method: "POST",
            data: {
                'fromdate': $("#from_date").val(),
                'todate': $("#to_date").val(),
                'vendor': Vid,
                'customer': Cid,
                'vendorid': vendorid,
                'customerid': customerid
            },
            success: function(data) {
                // console.log(data);
                $("#tb").html(data);
            }
        });
    }

    function checkrefno() {
        var refval = $("#refno").val();
        $.ajax({
            url: "<?php echo base_url('ref-no/') ?>",
            method: "POST",
            data: {
                "refval": refval,
            },
            success: function(data) {
                
                if (data == 1) {
                    checkref = 1
                    toastr.warning('Reference No Already Exists', 'Warning', 'positionclass:toast-bottom-full-width');
                    return false;
                }
            }
        });
    }

    function editcheckrefno() {
        $.ajax({
            url: "<?php echo base_url('editref-no/') ?>",
            method: "POST",
            data: {
                "refval": $("#editrefno").val(),
                "id": $("#Id").val(),
            },
            success: function(data) {
                
                if (data == 1) {
                    editcheckref = 1
                    toastr.warning('Reference No Already Exists', 'Warning', 'positionclass:toast-bottom-full-width');
                    return false;
                }
            }
        });
    }

    function showmodel(cashid) {
        $("#customer-div").show();
        $("#vendor-div").show();
        $.ajax({
            url: "<?php echo base_url('cash_register/cash/edit'); ?>",
            method: "POST",
            data: {
                cashid: cashid,
            },
            success: function(data) {
                data_array = $.parseJSON(data)
                console.log(data_array);
                $("#Id").val(data_array[0].id);
                $('.cash-save-box .form-group').find('select').prop('disabled',true);
                $('.cash-save-box .form-group').find('[tmp]').show();
                $('.cash-save-box .form-group').find('fieldset').hide();
                // if (data_array[0].txn_type == 1) {
                //     $("#VendorId").val(data_array[0].customer_id);
                //     $("#customer-div").hide();
                // } else {
                //     $("#CustomerId").val(data_array[0].customer_id);
                //     $("#vendor-div").hide();
                // }
                $("#VendorId").val(data_array[0].customer_id);
                $("#CustomerId").val(data_array[0].customer_id);
                $("#BankId").val(data_array[0].bank_account);
                $("#Amount").val(data_array[0].amount);
                $("#editrefno").val(data_array[0].reference_no);
                $("#PaymentDate").val(data_array[0].PaymentDate);
                $("#dr_cr").val(data_array[0].dr_cr);
                $("#narration").val(data_array[0].narration);
                $("#editrefno").show();
                $("#refno").hide();
                $("#myModalLabel21").text("Update Cash Data");
                $("#UpdateBtn").show();
                $("#AddBtn").hide();
            }
        })
    }

    function CashSubmit1() {
        checkrefno();
        if (checkref == 1) {
            checkref = '';
            // toastr.warning('Reference No Already Exists', 'Warning', 'positionclass:toast-bottom-full-width');
            return false;
        }
        var customerId = '';
        var txntype = '';
        // console.log($("#VendorId").val());
        if ($("#VendorId").val() != '') {
            customerId = $("#VendorId").val();
            txntype = 1;
        } 
        else if ($("#CustomerId").val() != '') {
            customerId = $("#CustomerId").val();
            txntype = 2;
        } else {
            customerId = $("#BankId").val();
            txntype = 3;
        }
        if ($("#VendorId").val() == '' && $("#CustomerId").val() == '' && $("#BankId").val() == '') {
            toastr.warning('Please Select Vendor, Customer or Bank', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#Amount").val() == '') {
            toastr.warning('Please Enter Amount', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#refno").val() == '') {
            toastr.warning('Please Enter Reference No.', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#PaymentDate").val() == '') {
            toastr.warning('Please Enter Payment Date.', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#dr_cr").val() == '') {
            toastr.warning('Select Dr./Cr.', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        $.ajax({
            url: "<?php echo base_url('cash_register/cash/save') ?>",
            method: "POST",
            data: {
                "Amount": $("#Amount").val(),
                "refno": $("#refno").val(),
                "customerId": customerId,
                "txntype": txntype,
                'PaymentDate': $("#PaymentDate").val(),
                'dr_cr': $("#dr_cr").val(),
                'narration': $("#narration").val()
            },
            beforeSend: function() {
                $('#AddBtn').prop("disabled", true);
                $('#AddBtn').html(
                    '<i class="fa fa-spinner fa-spin"></i> ADD'
                );
            },
            complete: function() {
                $('#AddBtn').prop("disabled", false);
                $('#AddBtn').html('ADD');
            },
            success: function(data) {
                if (data == 1) {
                    toastr.success('Saved Succesfully.', 'Success', 'positionclass:toast-bottom-full-width');
                    location.reload();
                }
            }
        });
    }

    function Cashupdate() {
        ;
        editcheckrefno();
        if (editcheckref == 1) {
            editcheckref = '';
            toastr.warning('Reference No Already Exists', 'Warning', 'positionclass:toast-bottom-full-width');
            return false;
        }
        var customerId = '';
        var txntype = '';
        // if ($("#VendorId").val() != '') {
        //     customerId = $("#VendorId").val();
        //     txntype = 1;
        // } else {
        //     customerId = $("#CustomerId").val();
        //     txntype = 2;
        // }
        if ($("#VendorId").val() == '' && $("#CustomerId").val() == '') {
            toastr.warning('Please Select Vendor or Customer', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#Amount").val() == '') {
            toastr.warning('Please Enter Amount', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#editrefno").val() == '') {
            toastr.warning('Please Enter Reference No.', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#PaymentDate").val() == '') {
            toastr.warning('Please Enter Payment Date.', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
         if ($("#dr_cr").val() == '') {
            toastr.warning('Select Dr./Cr.', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        var currentdate = new Date();
        var datetime = (currentdate.getFullYear()) + "-" +
            (currentdate.getMonth() + 1) + "-" +
            currentdate.getDate() + " " +
            currentdate.getHours() + ":" +
            currentdate.getMinutes() + ":" +
            currentdate.getSeconds();

        $.ajax({
            url: "<?php echo base_url('cash_register/cash/update') ?>",
            method: "POST",
            data: {
                "Id": $("#Id").val(),
                "Amount": $("#Amount").val(),
                "refno": $("#editrefno").val(),
                "customerId": customerId,
                "txntype": txntype,
                'PaymentDate': $("#PaymentDate").val(),
                'dr_cr': $("#dr_cr").val(),
                'narration': $("#narration").val(),
                'update': datetime
            },
            beforeSend: function() {
                $('#UpdateBtn').prop("disabled", true);
                $('#UpdateBtn').html(
                    '<i class="fa fa-spinner fa-spin"></i> UPDATE'
                );
            },
            complete: function() {
                $('#UpdateBtn').prop("disabled", false);
                $('#UpdateBtn').html('UPDATE');
            },
            success: function(data) {
                
                if (data == 1) {
                    toastr.success('Updated Succesfully.', 'Success', 'positionclass:toast-bottom-full-width');
                    location.reload();
                }

            }
        });
    }
    $('.delete_checkbox').click(function() {
        if ($(this).is(':checked')) {
            $(this).closest('tr').addClass('removeRow');
        } else {
            $(this).closest('tr').removeClass('removeRow');
        }
    });
    $('#delete_all').click(function() {
        var checkbox = $('.delete_checkbox:checked');
        var table = 'cash_register';
        if (checkbox.length > 0) {
            var checkbox_value = [];
            $(checkbox).each(function() {
                checkbox_value.push($(this).val());
            });
            $.ajax({
                url: "<?=base_url()?>delete-data/",
                method: "POST",
                data: {
                    checkbox_value: checkbox_value,
                    table: table
                },
                success: function(data) {
                    $('.removeRow').fadeOut(1500);
                }
            })
        } else {
            alert('Select atleast one record');
        }
    })
</script>