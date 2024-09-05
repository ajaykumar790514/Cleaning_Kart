<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="stocks">Stock</a></li>
            <?php if (isset($cat_data['id']) && isset($cat_data['name'])) { ?>
                <li class="breadcrumb-item active"><?php echo '<a href="stocks/' . $cat_data['id'] . '">' . $cat_data['name'] . '</a>'; ?></li>
            <?php } ?>
            <li class="breadcrumb-item active"><?php echo $sub_cat_data['name']; ?></li>
        </ol>
    </div>
    <!--
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
                                <h3 class="card-title" id="test">Stock Data</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>
                            <div class="float-right col-md-2 col-lg-2 col-sm-12">
                                <div id="responsive-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b>Add New Stock Entry</b>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Product:</label>
                                                        <select class="form-control select2" id="product_list_add_new" style="width:100%;">
                                                            <!-- <option value="">Select Product</option> -->
                                                        </select>
                                                        <div class="w-100 p-img"></div>
                                                    </div>
                                                    <h5 style="color:green;" class="mb-3" id="product_tax"></h5>
                                                    <div class="row" >
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Vendors:</label>
                                                                <select class="form-control select2" id="vendor_list_add_new" style="width:100%;">
                                                                    <option value="">Select Vendor</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Quantity:</label>
                                                                <input type="number" class="form-control" min="0" id="recipient-qty">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">MRP:</label>
                                                                <input type="number" class="form-control" step="0.01" min="0.00" id="recipient-mrp">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type='checkbox' name='is_discount' id="is_discount" />
                                                                <label for="is_discount">Additional Discount: </label>
                                                                <input type="number" onchange="getdiscount(this.value)" class="form-control" min="0" id="Discount" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Purchase Rate:</label>
                                                                <input type="number" class="form-control" step="0.01" min="0.00" id="recipient-pr">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Selling Rate:</label>
                                                                <input type="number" class="form-control" step="0.01" min="0.00" id="recipient-sr">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">MFG Date:</label>
                                                                <input type="date" class="form-control" name="mfg_date" id="mfg_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Expiry Date:</label>
                                                                <input type="date" class="form-control" name="expiry_date" id="expiry_date">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Invoice No:</label>
                                                                <input type="text" class="form-control" name="invoice_no" id="invoice_no">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Invoice Date:</label>
                                                                <input type="date" class="form-control" name="invoice_date" id="invoice_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Total Value:</label>
                                                                <input type="text" class="form-control" name="total_value" id="total_value" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Total Tax:</label>
                                                                <input type="text" class="form-control" name="total_tax" id="total_tax" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type='checkbox' name='is_igst' id="is_igst" />
                                                                <label for="is_igst">IGST</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <table class="table full-color-table full-warning-table ">
                                                            <thead>
                                                                <tr>
                                                                    <th>Image</th>
                                                                    <th>Current Qty</th>
                                                                    <th>Purchase Rate</th>
                                                                    <th>Selling rate</th>
                                                                    <th>MRP</th>
                                                                    <th>MFG Date</th>
                                                                    <th>Expiry Date</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="table-data">

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" id="add-new-entry" class="btn btn-danger waves-effect waves-light" type="submit">Create</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="edit-stock-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog  modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b>Edit Stock</b>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form>
                                                    <input type="text" class="form-control" name="stock_id" id="stock_id" hidden>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="control-label">Product:</label>
                                                        <select class="form-control select2" id="product_list_edit" style="width:100%;" disabled="true">
                                                        </select>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Vendors:</label>
                                                                <select class="form-control select2" id="vendor_list_edit" style="width:100%;">

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Quantity:</label>
                                                                <input type="number" class="form-control" min="0" id="edit-qty">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">MRP:</label>
                                                                <input type="number" class="form-control" step="0.01" min="0.00" id="edit-mrp">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type='checkbox' name='edit_is_discount' id="edit_is_discount" />
                                                                <label for="edit_is_discount">Additional Discount: </label>
                                                                <input type="number" onchange="getdiscountEdit(this.value)" class="form-control" min="0" id="EditDiscount" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Purchase Rate:</label>
                                                                <input type="number" class="form-control" step="0.01" min="0.00" id="edit-pr">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Selling Rate:</label>
                                                                <input type="number" class="form-control" step="0.01" min="0.00" id="edit-sr" name="edit-sr">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">MFG Date:</label>
                                                                <input type="date" class="form-control" name="edit_mfg_date" id="edit_mfg_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Expiry Date:</label>
                                                                <input type="date" class="form-control" name="edit_expiry_date" id="edit_expiry_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Total Value:</label>
                                                                <input type="text" class="form-control" name="edit_total_value" id="edit_total_value" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Total Tax:</label>
                                                                <input type="text" class="form-control" name="edit_total_tax" id="edit_total_tax" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Invoice No:</label>
                                                                <input type="text" class="form-control" name="edit_invoice_no" id="edit_invoice_no">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Invoice Date:</label>
                                                                <input type="date" class="form-control" name="edit_invoice_date" id="edit_invoice_date">
                                                            </div>
                                                        </div>

                                                        <div class="col-6">
                                                            <div class="form-group">
                                                                <input type='checkbox' name='edit_is_igst' id="edit_is_igst" />
                                                                <label for="edit_is_igst">IGST</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" id="edit-stock-entry" class="btn btn-danger waves-effect waves-light" type="submit">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="float-right btn btn-primary" data-toggle="modal" data-target="#responsive-modal" id="add-entry">Add Stock</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="grid_table"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Batch Import/Export</h4>                        
                                <form class="form-horizontal m-t-40" id="importForm" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Export template to upload stocks:</label> &nbsp;&nbsp;&nbsp;
                                        <button id="downloadTemplate" class="btn btn-warning">Download From Here</button>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label>Default file upload</label>
                                        <input type="file" class="form-control" name="import_file" id="exampleInputFile" aria-describedby="fileHelp">
                                    </div>
                                    <div class="form-group">
                                        <button id="uploadButton" class="btn btn-success">Import</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <script>
                    $('#is_discount').click(function(e) {
                        if ($('#is_discount').is(':checked') == true) {
                            $("#Discount").removeAttr('disabled', false);
                        } else {
                            $("#Discount").attr('disabled', true);
                            $("#Discount").val('');
                        }
                    })
                    $('#edit_is_discount').click(function(e) {
                        if ($('#edit_is_discount').is(':checked') == true) {
                            $("#EditDiscount").removeAttr('disabled', false);
                        } else {
                            $("#EditDiscount").attr('disabled', true);
                            $("#Discount").val('');
                        }
                    })




                    function getdiscount(e) {
                        if ($("#recipient-mrp").val() != '') {

                            var discount_value = $('#Discount').val();
                            var mrp = parseInt($("#recipient-mrp").val());
                            var product_tax = $('#product_list_add_new option:selected').val();
                            var tax = product_tax.split(',');
                            var tax_value = parseFloat(tax[1]);
                            var mrp_without_tax = ((mrp * 100)/(tax_value + 100)).toFixed(2);
                            var discounted_mrp = mrp_without_tax - (discount_value * mrp_without_tax / 100);
                            var discounted_mrp_with_tax = discounted_mrp + (tax_value * discounted_mrp / 100);
                            $("#recipient-pr").val(discounted_mrp_with_tax.toFixed(2));

                            // var qty = $('#recipient-qty').val();
                            // var purchase_rate = $('#recipient-pr').val();
                            // var total = qty * purchase_rate;
                            // $('#total_value').val(total.toFixed(2));
                            // var total_tax = (tax_value * total) / 100;
                            // $('#total_tax').val(total_tax.toFixed(2));

                            // return false;


                            
                            // var discount = (e * $("#recipient-mrp").val() / 100);
                            // var discountValue = (parseInt($("#recipient-mrp").val()) - parseInt(discount));
                            // $("#recipient-pr").val(discountValue.toFixed(2));

                            var qty = $('#recipient-qty').val();
                            var purchase_rate = $('#recipient-pr').val();
                            var result = qty * purchase_rate;
                            $('#total_value').val(result.toFixed(2));

                            //calculate total tax value
                            var product_tax = $('#product_list_add_new option:selected').val();
                            var tax = product_tax.split(',');
                            var tax_value = tax[1];
                            var total = parseInt(purchase_rate) + Number(tax_value);
                            var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                            $('#total_tax').val(total_tax.toFixed(2));
                        } else {
                            $("#Discount").val('');
                        }

                    }

                    function getdiscountEdit(e) {
                        if ($("#edit-mrp").val() != '') {

                            var discount_value = e;
                            var mrp = parseInt($("#edit-mrp").val());
                            var product_tax = $('#product_list_edit option:selected').val();
                            var tax = product_tax.split(',');
                            var tax_value = parseFloat(tax[1]);
                            var mrp_without_tax = ((mrp * 100)/(tax_value + 100)).toFixed(2);
                            var discounted_mrp = mrp_without_tax - (discount_value * mrp_without_tax / 100);
                            var discounted_mrp_with_tax = discounted_mrp + (tax_value * discounted_mrp / 100);
                            $("#edit-pr").val(discounted_mrp_with_tax.toFixed(2));




                            // var discount = (e * $("#edit-mrp").val() / 100);
                            // var discountValue = (parseInt($("#edit-mrp").val()) - parseInt(discount));
                            // $("#edit-pr").val(discountValue.toFixed(2));

                            var qty = $('#edit-qty').val();
                            var purchase_rate = $('#edit-pr').val();
                            var result = qty * purchase_rate;
                            $('#edit_total_value').val(result.toFixed(2));
                            //calculate total tax value
                            var product_tax = $('#product_list_edit option:selected').val();
                            var tax = product_tax.split(',');
                            var tax_value = tax[1];
                            var total = parseInt(purchase_rate) + Number(tax_value);
                            var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                            $('#edit_total_tax').val(total_tax.toFixed(2));

                        } else {
                            $("#EditDiscount").val('');
                        }

                    }
                    $('#exampleInputFile').change(function(e) {
                        formdata = new FormData();
                        if ($(this).prop('files').length > 0) {
                            file = $(this).prop('files')[0];
                            formdata.append("import_file", file);
                        }
                        $.ajax({
                            url: "Phpexcel_ci/verifyStockUpload",
                            type: "POST",
                            data: formdata,
                            processData: false, // tell jQuery not to process the data
                            contentType: false // tell jQuery not to set contentType
                        }).done(function(data) {
                            var obj = JSON.parse(data);
                            if (obj.status === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Good to go for upload.',
                                    text: obj.message
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: obj.message
                                })
                            }
                        });
                        return false;
                    });

                    $('#uploadButton').click(function(e) {
                        e.preventDefault();
                        var form = document.getElementById('importForm');
                        var formData = new FormData(form);
                        $.ajax({
                            url: "Phpexcel_ci/importStockdata",
                            type: "POST",
                            data: formData,
                            processData: false, // tell jQuery not to process the data
                            contentType: false // tell jQuery not to set contentType
                        }).done(function(data) {
                            var obj = JSON.parse(data);
                            if (obj.status === true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success.',
                                    text: obj.message
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: obj.message
                                })
                            }
                        });
                        return false;
                    });

                    $('#downloadTemplate').click(function(e) {
                        e.preventDefault();
                        window.location.href = '<?php echo base_url('Phpexcel_ci/exportStockImportTemplate?parent_cat_id=' . $parent_cat_id . '&shop_id=' . $_SESSION['user_data']['id']); ?>';
                    });


                    // $('#product_list_add_new').on('change', function (){


                    // });

                    $('#product_list_add_new').change(function(e) {


                        e.preventDefault();
                        
                        var qty = $('#recipient-qty').val();
                        var purchase_rate = $('#recipient-pr').val();
                        var result = qty * purchase_rate;
                        //calculate total tax value
                        var product_tax = $('#product_list_add_new option:selected').val();
                        var tax = product_tax.split(',');
                        var tax_value = tax[1];
                        var total = parseInt(purchase_rate) + Number(tax_value);
                        var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                        $('#total_tax').val(total_tax.toFixed(2));

                        var product_tax = $('#product_list_add_new option:selected').val();
                        var abc = product_tax.split(',');
                        $('#product_tax').html('GST Rate = ' + abc[1] + '%');

                        $('.p-img').load(`stocks/getProductimg?product_id=${abc[0]}`);

                        $.ajax({
                            type: "GET",
                            url: "stocks/getStockData",
                            data: {
                                parent_cat_id: "<?php echo $parent_cat_id ?>",
                                filter: {
                                    product_id: $("#product_list_add_new option:selected").val(),
                                    pageSize: '100',
                                    pageIndex: '1',
                                }
                            },
                            dataType: "json",
                            'success': function(response) {
                                console.log(response);
                                var ele = '';
                                $.each(response.data, function(index, value) {
                                    tax = value.qty;
                                    // ele = ele + '<tr>';
                                    // ele = ele + '<td>' + value.img + '</td>';
                                    // ele = ele + '<td>' + value.qty + '</td>';
                                    // ele = ele + '<td>' + value.purchase_rate + '</td>';
                                    // ele = ele + '<td>' + value.selling_rate + '</td>';
                                    // ele = ele + '<td>' + value.mrp + '</td>';
                                    // ele = ele + '<td>' + value.mfg_date + '</td>';
                                    // ele = ele + '<td>' + value.expiry_date + '</td>';
                                    // ele = ele + '<tr>';
                                        

                                    ele += `<tr>`;
                                    ele += `<td><img src='${value.img}' class='img-sm'> </td>`;
                                    ele += `<td>${value.qty}</td>`;
                                    ele += `<td>${value.purchase_rate}</td>`;
                                    ele += `<td>${value.selling_rate}</td>`;
                                    ele += `<td>${value.mrp}</td>`;
                                    ele += `<td>${value.mfg_date}</td>`;
                                    ele += `<td>${value.expiry_date}</td>`;
                                    ele += `<tr>`;
                                });
                                $('#table-data').html(ele);
                            }
                        })
                    });
                    $('#product_list_edit').change(function(e) {
                        var qty = $('#edit-qty').val();
                        var purchase_rate = $('#edit-pr').val();
                        var result = qty * purchase_rate;
                        $('#edit_total_value').val(result.toFixed(2));
                        //calculate total tax value
                        var product_tax = $('#product_list_edit option:selected').val();
                        var tax = product_tax.split(',');
                        var tax_value = tax[1];
                        var total = parseInt(purchase_rate) + Number(tax_value);
                        var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                        $('#edit_total_tax').val(total_tax.toFixed(2));

                    });
                    $('#add-new-entry').click(function(e) {
                        e.preventDefault();
                        ;
                        var count = 0;
                        var man = '';
                        if ($("#product_list_add_new option:selected").val() == '' || $("#product_list_add_new option:selected").val() == '0') {
                            man = man + 'Select <strong>Product</strong>';
                            count++;
                        }
                        if ($("#vendor_list_add_new option:selected").val() == '' || $("#vendor_list_add_new option:selected").val() == '0') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + 'Select <strong>Vendor</strong>';
                            count++;
                        }
                        if (count > 0) {
                            man = man + ' and fill ';
                        } else {
                            man = man + ' fill ';
                        }

                        if ($('#recipient-qty').val() == '') {
                            man = man + '<strong>Quantity</strong>';
                            count++;
                        }
                        if ($('#recipient-mrp').val() == '') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + '<strong>MRP</strong>';
                            count++;
                        }
                        if ($('#recipient-pr').val() == '') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + '<strong>Purchase Rate</strong>';
                            count++;
                        }
                        if ($('#recipient-sr').val() == '') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + '<strong>Selling Rate</strong>';
                            count++;
                        }
                        if (count > 0) {
                            Swal.fire(
                                'Fields Mandatory',
                                'Please ' + man + '.',
                                'error'
                            )
                        } else {
                            var html_content = '<table id="table" border=1 style="font-size:12px; width:100%;"><thead><tr><th>Product Name</th><th>Qty</th><th>Purchase Rate</th><th>MRP</th><th>Selling Rate</th></tr></thead><tbody><tr><td>' + $("#product_list_add_new option:selected").text() + '</td><td>' + $('#recipient-qty').val() + '</td><td>' + $('#recipient-pr').val() + '</td><td>' + $('#recipient-mrp').val() + '</td><td>' + $('#recipient-sr').val() + '</td></tr></tbody></table>';
                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: true
                            })

                            swalWithBootstrapButtons.fire({
                                title: 'Are you sure to add below entry?',
                                text: "You won't be able to revert this!",
                                html: html_content,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, please!',
                                cancelButtonText: 'No, cancel!',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    ;
                                    if ($("#is_igst").prop("checked") == true) {
                                        $igst = 1;
                                    } else {
                                        $igst = 0;
                                    }
                                    $.ajax({
                                        type: "POST",
                                        url: "stocks/insertStockData",
                                        data: {
                                            shop_id: "<?php echo $_SESSION['user_data']['id'] ?>",
                                            item: {
                                                product_id: $("#product_list_add_new option:selected").val(),
                                                vendor_id: $("#vendor_list_add_new option:selected").val(),
                                                purchase_rate: $('#recipient-pr').val(),
                                                selling_rate: $('#recipient-sr').val(),
                                                qty: $('#recipient-qty').val(),
                                                mrp: $('#recipient-mrp').val(),
                                                mfg_date: $('#mfg_date').val(),
                                                expiry_date: $('#expiry_date').val(),
                                                is_igst: $igst,
                                                total_value: $('#total_value').val(),
                                                total_tax: $('#total_tax').val(),
                                                invoice_no: $('#invoice_no').val(),
                                                invoice_date: $('#invoice_date').val(),
                                                AdditionalDiscount: $("#Discount").val(),
                                            }
                                        },
                                        'success': function(data) {
                                            if (data == 'true')
                                                swalWithBootstrapButtons.fire(
                                                    'Added!',
                                                    'Your stock has been updated with new entry.',
                                                    'success',
                                                ).then((result) => {
                                                    location.reload();
                                                })
                                        }
                                    });
                                } else if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.cancel
                                ) {
                                    swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'You\'ve cancelled the transaction',
                                        'error'
                                    )
                                }
                            })
                        }
                    });
                    $('#edit-stock-entry').click(function(e) {
                        var count = 0;
                        var man = '';
                        if ($("#product_list_edit option:selected").val() == '' || $("#product_list_edit option:selected").val() == '0') {
                            man = man + 'Select <strong>Product</strong>';
                            count++;
                        }
                        if ($("#vendor_list_edit option:selected").val() == '' || $("#vendor_list_edit option:selected").val() == '0') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + 'Select <strong>Vendor</strong>';
                            count++;
                        }
                        if (count > 0) {
                            man = man + ' and fill ';
                        } else {
                            man = man + ' fill ';
                        }

                        if ($('#edit-qty').val() == '') {
                            man = man + '<strong>Quantity</strong>';
                            count++;
                        }
                        if ($('#edit-mrp').val() == '') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + '<strong>MRP</strong>';
                            count++;
                        }
                        if ($('#edit-pr').val() == '') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + '<strong>Purchase Rate</strong>';
                            count++;
                        }
                        if ($('#edit-sr').val() == '') {
                            if (count > 0) {
                                man = man + ', ';
                            }
                            man = man + '<strong>Selling Rate</strong>';
                            count++;
                        }
                        if (count > 0) {
                            Swal.fire(
                                'Fields Mandatory',
                                'Please ' + man + '.',
                                'error'
                            )
                        } else {
                            const swalWithBootstrapButtons = Swal.mixin({
                                customClass: {
                                    confirmButton: 'btn btn-success',
                                    cancelButton: 'btn btn-danger'
                                },
                                buttonsStyling: true
                            })

                            swalWithBootstrapButtons.fire({
                                title: 'Are you sure to update this entry?',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, please!',
                                cancelButtonText: 'No, cancel!',
                                reverseButtons: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    if ($("#edit_is_igst").prop("checked") == true) {
                                        $igst = 1;
                                    } else {
                                        $igst = 0;
                                    }

                                    return $.ajax({
                                        type: "POST",
                                        url: "stocks/updateCustomStockData",
                                        dataType:'JSON',
                                        data: {
                                            shop_id: "<?php echo $_SESSION['user_data']['id'] ?>",
                                            item: {
                                                id: $('#stock_id').val(),
                                                product_id: $("#product_list_edit option:selected").val(),
                                                vendor_id: $("#vendor_list_edit option:selected").val(),
                                                purchase_rate: $('#edit-pr').val(),
                                                selling_rate: $('#edit-sr').val(),
                                                qty: $('#edit-qty').val(),
                                                mrp: $('#edit-mrp').val(),
                                                mfg_date: $('#edit_mfg_date').val(),
                                                expiry_date: $('#edit_expiry_date').val(),
                                                is_igst: $igst,
                                                total_value: $('#edit_total_value').val(),
                                                total_tax: $('#edit_total_tax').val(),
                                                invoice_no: $('#edit_invoice_no').val(),
                                                invoice_date: $('#edit_invoice_date').val(),
                                                EditDiscount: $('#EditDiscount').val()
                                            }
                                        },
                                        'success': function(data) {
                                            // debugger;
                                            if (data.res=='error') {
                                                swalWithBootstrapButtons.fire(
                                                    'Not Saved!',
                                                    data.msg,
                                                    'error',
                                                )
                                            }
                                            else{
                                                 swalWithBootstrapButtons.fire(
                                                    'Success!',
                                                    'Your stock has been updated with new entry.',
                                                    'success',
                                                ).then((result) => {
                                                    $("#grid_table").jsGrid("loadData");
                                                    location.reload();
                                                })
                                            }
                                           
                                        }
                                    });
                                } else if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.cancel
                                ) {
                                    swalWithBootstrapButtons.fire(
                                        'Cancelled',
                                        'You\'ve cancelled the transaction',
                                        'error'
                                    )
                                }
                            })
                        } //end else
                    });

                    var product_list = function() {
                        var tmp = null;
                        $.ajax({
                            'async': false,
                            'type': "POST",
                            'global': false,
                            'url': "stocks/product_list",
                            'data': {
                                parent_cat_id: "<?php echo $parent_cat_id ?>"
                            },
                            'success': function(data) {
                                tmp = data;
                                //console.log(tmp);
                                var ele = document.getElementById('product_list_add_new');
                                $.each(JSON.parse(data), function(index, value) {
                                    ele.innerHTML = ele.innerHTML + '<option value="' + value.id + ',' + value.gst + '">' + value.name + '</option>';
                                });
                            }
                        });
                        return tmp;
                    }();

                    var vendor_list = function() {
                        var tmp = null;
                        $.ajax({
                            'async': false,
                            'type': "POST",
                            'global': false,
                            'url': "stocks/vendor_list",
                            'data': {
                                shop_id: "<?php echo $shop_id ?>"
                            },
                            'success': function(data) {
                                tmp = data;
                                // console.log(tmp);
                                var ele = document.getElementById('vendor_list_add_new');
                                $.each(JSON.parse(data), function(index, value) {
                                    ele.innerHTML = ele.innerHTML + '<option value="' + value.id + '">' + value.name + ' </option>';
                                });
                            }
                        });
                        return tmp;
                    }();

                    $("#grid_table").jsGrid({
                        width: "100%",
                        height: "800px",

                        filtering: true,
                        inserting: false,
                        editing: false,
                        deleteing: false,
                        sorting: true,
                        paging: true,
                        pageLoading: true,
                        autoload: true,
                        pageSize: 25,
                        pageButtonCount: 5,
                        deleteConfirm: "Do you really want to delete this data?",

                        controller: {
                            loadData: function(filter) {
                                var d = $.Deferred();
                                $.ajax({
                                    type: "GET",
                                    url: "stocks/getStockData",
                                    data: {
                                        filter: filter,
                                        parent_cat_id: "<?php echo $parent_cat_id ?>"
                                    },
                                    dataType: "json"
                                }).done(function(response) {
                                    d.resolve(response);
                                });
                                return d.promise();
                            },
                            /*
                                                        insertItem : function(item){
                                                            return $.ajax({
                                                                type:"POST",
                                                                url: "stocks/insertStockData",
                                                                data: {item:item,shop_id:"<?php echo $_SESSION['user_data']['id'] ?>"},
                                                            });
                                                        },*/
                            updateItem: function(item) {
                                // console.log(item);
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-success',
                                        cancelButton: 'btn btn-danger'
                                    },
                                    buttonsStyling: true
                                })

                                swalWithBootstrapButtons.fire({
                                    title: 'Are you sure to update this entry?',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, please!',
                                    cancelButtonText: 'No, cancel!',
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        return $.ajax({
                                            type: "POST",
                                            url: "stocks/updateStockData",
                                            dataType:'JSON',
                                            data: {
                                                item: item,
                                                shop_id: "<?php echo $_SESSION['user_data']['id'] ?>"
                                            },
                                            'success': function(data) {

                                                if (data.res=='error') {
                                                    swalWithBootstrapButtons.fire(
                                                        'Not Saved!',
                                                        data.msg,
                                                        'error',
                                                    )
                                                }
                                                else{
                                                     swalWithBootstrapButtons.fire(
                                                        'Success!',
                                                        'Your stock has been updated with new entry.',
                                                        'success',
                                                    ).then((result) => {
                                                        $("#grid_table").jsGrid("loadData");
                                                        location.reload();
                                                    })
                                                }
                                            }
                                        });
                                    } else if (
                                        /* Read more about handling dismissals below */
                                        result.dismiss === Swal.DismissReason.cancel
                                    ) {
                                        swalWithBootstrapButtons.fire(
                                            'Cancelled',
                                            'You\'ve cancelled the transaction',
                                            'error'
                                        )
                                    }
                                })
                            },
                            deleteItem: function(item) {
                                return $.ajax({
                                    type: "POST",
                                    url: "stocks/deleteStockData",
                                    data: {
                                        item: item,
                                        shop_id: "<?php echo $_SESSION['user_data']['id'] ?>"
                                    },
                                });
                            },

                        },
                        fields: [{
                                name: "id",
                                type: "hidden",
                                css: "hide"
                            },
                            {
                                type: "control",
                                itemTemplate: function(value, item) {
                                    var $iconPencil = $("<i>").attr({
                                        class: "fa fa-edit"
                                    });
                                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);

                                    var $customButton = $("<button>").attr({
                                            class: 'btn',
                                            // target: '_blank',
                                        }).append($iconPencil)
                                        .click(function(e) {
                                            // alert("ID: " +item.id);
                                            $('#edit-stock-modal').modal('toggle');


                                            var product_list_edit = function() {
                                                var tmp = null;
                                                $.ajax({
                                                    'async': false,
                                                    'type': "POST",
                                                    'global': false,
                                                    'url': "stocks/product_list",
                                                    'data': {
                                                        parent_cat_id: "<?php echo $parent_cat_id ?>"
                                                    },
                                                    'success': function(data) {
                                                        tmp = data;
                                                        // console.log(tmp);
                                                        var ele = document.getElementById('product_list_edit');
                                                        $.each(JSON.parse(data), function(index, value) {
                                                            if (value.id == item.product_id)
                                                                ele.innerHTML = ele.innerHTML + '<option value="' + value.id + ',' + value.gst + '" selected>' + value.name + '</option>';
                                                            else
                                                                ele.innerHTML = ele.innerHTML + '<option value="' + value.id + ',' + value.gst + '">' + value.name + '</option>';
                                                        });
                                                    }
                                                });
                                                return tmp;
                                            }();


                                            var vendor_list_edit = function() {
                                                var tmp = null;
                                                $.ajax({
                                                    'async': false,
                                                    'type': "POST",
                                                    'global': false,
                                                    'url': "stocks/vendor_list",
                                                    'data': {
                                                        shop_id: "<?php echo $shop_id ?>"
                                                    },
                                                    'success': function(data) {
                                                        tmp = data;
                                                        // console.log(tmp);
                                                        var ele = document.getElementById('vendor_list_edit');
                                                        $.each(JSON.parse(data), function(index, value) {
                                                            if (value.id == item.vendor_id)
                                                                ele.innerHTML = ele.innerHTML + '<option value="' + value.id + '" selected>' + value.name + '</option>';
                                                            else
                                                                ele.innerHTML = ele.innerHTML + '<option value="' + value.id + '">' + value.name + '</option>';
                                                        });
                                                    }
                                                });
                                                return tmp;
                                            }();
                                            if (item.is_igst == 1)
                                                $("#edit_is_igst").prop("checked", true);
                                            $('#stock_id').val(item.id);
                                            $('#edit-qty').val(item.qty);
                                            $('#edit-mrp').val(item.mrp);
                                            $('#edit-pr').val(item.purchase_rate);
                                            $('#edit-sr').val(item.selling_rate);
                                            $('#edit_mfg_date').val(item.mfg_date);
                                            $('#edit_expiry_date').val(item.expiry_date);
                                            $('#edit_total_value').val(item.total_value);
                                            $('#edit_total_tax').val(item.total_tax);
                                            $('#edit_invoice_no').val(item.invoice_no);
                                            $('#edit_invoice_date').val(item.invoice_date);
                                            $('#EditDiscount').val(item.AdditionalDiscount);
                                            e.stopPropagation();
                                        });

                                    return $result.add($customButton);
                                }
                            },
                            {
                                name: "img",
                                title: "Product Image",
                                itemTemplate: function(val) {
                                    return $("<img>").attr("src", val).attr("onerror", "this.src='public/assets/images/Default_Image_Thumbnail.png';").attr("style", "width: 100px;max-height:100px;");
                                },
                                align: "center",
                                width: 120
                            },
                            {
                                name: "product_id",
                                title: "Product Name",
                                type: "select",
                                width: 100,
                                items: JSON.parse(product_list),
                                valueField: "id",
                                textField: "name",
                                validate: "required"
                            },
                            {
                                name: "qty",
                                title: "Quantity",
                                type: "text",
                                width: 80,
                                validate: "required"
                            },
                            {
                                name: "AdditionalDiscount",
                                title: "Additional Discount",
                                type: "text",
                                width: 140,
                                // validate: "required"
                            },
                            {
                                name: "purchase_rate",
                                title: "Purchase Rate",
                                type: "text",
                                width: 150,
                            },
                            {
                                name: "mrp",
                                title: "MRP",
                                type: "text",
                                width: 150,
                                validate: "required"
                            },
                            {
                                name: "selling_rate",
                                title: "Selling Rate",
                                type: "text",
                                width: 150,
                                validate: "required"
                            },
                            {
                                name: "status",
                                title: "Status",
                                type: "select",
                                width: 100,
                                items: [{
                                    id: "",
                                    name: "Select Status"
                                }, {
                                    id: "1",
                                    name: "Enabled"
                                }, {
                                    id: "0",
                                    name: "Disabled"
                                }],
                                valueField: "id",
                                textField: "name",
                                validate: "required"
                            },
                            {
                                name: "mfg_date",
                                title: "MFG Date",
                                type: "date",
                                width: 150,
                                validate: "required"
                            },
                            {
                                name: "expiry_date",
                                title: "Expiry Date",
                                type: "date",
                                width: 150,
                                validate: "required"
                            },
                            {
                                name: "invoice_date",
                                title: "Invoice Date",
                                type: "date",
                                width: 150,
                                validate: "required"
                            },
                            {
                                name: "vendor_name",
                                title: "Vendor Name",
                            },


                        ],
                    });
                </script>
                <script>
                    $('#recipient-pr').keyup(function() {
                        var qty = $('#recipient-qty').val();
                        var purchase_rate = $('#recipient-pr').val();
                        var result = qty * purchase_rate;
                        $('#total_value').val(result.toFixed(2));

                        //calculate total tax value
                        var product_tax = $('#product_list_add_new option:selected').val();
                        var tax = product_tax.split(',');
                        var tax_value = tax[1];
                        var total = parseInt(purchase_rate) + Number(tax_value);
                        var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                        $('#total_tax').val(total_tax.toFixed(2));
                    });
                    $('#recipient-qty').keyup(function() {
                        var qty = $('#recipient-qty').val();
                        var purchase_rate = $('#recipient-pr').val();
                        var result = qty * purchase_rate;
                        $('#total_value').val(result.toFixed(2));

                        //calculate total tax value
                        var product_tax = $('#product_list_add_new option:selected').val();
                        var tax = product_tax.split(',');
                        var tax_value = tax[1];
                        var total = parseInt(purchase_rate) + Number(tax_value);
                        var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                        $('#total_tax').val(total_tax.toFixed(2));

                    });
                    $('#edit-pr').keyup(function() {
                        var qty = $('#edit-qty').val();
                        var purchase_rate = $('#edit-pr').val();
                        var result = qty * purchase_rate;
                        $('#edit_total_value').val(result.toFixed(2));
                        //calculate total tax value
                        var product_tax = $('#product_list_edit option:selected').val();
                        var tax = product_tax.split(',');
                        var tax_value = tax[1];
                        var total = parseInt(purchase_rate) + Number(tax_value);
                        var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                        $('#edit_total_tax').val(total_tax.toFixed(2));

                    });
                    $('#edit-qty').keyup(function() {
                        var qty = $('#edit-qty').val();
                        var purchase_rate = $('#edit-pr').val();
                        var result = qty * purchase_rate;
                        $('#edit_total_value').val(result.toFixed(2));

                        //calculate total tax value
                        var product_tax = $('#product_list_edit option:selected').val();
                        var tax = product_tax.split(',');
                        var tax_value = tax[1];
                        var total = parseInt(purchase_rate) + Number(tax_value);
                        var total_tax = Number(result) - (Number(result) * (100 / (100 + Number(tax_value))));
                        $('#edit_total_tax').val(total_tax.toFixed(2));
                    });
                </script>