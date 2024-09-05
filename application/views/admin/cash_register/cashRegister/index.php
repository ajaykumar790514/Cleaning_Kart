<div class="page-wrapper">
    <div class="container-fluid" style="max-width: 100% !important;">
        <div class="row page-titles">
            <div class="col-md-5 col-8 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('offers-coupons/' . $menu_id); ?>">Cash Register</a></li>
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
                                        <h3 class="card-title" id="test">Cash Register</h3>
                                        <h6 class="card-subtitle"></h6>
                                    </div>

                                    <div class="float-left col-md-6 col-lg-6 col-sm-6">
                                        <button class="float-right btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever="Add Cash Data">Add Cash Data</button>
                                    </div>


                                </div>
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
    <input type="hidden" name="tb" value="">
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
                    <h4 class="modal-title" id="myModalLabel21">Add Cash Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <form class="ajaxsubmit needs-validation reload-tb" action="" method="post" enctype=multipart/form-data> -->
                    <div class="modal-body">

                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
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
                            <div class="col-6">
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Amount:</label>
                                    <input type="number" class="form-control" name="Amount" id="Amount">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Reference No:</label>
                                    <input type="text" name="refno" class="form-control" value="" id="refno">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <input type="button" class="btn btn-danger waves-light" onclick="CashSubmit1()" value="ADD" />
                    </div>

                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#showModal-xl').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('whatever')
            var data_url = button.data('url')
            var modal = $(this)
            $('#showModal-xl .modal-title').text(recipient)
            $('#showModal-xl .modal-body').load(data_url);
        })

        $('#showModal').on('click', function(event) {
            $('#showModal .modal-body').show();
        })

        $('#is_Vendor').click(function(e) {
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
        $('#is_Customer').click(function(e) {
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

        function loadtb(url = null) {
            if (url != null) {
                var tbUrl = url;
            } else {
                var tbUrl = $('[name="tb"]').val();
            }

            if (tbUrl != '') {
                $('#tb').load(tbUrl);
            }
        }

        loadtb();

        $(document).on('click', '.pag-link', function(event) {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
            var search = $('#tb-search').val();
            $.post($(this).attr('href'), {
                    search: search
                })
                .done(function(data) {
                    $('#tb').html(data);
                })
            return false;
        })

        function CashSubmit1() {
            debugger;
            var customerId = '';
            var txntype = '';
            if ($("#VendorId").val() != '') {
                customerId = $("#VendorId").val();
                txntype = 1;
            } else {
                customerId = $("#CustomerId").val();
                txntype = 2;
            }
            if ($("#Amount").val() == '') {
                toastr.warning('Please Enter Amount', 'Warning', 'positionclass:toast-bottom-full-width');
                return;
            }
            if ($("#refno").val() == '') {
                toastr.warning('Please Enter Amount', 'Warning', 'positionclass:toast-bottom-full-width');
                return;
            }
            $.ajax({
                url: "<?php echo base_url('cash_register/cash/save') ?>",
                method: "POST",
                data: {
                    "Amount": $("#Amount").val(),
                    "refno": $("#refno").val(),
                    "customerId": customerId,
                    "txntype": txntype
                },
                success: function(data) {
                    debugger;
                    alert("success");
                    $('.success').fadeIn(200).show();
                    $('.error').fadeOut(200).hide();
                }
            });
        }
        // $(document).on("submit", '.ajaxsubmit', function(event) {
        //     event.preventDefault();
        //     $this = $(this);

        //     $.ajax({
        //         url: $this.attr("action"),
        //         type: $this.attr("method"),
        //         data: new FormData(this),
        //         cache: false,
        //         contentType: false,
        //         processData: false,
        //         success: function(data) {
        //             console.log(data);
        //             // return false;

        //             data = JSON.parse(data);

        //             if (data.res == 'success') {
        //                 if (!$this.hasClass("update-form")) {
        //                     $('[type="reset"]').click();
        //                 }

        //                 if ($this.hasClass("reload-tb")) {
        //                     loadtb();
        //                 }

        //                 if ($this.hasClass("reload-page")) {
        //                     setTimeout(function() {
        //                         window.location.reload();
        //                     }, 1000);
        //                 }

        //                 if ($this.hasClass("btn-click")) {
        //                     setTimeout(function() {
        //                         var btn_target = $this.attr("btn-target");
        //                         $(btn_target).click();
        //                     }, 1000);
        //                 }
        //             }
        //             alert(data.msg);
        //             // alert_toastr(data.res,data.msg);
        //         }
        //     })
        //     return false;
        // })
    </script>
    <!-- //###### ANKIT MAIN CONTENT  ######// -->

    <script type="text/javascript">
        function getid(proid) {
            $("#pro_content" + proid).load("<?php echo base_url('master-data/view_product_images/') ?>" + proid)
        }

        var timer;
        var timeout = 100;
        $(document).on('keyup', '#tb-search', function(event) {
            if (event.keyCode == 13) {
                $("#datatable").html('<div class="text-center"><img src="loader.gif"></div>');
                clearTimeout(timer);
                timer = setTimeout(function() {
                    var search = $('#tb-search').val();
                    // console.log(search);
                    var tbUrl = $('[name="tb"]').val();
                    $.post(tbUrl, {
                            search: search
                        })
                        .done(function(data) {
                            $('#tb').html(data);
                            if ($('#tb-search').val() !== '') {
                                document.getElementById("tb-search").focus();
                                var search = $('#tb-search').val();
                                $('#tb-search').val('');
                                $('#tb-search').val(search);
                            }
                        })
                }, timeout);

                return false;
            }
        })
    </script>
    <script type="text/javascript">
        function validate_date() {
            var start_date = $("#start_date").val();
            var expiry_date = $("#expiry_date").val();
            if (start_date >= expiry_date) {
                msg = "Start date should be less than expiry date";
                document.getElementById('msg').style.color = 'red';
                document.getElementById('msg').innerHTML = msg;
            }

        }
    </script>