<!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Orders Details</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                    <!-- <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            
                            <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10">
                                    <i style="animation-play-state: paused !important;" class="mdi mdi-filter text-white"></i>
                                </button>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- .left-right-aside-column-->
                            <div class="card-body">
                                <h4 class="card-title">All Orders</h4>   
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="example-date-input" class="control-label">From date</label>
                                            <input class="form-control" type="date" value="<?php if(isset($_SESSION['order_table_filters']['from_date'])){ echo $_SESSION['order_table_filters']['from_date'];} ?>" id="from-date">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                        <label for="example-date-input" class="control-label">To date</label>
                                            <input class="form-control" type="date" value="<?php if(isset($_SESSION['order_table_filters']['to_date'])){ echo $_SESSION['order_table_filters']['to_date']; }?>" id="end-date">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="control-label">Order Status:</label>
                                            <select class="form-control" style="width:100%;" id="order-status" data-placeholder="Choose">
                                                <option value="">Select</option>
                                                <?php if(isset($orderStatus) && $orderStatus!==FALSE){ ?>
                                                    <?php foreach ($orderStatus as $status) { ?>
                                                    <option value="<?php echo $status['id']; ?>" <?php if(isset($_SESSION['order_table_filters']['status_ids']) &&  $status['id'] == $_SESSION['order_table_filters']['status_ids'][0]) {echo "selected"; } ?>>
                                                        <?php echo $status['name']; ?>
                                                    </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="control-label">Payment Method:</label>
                                            <select class="form-control" style="width:100%;" id="payment-method" data-placeholder="Choose">
                                                <option value="">Select</option>
                                                <option value="cod" <?php if(isset($_SESSION['order_table_filters']['payment_method'])){if($_SESSION['order_table_filters']['payment_method'] == 'cod'){echo "selected";}
                                                    }?>>COD</option>
                                                    <option value="online" <?php if(isset($_SESSION['order_table_filters']['payment_method'])){if($_SESSION['order_table_filters']['payment_method'] == 'online'){echo "selected";}
                                                    }?>>Online</option>
                                                <!-- <?php
                                                    if($orderPaymentStatusMaster!==FALSE){
                                                        foreach($orderPaymentStatusMaster as $paymentmode){
                                                            echo '<option value="'.$paymentmode['name'].'">'.$paymentmode['name'].'</option>';
                                                        }
                                                    }
                                                ?> -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="control-label">Customer Mobile:</label>
                                            <input class="form-control" type="text" value="<?php if(isset($_SESSION['order_table_filters']['customer_mobile'])){ echo $_SESSION['order_table_filters']['customer_mobile']; }?>" id="customer-mobile">
                                        </div>
                                    </div>
                                    <div class="col-4 mb-2">
                                        <button class="btn btn-warning clear-filter">Clear All</button>
                                        <button class="btn btn-primary apply-filter">Apply Filters</button>
                                    </div>
                                </div>                     
                                <div class="contact-page-aside">
                                    <div id="table-responsive">
                                        
                                    </div>
                                    <!-- .left-aside-column-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    /*$(document).ready(function() {
                        $('.printPopUp').click(function(e) {*/
                    function printPopUp(id){
                        if (id === 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'You cannot print bill for this order!'
                            })
                        }else{
                            var newwindow = window.open('orders/print/bill/'+id, '', 'height=1000,width=950');
                            if (window.focus) {
                                newwindow.focus();
                            }
                            return false;
                        }
                    }        
                            /*e.preventDefault();
                            
                        });
                    });*/

                    var product_list = function () {
                        var tmp = null;
                        $.ajax({
                            'async': false,
                            'type': "POST",
                            'global': false,
                            'url': "orders/getOrderStatus",
                            'success': function (data) {
                                tmp = data;
                                var ele = document.getElementById('product_list_add_new');
                                $.each(JSON.parse(data), function(index,value){
                                    ele.innerHTML = ele.innerHTML + '<option value="' + value.id + '">' + value.name + '</option>';
                                });
                            }
                        });
                        return tmp;
                    }();

                    $("#table-responsive").jsGrid({
                        filtering: true,
                        width: "100%",
                        height:"auto", 
                        sorting:true,
                        paging:true,
                        pageLoading: true,
                        autoload:true,
                        pageSize:10,
                        pageButtonCount: 5,
                        controller: {
                            loadData :  function(filter){
                                var d = $.Deferred();
                                $.ajax({
                                    type:"GET",
                                    url: "orders/getOrders",
                                    data: {filter:filter,shop_id:"<?php echo $_SESSION['user_data']['id']?>"},
                                    dataType: "json"
                                }).done(function(response) {
                                    d.resolve(response);
                                });
                                return d.promise();
                            },
                           
                        },
                        fields: [
                            {
                                name:"id",
                                type:"hidden",
                                css:"hide"
                            },
                            {
                                name: "order_id",
                                title: "ID",
                                itemTemplate: function(val ) { 
                                    // return $("<a>").attr("href", 'orders/'+val.row_id).text(val.order);
                                    return $("<a>").attr({
                                    href: 'orders/'+val.row_id,
                                    target: '_blank',
                                    }).text(val.order);
                                    
                                },
                                align: "center",
                                width: 120
                            },
                            {
                                name: "orderid",
                                title: "Order ID",
                                itemTemplate: function(val ) {
                                    return $("<p>").text(val);
                                },
                                align: "center",
                                width: 120
                                 
                            },
                            // {
                            //     name: "invoice_no",
                            //     title: "Bill No",
                            //     itemTemplate: function(val ) {
                            //         return $("<p>").text(val);
                            //     },
                            //     align: "center",
                            //     width: 120
                            // },
                            // {
                            //     name: "shop_name",
                            //     title: "Shop Name",
                            //     itemTemplate: function(val ) {
                            //         return $("<p>").text(val);
                            //     },
                            //     align: "center",
                            //     width: 120
                            // },
                            {
                                name: "customer_name",
                                title: "Customer Name",
                                // type: "text",
                                // itemTemplate: function(val ) {
                                //     return $("<p>").text(val);
                                // },
                                align: "center",
                                width: 120
                            },
                            {
                                name: "order_date",
                                title: "Order Date",
                                itemTemplate: function(val ) {
                                    return $("<p>").text(val);
                                },
                                align: "center",
                                width: 120
                            },
                            {
                                name: "delivery_slot",
                                title: "Delivery Slot",
                                itemTemplate: function(val ) {
                                    return $("<p>").text(val);
                                },
                                align: "center",
                                width: 120
                            },
                            {
                                name: "total_value",
                                title: "Total Value",
                                itemTemplate: function(val ) {
                                    return $("<p>").text(val);
                                },
                                align: "center",
                                width: 120
                            },
                            // {
                            //     name: "total_savings",
                            //     title: "Total Savings",
                            //     itemTemplate: function(val ) {
                            //         return $("<p>").text(val);
                            //     },
                            //     align: "center",
                            //     width: 120
                            // },
                            // {
                            //     name: "payment_method",
                            //     title: "Payment Method",
                            //     itemTemplate: function(val ) {
                            //         return $("<p>").text(val);
                            //     },
                            //     align: "center",
                            //     width: 120
                            // },
                            {
                                name: "status_name",
                                title: "Status",
                                // type: "select",
                                // width: 100,
                                // items:  JSON.parse(product_list),
                                // valueField: "id",
                                // textField: "name",
                                // validate:"required"
                            },
                            {
                                name: "print_bill",
                                title: "Print Bill",
                                itemTemplate: function(val ) {
                                    return $("<p>").attr("onclick","printPopUp("+val.row_id+")").append('<i class="mdi mdi-printer text-warning" style="font-size:30px;"></i>');
                                },
                                align: "center",
                                width: 120
                            }
                        ],
                    });

                </script>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar" style="">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Advanced Filters <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li class="float-right"  style="padding-bottom:20px;">
                                        <button class="btn btn-warning clear-filter">Clear All</button>
                                        <button class="btn btn-primary apply-filter">Apply Filters</button>
                                </li>
                                <li><b>Filter By Date</b></li>
                                <li>
                                    <div class="form-group">
                                        <label for="example-date-input" class="col-2 col-form-label">From</label>
                                        <div class="col-10">
                                            <input class="form-control" type="date" value="<?php if(isset($_SESSION['order_table_filters']['from_date'])){ echo $_SESSION['order_table_filters']['from_date'];} ?>" id="from-date">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label for="example-date-input" class="col-2 col-form-label">To</label>
                                        <div class="col-10">
                                            <input class="form-control" type="date" value="<?php if(isset($_SESSION['order_table_filters']['to_date'])){ echo $_SESSION['order_table_filters']['to_date']; }?>" id="end-date">
                                        </div>
                                    </div>
                                </li>
                                <li class="d-block m-t-30"><b>Order Status</b>
                            </li>
                                <li style="width: 100%">
                                    <select class="select" id="order-status" style="width: 100%" data-placeholder="Choose">
                                        <option value="">Select Order Status</option>
                                    <?php
                                        if(isset($orderStatus) && $orderStatus!==FALSE){ ?>
                                           
                                            <?php foreach ($orderStatus as $status) { ?>
                                                <option value="<?php echo $status['id']; ?>" <?php if(isset($_SESSION['order_table_filters']['status_ids']) &&  $status['id'] == $_SESSION['order_table_filters']['status_ids'][0]) {echo "selected"; } ?>>
                                                    <?php echo $status['name']; ?>
                                                </option>
                                                <?php } } ?>
                                    </select>
                                </li>
                                <li class="d-block m-t-30"><b>Payment Method</b></li>
                                <li style="width: 100%">
                                    <select class="select" id="payment-method" style="width: 100%" data-placeholder="Choose">
                                    <option value="">Select</option>
                                    <option value="cod" <?php if(isset($_SESSION['order_table_filters']['payment_method'])){if($_SESSION['order_table_filters']['payment_method'] == 'cod'){echo "selected";}

                                    }?>>COD</option>
                                    <option value="online" <?php if(isset($_SESSION['order_table_filters']['payment_method'])){if($_SESSION['order_table_filters']['payment_method'] == 'online'){echo "selected";}

                                    }?>>Online</option>
                                        <!-- <?php
                                            if($orderPaymentStatusMaster!==FALSE){
                                                foreach($orderPaymentStatusMaster as $paymentmode){
                                                    echo '<option value="'.$paymentmode['name'].'">'.$paymentmode['name'].'</option>';
                                                }
                                            }
                                        ?> -->
                                   </select>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label for="example-date-input" class="col-2 col-form-label"><b>Customer Mobile</b></label>
                                        <div class="col-10">
                                            <input class="form-control" type="text" value="<?php if(isset($_SESSION['order_table_filters']['customer_mobile'])){ echo $_SESSION['order_table_filters']['customer_mobile']; }?>" id="customer-mobile">
                                        </div>
                                    </div>
                                </li>
                                <li class="float-right"  style="padding-top:20px;">
                                    <button class="btn btn-warning clear-filter">Clear All</button>
                                    <button class="btn btn-primary apply-filter">Apply Filters</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <script>
                    $('.apply-filter').click(function(e){
                        $.ajax({
                                type:"POST",
                                url: "orders/setOrderSessionFilters",
                                data: {start_date: $('#from-date').val(),end_date: $('#end-date').val(),status: $('#order-status option:selected').val(),payment_method:$('#payment-method option:selected').val(),customer_mobile: $('#customer-mobile').val()},
                                'success': function (data) {
                                    $("#table-responsive").jsGrid("loadData");
                                }
                            });
                    });
                    $('.clear-filter').click(function(e){
                        $('#from-date').val('');
                        $('#end-date').val('');
                        $('#order-status').val('');
                        $('#payment-method').val('');
                        $.ajax({
                                type:"POST",
                                url: "orders/clearOrderSessionFilters",
                                'success': function (data) {
                                    $("#table-responsive").jsGrid("loadData");
                                }
                            });
                    });
                </script>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->