<style>



    .lbl {
        text-align: center;
        font-weight: 400;
        bottom: 0;
        width: 100%;
        left: 10%;
    }

    .center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #ui-id-1 {
        width: 300px !important;
        padding-left: 0 !important;
        text-align: center;
    }

    .container-fluid{
        font-size: 13px!important;
    }
    #ui-id-2 {
        /*width: 300px !important;
        padding-left: 0 !important;
        text-align: center;*/
        width: max-content;
        max-width: 457px !important;
        padding-left: 0 !important;
        text-align: left ;
        font-size: 13px!important;
    }

    #ui-id-1 li {
        list-style-type: none;
        border: 1px solid grey;
        padding: 5px;
        width: 100%;
        cursor: pointer;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 1px;
    }

    #ui-id-2 li {
        list-style-type: none;
        border: 1px solid grey;
        padding: 5px;
        width: 100%;
        cursor: pointer;
        border-radius: 8px;
        background: #fff;
        margin-bottom: 1px;
    }

    #ui-id-1 :hover {
        background-color: lightblue;
    }

    #ui-id-2 :hover {
        background-color: lightblue;
    }

    #ui-id-1 li a {
        text-decoration: none;
    }

    #ui-id-2 li a {
        text-decoration: none;
    }

    .switch {
        position: relative;
        display: inline-block;
        /*width: 90px;
        height: 34px;*/

        width: 100%;
        max-width: 60px;
        height: 20px;
    }

    .switch input {
        display: none;
    }

    table th {
        padding: 4px !important;
    }

    .slider {
        /*margin: -9px;*/
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ca2222;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
       /* height: 29px;
        width: 26px;*/
        height: 20px;
        width: 40%;
        /*left: 5px;*/
        left: 0px;
        /*bottom: 8px;*/
        bottom: 0px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2ab934;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        right: 0;
        left: auto;
       /* -webkit-transform: translateX(55px);
        -ms-transform: translateX(55px);
        transform: translateX(55px);*/
    }

    /*------ ADDED CSS ---------*/
    .on {
        display: none;
        left: 30% !important;
    }


    .on,
    .off {
        color: white;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;

        font-size: 12px;
        font-family: Verdana, sans-serif;
    }

    .off {
        left: 62%;
    }

    input:checked+.slider .on {
        display: block;
    }

    input:checked+.slider .off {
        display: none;
    }

    /*--------- END --------*/

    /* Rounded sliders */
    .slider.round {
        border-radius: 20px;
        /*width: 106px;
        margin-top: 4px;*/
        width: 100%;
        height: 20px;
        margin-top: 4px;
    }

    .slider.round:before {
        /*border-radius: 50%;*/
        border-radius: 20px;
    }

   
</style>
<div class="row mt-4">
    <!-- Column -->
    <div class="col-lg-9 col-md-9">
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 mt-2">
                        <div class="pull-left first_li">
                            <label for="item" class="control-label" style="font-weight: 400;">Find or Scan Item or Receipt</label>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-1">
                        <div class="pull-left">
                            <input type="text" name="item" value="" id="item" placeholder="Start typing Item Name or scan Barcode..." class="form-control input-sm ui-autocomplete-input" size="50" tabindex="1" autocomplete="off">
                            <span class="ui-helper-hidden-accessible" role="status"></span>
                        </div>
                    </div>
                    <!-- <div class="col-lg-2 col-md-2">
                        <div class="pull-right">
                            <button class="float-right btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#showModal" data-whatever=""><span class="fa fa-tag">&nbsp;</span>New Item</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div id="datatable">
            <div id="grid_table" class="table-responsive">
                <!-- <form action="<?=base_url()?>pos/save_order" method="post" class="save_order"> -->
                <table class="jsgrid-table" id="item-table">
                    <thead>
                        <tr class="jsgrid-header-row">
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:7%">Delete</th>
                            <th class="jsgrid-header-cell jsgrid-align-center">Product Code</th>
                            <th class="jsgrid-header-cell jsgrid-align-center">Item Name</th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:6%">MRP </th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:8%">Selling Price</th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:8%">Quantity</th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:7%">Free</th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:6%">Total</th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:9%">Discount / Unit Price</th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:9%">Discount2 / Unit Selling Price</th>
                            <th class="jsgrid-header-cell jsgrid-align-center" style="width:9%">Profit %</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="noItem">
                            <td class="jsgrid-cell jsgrid-align-center" colspan="10">
                                <div class="alert alert-dismissible alert-info mb-0">There are no Items in the cart.</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            <!-- </form> -->
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $('body').on('click','.save_order,.proforma_invoice',function(event){
        event.preventDefault();
        var t = $(this);
        
        var clickFrom = 'save_order';

        if ($(this).hasClass('proforma_invoice')) {
            var clickFrom = 'proforma_invoice';
            save_order(clickFrom);
            return false;
        }
        
       

        // alert(clickFrom);
        // return false;


        Swal.fire({
              icon:'warning',
              title: 'You want to save this order ?',
              // timer:3000,
              showConfirmButton: true,
              showCancelButton: true,
              confirmButtonText: `Yes`,
              cancelButtonText: `No`,
            }).then((result) => {
                if(result.value==true){

                // alert('yes');
                    var orderId = $('input[name=manual_order_number]').val();
                    $.ajax({
                        url:'<?=base_url()?>check-order-id',
                        type:'post',
                        data:{orderId:orderId},
                        dataType:'JSON',
                        success:function(data){
                            if (data.res=='success') {
                               
                                 save_order(clickFrom);
                            }
                            else{
                                toastr.error(data.msg, data.res, 'positionclass:toast-bottom-full-width');
                                return false;
                            }
                            
                            
                        },
                        error:function() {
                            toastr.error('Order Number available', 'error', 'positionclass:toast-bottom-full-width');
                            return false;
                        }
                    })
               
               
                
                }
            }).catch(swal.noop);
        return false;
    });


    function save_order(clickFrom) {
        
        // var formData = t.serializeArray();
        var formData = [];
        var cusId = $(".cusId").val();
        if (typeof cusId === 'undefined' || cusId=='' ) {
            toastr.warning('Please select Customer', 'Warning', 'positionclass:toast-bottom-full-width');
            return false;
        }
        
        if ($('[name=is_pay_later]').val()==1) {
            if ($('[name=due_date]').val()=='') {
                toastr.warning('Please enter Due Date', 'Warning', 'positionclass:toast-bottom-full-width');
                return false;
            }
        }

        var TotalValue          = $('#sale_totals').find('.TotalValue').text();
        var TaxValue            = $('#sale_totals').find('.TaxValue').text();


        // var TotalValue_new          = $('#sale-record1').find('.TotalValue').text();
        // var TaxValue_new            = $('#sale-record1').find('.TaxValue').text();

        // console.log(TotalValue);
        // console.log(TaxValue);
        // console.log('new');
        // console.log(TotalValue_new);
        // console.log(TaxValue_new);
        //  return false;

        
        var address             = $('#customer_totals').find('.Address').text();
        var isPayLater          = $('[name=is_pay_later]').val();
        var dueDate             = $('[name=due_date]').val();
        var payment_method      = $('[name=payment_method]').val();
        var ref_no_or_remark    = $('[name=reference_no_or_remark]').val();
        var same_as_billing     = $('[name=same_as_billing]').val();
        var shipping_address    = $('[name=shipping_address]').val();
        var order_number        = $('[name=manual_order_number]').val();
        var narration           = $('[name=narration]').val();
        var order_date          = $('[name=manual_order_date]').val();


        formData.push({ name: "orderId", value: order_number });
        formData.push({ name: "user_id", value: cusId });
        formData.push({ name: "total_value", value: TotalValue });
        formData.push({ name: "total_tax", value: TaxValue });
        formData.push({ name: "random_address", value: address });
        formData.push({ name: "is_pay_later", value: isPayLater });
        formData.push({ name: "due_date", value: dueDate });
        formData.push({ name: "payment_method", value: payment_method });
        formData.push({ name: "ref_no_or_remark", value: ref_no_or_remark });
        formData.push({ name: "same_as_billing", value: same_as_billing });
        formData.push({ name: "shipping_address", value: shipping_address });
        formData.push({ name: "narration", value: narration });
        formData.push({ name: "order_date", value: order_date });

        var product_id = [];
        var inventory_id = [];
        var qty = [];
        var free = [];
        var price_per_unit = [];
        var purchase_rate = [];
        var purchase_rate = [];
        var mrp = [];
        var total_price = [];
        var tax = [];
        var tax_value = [];
        var offer_applied = [];
        var discount_type = [];
        var offer_applied2 = [];
        var discount_type2 = [];
        $('#item-table tbody tr').each(function(){
            if (!$(this).hasClass('noItem')) {
                product_id.push($(this).find('td.product_id').text());
                inventory_id.push($(this).find('td.inventory_id').text());
                qty.push($(this).find('td.quantity1 [name=qty]').val());
                free.push($(this).find('td.free [name=free]').val());
                price_per_unit.push($(this).find('td.omrp').text());
                purchase_rate.push($(this).find('td.purchase_rate').text());
                mrp.push($(this).find('td.mrp').text());
                total_price.push($(this).find('td.totalamount').text());
                tax.push($(this).find('td.TotalTaxValue').text());
                tax_value.push($(this).find('td.TaxValue1').text());
                offer_applied.push($(this).find('td.Disc [name=discount]').val());
                discount_type_v = 0;
                if ($(this).find('td.Disc [type=checkbox]').is(':checked')) {
                    discount_type_v = 1;
                }
                discount_type.push(discount_type_v);
                offer_applied2.push($(this).find('td.Disc2 [name=discount2]').val());
                discount_type2_v = 0;
                if ($(this).find('td.Disc2 [type=checkbox]').is(':checked')) {
                    discount_type2_v = 1;
                }
                discount_type2.push(discount_type2_v);
            }
            
        })

        if (product_id=='') {
            toastr.warning('Please select Product', 'Warning', 'positionclass:toast-bottom-full-width');
            return false;
        }



        formData.push({name:  "product_id", value:product_id})
        formData.push({name:  "inventory_id", value:inventory_id})
        formData.push({name:  "qty", value:qty})
        formData.push({name:  "free", value:free})
        formData.push({name:  "price_per_unit", value:price_per_unit})
        formData.push({name:  "purchase_rate", value:purchase_rate})
        formData.push({name:  "mrp", value:mrp})
        formData.push({name:  "total_price", value:total_price})
        formData.push({name:  "tax", value:tax})
        formData.push({name:  "tax_value", value:tax_value})
        formData.push({name:  "offer_applied", value:offer_applied})
        formData.push({name:  "discount_type", value:discount_type})
        formData.push({name:  "offer_applied2", value:offer_applied2})
        formData.push({name:  "discount_type2", value:discount_type2})        
        



        if (clickFrom=='save_order') {
            // var id = $(this).val();
            $.ajax({
                url:'<?=base_url()?>pos/check_customer_credit_limit',
                type:'POST',
                data:{business_id:cusId,TotalValue:TotalValue},
                dataType:'JSON',
                success:function(data) {
                    console.log(data);
                    if (data.res=='success' || isPayLater!=1) {
                        // return false;
                        $.ajax({
                            url: "<?= base_url() ?>pos/save_order",
                            type: 'post',
                            dataType: "json",
                            data: formData,
                            success: function(data) {
                                console.log(data);
                                if (data.res=='success') {
                                   Swal.fire({
                                      icon: data.res,
                                      text: data.msg,
                                      showConfirmButton:false,
                                      position: 'center',
                                      footer: ' <a href="'+data.new_order+'" class="btn btn-primary mr-2">New Order</a><a href="'+data.invoice_url+'" class="btn btn-info mr-2">Invoice</a>'
                                    }) 
                                }
                                else{
                                   Swal.fire({
                                      icon: data.res,
                                      text: data.msg,
                                      // toast: true,
                                      position: 'center'
                                    })  
                                }
                                
                            }
                        })
                    }
                    else{
                        Swal.fire({
                                      icon: data.res,
                                      text: data.msg,
                                      // toast: true,
                                      position: 'center'
                                    }) 
                        // console.log(data);
                    }
                }
            })  
        }
        else {
            $.post('<?=base_url()?>pos_orders/proforma-invoice',formData, function (data) {
                var w = window.open('about:blank');
                w.document.open();
                w.document.write(data);
                w.document.close();
            });
        }


    }

    // jQuery.fn.exists = function(){return this.length>0;}
    function hasAttr(t,name) { 
        return t.attr(name) !== undefined; 
    };
    $('body').on('input','input',function(){
        var t = $(this);
        if (hasAttr(t,"maxLength")) {
            max_lenght = t.attr('maxLength');
            val_lenght = t.val().length;
            if (val_lenght > max_lenght){
                t.val(t.val().slice(0, max_lenght));
            } 
        }
    })

    $('body').on('change','input[name=manual_order_number]',function(e){
        check_order_id();
    })

    function check_order_id() {
        var orderId = $('input[name=manual_order_number]').val();
        $.ajax({
            url:'<?=base_url()?>check-order-id',
            type:'post',
            data:{orderId:orderId},
            dataType:'JSON',
            success:function(data){
                if (data.res=='success') {
                    toastr.success(data.msg, data.res, 'positionclass:toast-bottom-full-width');
                    
                }
                else{
                    toastr.error(data.msg, data.res, 'positionclass:toast-bottom-full-width');
                    return false;
                }
                
                
            },
            error:function() {
                toastr.error('Order Number available', 'error', 'positionclass:toast-bottom-full-width');
                return false;
            }
        })
    }
    </script>
    <div class="col-lg-3 col-md-3">
        <div class="card mb-0">

            <div class="card-body pb-0">
                <div class="row mb-1">
                    <div class="col-12 pb-0"><strong>Manual Order Number</strong></div>
                    <div class="col-12 pt-0 text-center">
                        <input type="text" class="form-control" placeholder="Manual Order Number" name="manual_order_number">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 pb-0"><strong>Manual Order Date</strong></div>
                    <div class="col-12 pt-0 text-center">
                        <input type="date" class="form-control" placeholder="Manual Order Date" name="manual_order_date">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <hr style="border: 1px solid black;margin:0px">
                    </div>
                    
                </div>
                
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <button class="btn btn-success save_order">Save Order</button>
                    </div>
                </div>

                <div id="Customer_div" class="table-responsive" style="display:none;">
                    <style type="text/css">
                        .same_as_billing{
                            position: relative!important;
                            opacity: 1!important;
                            margin: auto!important;
                            left: 1px !important;
                            top: 2px !important;
                            cursor: pointer;
                        }
                    </style>
                    <script type="text/javascript">
                        $('body').on('change','.same_as_billing',function(event){
                            var t = $(this);
                            if (t.is(':checked')) {
                                $('[name=same_as_billing]').val(1);
                            }
                            else {
                                $('[name=same_as_billing]').val(0);
                            }
                        })
                    </script>

                    <table class="jsgrid-table" id="customer_totals">
                        <tbody id="Customer-record">
                            <tr class="jsgrid-header-row">

                                <th style="width: 55%;" class="">Customer Name
                                    <input type="hidden" name="cusId" class="cusId">
                                </th>
                                <td style="width: 45%; text-align: right;" class="CusName"></td>
                            </tr>
                            
                            <tr>
                                <th style="width: 55%;">Mobile No.</th>
                                <td style="width: 45%; text-align: right;" class="MobileNo"></td>
                            </tr>
                            <tr>
                                <th style="width: 55%;">Email</th>
                                <td style="width: 45%; text-align: right;" class="Email"></td>
                            </tr>
                            <tr>
                                <th style="width: 55%;">Contact Person Name</th>
                                <td style="width: 45%; text-align: right;" class="ContactPerson"></td>
                            </tr>
                            <tr>
                                <th style="width: 55%;">GSTN</th>
                                <td style="width: 45%;  text-align: right;" class="GSTN"></td>
                            </tr>
                            <tr>
                                <th style="width: 55%;">Address</th>
                                <td style="width: 45%; text-align: right;" class="Address"></td>
                            </tr>
                            <tr>
                                <th style="width: 55%;">
                                    <label data-toggle="collapse" data-target=".shipping_address"> 
                                        Shipping Address 
                                        <input type="checkbox" class="same_as_billing" checked >
                                        <input type="hidden" name="same_as_billing">
                                        
                                    </label>
                                    </th>
                                <td style="width: 45%; text-align: right;">
                                    Same As Billing
                                </td>
                            </tr>
                            <tr class="shipping_address collapse">
                                <th style="width: 100%;" colspan="2">
                                    <textarea class="form-control shipping_address" name="shipping_address" placeholder="Shipping Address"></textarea>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                    <center><button class="btn btn-danger" id="RmoveBtn" onclick="RemoveTable()" style="display: none;"><span class="fa fa-remove">&nbsp;</span>Remove</button></center>

                </div>
                <div class="form-group mb-0" id="select_customer">
                    <label id="customer_label" for="customer" class="control-label text-center lbl " style="margin-bottom: 1em; margin-top: -1em;">Select Customer (Required for Due Payments)</label>
                    <input type="text" name="customer" placeholder="Start typing customer details..." id="customer" class="form-control input-sm ui-autocomplete-input" autocomplete="off">
                    <p></p>
                    <div class="center">
                        <button class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-target="#modalcustomer" data-whatever=""><span class="fa fa-user">&nbsp;</span>New Customer</button>&nbsp;&nbsp;
                        <button class="btn btn-secondary bg-secondary text-white" href="javascript:void(0)" data-toggle="modal" data-target="#" data-whatever=""><span class="fa fa-share">&nbsp;</span>Shortcuts </button>
                    </div>
                </div>
            </div>
            <div class="px-3 py-3 pb-0 pt-0">
                <hr style="border: 1px solid black;margin:0px">
            </div>

            <div class="">
                <div id="" class="table-responsive" style="padding-left: 13px;padding-right: 13px;">
                    <table class="jsgrid-table" >
                        <tbody >
                            
                            <tr class="jsgrid-header-row">
                                <th style="width: 40%;">Is pay later</th>
                                <td style="width: 60%; text-align: right;">
                                    <input type="checkbox" class="is_pay_later" id="is_pay_later" checked>
                                    <input type="hidden" name="is_pay_later" value="1">
                                </td>
                            </tr>
                            <tr class="due_date">
                                <th style="width: 40%;">Due Date</th>
                                <td style="width: 60%; text-align: right;">
                                    <input type="date" name="due_date" id="due_date" class="due_date form-control form-control-sm" data-date-inline-picker="true" >
                                </td>
                            </tr>
                            <tr class="payment-receive">
                                <th style="width: 55%;">Payment Mode</th>
                                <td style="width: 45%; text-align: right;">
                                    <select class="form-control form-control-sm" name="payment_method" class="payment_method" id="payment_method">
                                        <option value="cash">Cash</option>
                                    </select>
                                </td>
                            </tr>

                            <tr class="payment-receive">
                                <th style="width: 100%;" colspan="2">
                                    <label>Reference No. / Remark </label>
                                    <input type="text" name="reference_no_or_remark" id="reference_no_or_remark" class="form-control form-control-sm" placeholder="Reference No. / Remark "> 
                                </th>
                            </tr>

                            <tr class="jsgrid-header-row">
                                <th style="width: 100%;" colspan="2">
                                    <label>Narration</label>
                                    <input type="text" class="narration form-control form-control-sm" id="narration" name="narration" placeholder="Narration">
                                </th>
                            </tr>
                            
                            
                        </tbody>
                    </table>
                </div>
            </div>

            

            <div class="px-3 py-3 pb-0 pt-0">
                <hr style="border: 1px solid black;margin:0px">
            </div>

            <div id="tb">
                <div id="" class="table-responsive" style="padding-left: 13px;padding-right: 13px;">
                    <table class="jsgrid-table" id="sale_totals">
                        <tbody id="sale-record">
                            <tr class="jsgrid-header-row">
                                <th style="width: 55%;">Quantity of 0 Items</th>
                                <td style="width: 45%; text-align: right;">0</td>
                            </tr>
                            <tr>
                                <th style="width: 55%;">Subtotal</th>
                                <td style="width: 45%; text-align: right;">&nbsp;0.00</td>
                            </tr>
                            <tr>
                                <th style="width: 55%; font-size: 150%">Total</th>
                                <td style="width: 45%; font-size: 150%; text-align: right;"><span id="sale_total">&nbsp;0.00</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row pb-2">
                    <div class="col-12 text-center">
                        <button class="btn btn-success save_order">Save Order</button>
                    </div>

                    <div class="col-12 text-center">
                        <button class="btn btn-success proforma_invoice">Proforma Invoice</button>
                    </div>
                </div>
            </div>
            <style type="text/css">
                .pay_later label{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 5px 20px;
                    font-size: 15px;
                    cursor: pointer;
                }
                .is_pay_later{
                    position: relative!important;
                    opacity: 1!important;
                    margin: auto!important;
                    left: -5px !important;
                    cursor: pointer;
                }
            </style>


            
            <script type="text/javascript">
                $('.payment-receive').hide();
                $('body').on('change','.is_pay_later',function(event){
                    var t = $(this);
                    if (t.is(':checked')) {
                        $('.due_date').show();
                        $('.payment-receive').hide();
                        $('[name=is_pay_later]').val(1);
                    }
                    else {
                        $('.due_date').hide();
                        $('.payment-receive').show();
                        $('[name=is_pay_later]').val(0);
                    }
                })
            </script>
        </div>
    </div>
</div>
<div class="modal fade text-left" id="modalcustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel21" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel21">Add Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="ajaxsubmit needs-validation reload-tb" id="AddCustomer" action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Name:</label>
                                    <input type="text" class="form-control" name="name" id="name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Email:</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Mobile:</label>
                                    <input type="number" class="form-control" name="mobile" id="mobile">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Alternate Mobile:</label>
                                    <input type="number" class="form-control" name="alternate_mobile" id="alternate_mobile">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Customer Type:</label>
                                    <input type="text" class="form-control" name="customer_type" id="customer_type">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Customer Category:</label>
                                    <input type="text" class="form-control" name="customer_category" id="customer_category">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Contact Person Name:</label>
                                    <input type="text" class="form-control" name="contact_person_name" id="contact_person_name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Customer Profile:</label>
                                    <input type="text" class="form-control" name="customer_profile" id="customer_profile">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">State:</label>
                                    <select class="form-control select2" style="width:100%;" name="state" id="state" onchange="fetch_city(this.value)">
                                        <option value="">Select State</option>
                                        <?php foreach ($states as $state) { ?>
                                            <option value="<?php echo $state->id; ?>">
                                                <?php echo $state->name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">City:</label>
                                    <select class="form-control select2 city" style="width:100%;" name="city" id="city">

                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">GSTIN:</label>
                                    <input type="text" class="form-control" name="gstin" id="gstin">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Aadhar No.:</label>
                                    <input type="number" class="form-control" name="aadhar_no" id="aadhar_no" maxlength="12">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label">Vendor Code:</label>
                                    <input type="text" class="form-control" onchange="CheckCustomerCode()" name="customer_code" id="customer_code">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Pincode:</label>
                                    <input type="number" class="form-control" name="pincode" id="pincode">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label">Address:</label>
                                    <textarea cols="92" rows="5" class="form-control" name="address" id="address"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button id="btnsubmit" type="button" onclick="SubmitCustomer()" class="btn btn-danger waves-light"><i id="loader" class=""></i>Add</button>
                            <!-- <input type="submit" class="btn btn-danger waves-light" type="submit" value="ADD" /> -->
                        </div>

                </form>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
          </div> -->
        </div>
    </div>
</div>
<style type="text/css">
/*    .switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 20px;
}*/
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
    function RemoveTable() {
        $("#select_customer").show();
        $("#RmoveBtn").hide();
        $("#Customer_div").hide();
        $("#customer").val("");
    }

    function CheckCustomerCode() {
        $.ajax({
            url: "<?php echo base_url('check-customer-code/'); ?>",
            method: "POST",
            data: {
                vendor_code: $("#customer_code").val()
            },
            success: function(data) {
                if (data == 1) {

                    toastr.warning('Customer Code Already Exists', 'Warning', 'positionclass:toast-bottom-full-width');
                    $("#customer_code").val('');
                }
            },
        });
    }

    function SubmitCustomer() {
        if ($("#name").val() == '') {
            toastr.warning('Please fill Customer Name', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#email").val() == '') {
            toastr.warning('Please fill Customer Email', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#mobile").val() == '') {
            toastr.warning('Please fill Customer Mobile', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#state").val() == '') {
            toastr.warning('Please fill State', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#city").val() == '') {
            toastr.warning('Please fill City', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#customer_code").val() == '') {
            toastr.warning('Please fill Customer Code', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#pincode").val() == '') {
            toastr.warning('Please fill Pin Code', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        if ($("#address").val() == '') {
            toastr.warning('Please fill Address', 'Warning', 'positionclass:toast-bottom-full-width');
            return;
        }
        $.ajax({
            url: "<?php echo base_url('pos/pos_data/save'); ?>",
            method: "POST",
            data: {
                name: $("#name").val(),
                email: $("#email").val(),
                mobile: $("#mobile").val(),
                alternate_mobile: $("#alternate_mobile").val(),
                state: $("#state").val(),
                city: $("#city").val(),
                customer_code: $("#customer_code").val(),
                gstin: $("#gstin").val(),
                pincode: $("#pincode").val(),
                address: $("#address").val(),
                customer_type: $("#customer_type").val(),
                customer_category: $("#customer_category").val(),
                contact_person_name: $("#contact_person_name").val(),
                customer_profile: $("#customer_profile").val(),
            },
            success: function(data) {
                // console.log(data);
                var gstin = '';
                if (data=="false") {
                    toastr.warning('Mobile No. Already Exists!', 'Warning', 'positionclass:toast-bottom-full-width');
                    return;
                }
                else{

                    if ($("#gstin").val() != '') {
                        gstin = $("#gstin").val();
                    } else {
                        gstin = "N/A";
                    }
                    if (data == "saved") {
                        $('#customer_totals > tbody  > tr').each(function(i, j) {
                            // $(j).find(".cusId").val(ui.item.value);

                            $(j).find(".CusName").text($("#name").val());
                            $(j).find(".MobileNo").text($("#mobile").val());
                            $(j).find(".Email").text(ui.item.email);
                            $(j).find(".ContactPerson").text($("#contact_person_name").val());
                            $(j).find(".Address").text(ui.item.address);
                            $(j).find(".GSTN").text(gstin);
                        });
                        $('form#AddCustomer').trigger("reset");
                        $("#Customer_div").show();
                        $("#select_customer").hide();
                        $("#RmoveBtn").show();
                        $('#modalcustomer').modal('hide');
                    }
            }
            },
        });
    }
    $("#customer").autocomplete({
        source: function(request, response) {
            // Fetch data
            $.ajax({
                url: "<?= base_url() ?>pos/pos_data/getcustomer",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data) {
                    response(data);
                    console.log(data);
                }
            });
        },
        select: function(event, ui) {
            // Set selection
            $('#customer').val(ui.item.label); // display the selected text
            // console.log(ui.item)
            $("#Customer_div").show();
            $("#select_customer").hide();
            $("#RmoveBtn").show();
            var Gstn = '';
            if (ui.item.gstin != '') {
                Gstn = ui.item.gstin;
            } else {
                Gstn = "N/A";
            }
            $('#customer_totals > tbody  > tr').each(function(i, j) {
                $(j).find(".cusId").val(ui.item.value);
                $(j).find(".CusName").text(ui.item.label);
                $(j).find(".MobileNo").text(ui.item.mobile);
                $(j).find(".Email").text(ui.item.email);
                $(j).find(".CustomerType").text(ui.item.customer_type);
                $(j).find(".Address").text(ui.item.address);
                $(j).find(".GSTN").text(Gstn);
            });
            $("#customer").val("");
        }
    })

   


    $("#item").autocomplete({
        source: function(request, response) {
            // Fetch data
            $.ajax({
                url: "<?= base_url() ?>pos/pos_data/getitem",
                type: 'post',
                dataType: "json",
                data: {
                    search: request.term
                },
                success: function(data) {
                    // debugger
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            // Set selection
            $('#item').val(ui.item.label); // display the selected text
            console.log(ui.item)
            $("#item-table").find("tr.noItem").hide();
            $("#sale-record").hide();
            let ProductTable = '';
            let TotalSaleTb = '';
            var inventoryId = '';
            var totalAmount = '';
            var mrp = '';
            var Quantity = '';
            $('#item-table > tbody  > tr').each(function(i, j) {
                $(this).find(".inventory_id").each(function() {
                    if (ui.item.inventory_id == $(this).html()) {
                        totalAmount = $(j).find(".totalamount").text();
                        mrp = $(j).find(".mrp").text();
                        inventoryId = $(j).find(".inventory_id").text();
                        $(this).closest('tr').find("input").each(function(k) {
                            Quantity = $(this).closest('tr').find("input").val();
                        })
                    }
                });
            });
            if (inventoryId != ui.item.inventory_id) {
                var GetResult = GetSaleRecord(ui.item.mrp, ui.item.tax_value)
                var getV = GetResult.split(",");
                var AmountwithoutTax = getV[0];
                var TaxValue = getV[1];
                var profit =  ui.item.mrp - ui.item.purchase_rate;
                var profit_percentage =   (profit / ui.item.purchase_rate) * 100;
                ProductTable += "<tr class='jsgrid-filter-row' data-product_code='"+ui.item.product_code+"'><td class='jsgrid-cell jsgrid-align-center'><a href='javascript:void(0)' id='DeleteButton' class='btn btn-lg' ><i class='fa fa-trash' style='color:red'></i></a></td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center product_code' style='word-break: break-all;'>" + ui.item.product_code + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center Stock' style='display:none;'>" + ui.item.qty + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center product_id' style='display:none;'>" + ui.item.value + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center inventory_id' style='display:none;'>" + ui.item.inventory_id + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center purchase_rate' style='display:none;'>" + ui.item.purchase_rate + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center TaxValue1' style='display:none;'>" + ui.item.tax_value + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center AmountwithoutTax' style='display:none;'>" + Number(AmountwithoutTax).toFixed(2) + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center TotalTaxValue' style='display:none;'>" + Number(TaxValue).toFixed(2) + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center TotalValue' style='display:none;'>" + (Number(AmountwithoutTax) + Number(TaxValue)).toFixed(2) + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center'>" + ui.item.label + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center omrp'> " + ui.item.mrp + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center mrp'> " + ui.item.mrp + "</td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center sellingPriceForDics2' style='display:none'> " + ui.item.mrp + "</td>";

                // ProductTable += "<td class='jsgrid-cell jsgrid-align-center quantity1'><input type='text'  onkeypress='return /[0-9]/i.test(event.key)'  name='qty' id='quantity' onkeyup='gettotalamount(this.value,`" + ui.item.product_code + "`)'  class='form-control form-control-sm' value='1'></td>";

                ProductTable += "<td class='jsgrid-cell jsgrid-align-center quantity1'><input type='number' name='qty' id='quantity' class='form-control form-control-sm' value='1' min='1'></td>";

                ProductTable += "<td class='jsgrid-cell jsgrid-align-center free'><input type='number' name='free' class='form-control form-control-sm' value='0' min='0'></td>";


                ProductTable += "<td class='jsgrid-cell jsgrid-align-center totalamount'> " + ui.item.mrp + " </td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center Disc'><input type='number' step='0.01'  name='discount' id='discount' onkeyup='getdiscount(this.value,`" + ui.item.inventory_id + "`,`" + ui.item.mrp + "`)' class='form-control form-control-sm discount' value=''><label class='switch'><input type='checkbox' onclick='SetValueBlank(`" + ui.item.inventory_id + "`,`Disc`)' class='togBtn'><div class='slider round'><!--ADDED HTML --><span class='on'>Fixed</span><span class='off'>%</span><!--END--></div></label></td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center Disc2'><input type='number' step='0.01'  name='discount2' id='discount2' onkeyup='getdiscount2(this.value,`" + ui.item.inventory_id + "`)' class='form-control form-control-sm discount' value=''><label class='switch'><input type='checkbox' onclick='SetValueBlank(`" + ui.item.inventory_id + "`,`Disc2`)' class='togBtn2'><div class='slider round'><!--ADDED HTML --><span class='on'>Fixed</span><span class='off'>%</span><!--END--></div></label></td>";
                ProductTable += "<td class='jsgrid-cell jsgrid-align-center profit'>"+ (Number(profit_percentage)).toFixed(2)  +"</td>";

                // ProductTable += "<td class='jsgrid-cell jsgrid-align-center'>Update</td></tr>";
                tableBody = $("#item-table tbody");
                tableBody.append(ProductTable);
            } else {
                if (Number(ui.item.qty) > Number(Quantity)) {
                    // debugger;
                    var totalAmount = ui.item.mrp * (Number(Quantity) + 1);
                    var GetResult = GetSaleRecord(totalAmount, ui.item.tax_value, ui.item.qty)
                    var getV = GetResult.split(",");
                    var AmountwithoutTax = getV[0];
                    var TaxValue = getV[1];
                    $('#item-table > tbody  > tr').each(function(i, j) {
                        $(this).find(".inventory_id").each(function() {
                            if ($(this).html() == inventoryId) {
                                // $(this).closest('tr').find("input").each(function(k) {
                                //     $(this).closest('tr').find("input").val(Number(Quantity) + 1);
                                // })
                                
                                $(j).find("[name=qty]").val(Number(Quantity) + 1).change();
                                // $(j).find(".totalamount").text(Number(totalAmount).toFixed(2));
                                // $(j).find(".AmountwithoutTax").text(Number(AmountwithoutTax).toFixed(2));
                                // $(j).find(".TotalTaxValue").text(Number(TaxValue).toFixed(2));
                                // $(j).find(".TotalValue").text((Number(AmountwithoutTax) + Number(TaxValue)).toFixed(2));
                            }
                        });
                    });

                } else {
                    toastr.warning('you don\'t have enough stock', 'Warning', 'positionclass:toast-bottom-full-width');
                }
            }
            if ($('#item-table >tbody >tr').length == 2 && inventoryId != ui.item.inventory_id) {
                var GetResult = GetSaleRecord(ui.item.mrp, ui.item.tax_value)
                var getV = GetResult.split(",");
                var AmountwithoutTax = getV[0];
                var TaxValue = getV[1];
                var Tquantity = 0;
                var TbRow = $('#item-table >tbody >tr').length - 1;
                $('#item-table > tbody  > tr').each(function(i, j) {
                    $(this).closest('tr').find(".quantity1 input").each(function(k) {
                        Tquantity += parseFloat($(this).closest('tr').find(".quantity1 input").val()) || 0;
                    })
                });
                TotalSaleTb = '<tbody id="sale-record1">\
                            <tr class="jsgrid-header-row">\
                                <th style="width: 55%;" class="ProductQuantity">Quantity of ' + TbRow + ' Items</th>\
                                <td style="width: 45%; text-align: right;" class="SaleQuantity">' + Tquantity + '</td>\
                            </tr>\
                            <tr>\
                                <th style="width: 55%;">Subtotal</th>\
                                <td style="width: 45%; text-align: right;" class="AmountwithoutTax">' + Number(AmountwithoutTax).toFixed(2) + '</td>\
                            </tr>\
                            <tr>\
                                <th style="width: 55%;">Tax Value</th>\
                                <td style="width: 45%; text-align: right;" class="TaxValue">' + Number(TaxValue).toFixed(2) + '</td>\
                            </tr>\
                            <tr>\
                                <th style="width: 55%; font-size: 150%">Total</th>\
                                <td style="width: 45%; font-size: 150%; text-align: right;" class="TotalValue">' + (Number(AmountwithoutTax) + Number(TaxValue)).toFixed(2) + '</td>\
                            </tr>\
                        </tbody>';
                tabledata = $("#sale_totals");
                tabledata.append(TotalSaleTb);
            } else {
                var GetResult = GetSaleRecord(ui.item.mrp, ui.item.tax_value, ui.item.qty)
            }
            $('#item').val('');
            return false;
        }
    });
    var li = $('#ui-id-2 li');
    var liSelected;
    $(window).keydown(function(e) {
        if (e.which === 40) {
        // debugger;

            if (liSelected) {
                liSelected.removeClass('selected');
                next = liSelected.next();
                if (next.length > 0) {
                    liSelected = next.addClass('selected');
                } else {
                    liSelected = li.eq(0).addClass('selected');
                }
            } else {
                liSelected = li.eq(0).addClass('selected');
            }
            liSelected.trigger('click');
        }
    })

    function GetSaleRecord(SellingRate, TaxValue, Stock) {
        var TaxValue = (Number(SellingRate) - (Number(SellingRate) * (100 / (100 + Number(TaxValue)))));
        var AmountwithoutTax = (Number(SellingRate) - Number(TaxValue));
        var getResult = AmountwithoutTax + ',' + TaxValue;

        var AmountwithoutTax = 0;
        var TaxValue1 = 0;
        var TotalValue = 0;
        var Tquantity = 0;
        var Thisquantity = 0;
        var TbRow = $('#item-table >tbody >tr').length - 1;
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).closest('tr').find(".quantity1 input").each(function(k) {
                Tquantity += parseFloat($(this).closest('tr').find(".quantity1 input").val()) || 0;
            })
        });
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).closest('tr').find(".quantity1 input").each(function(k) {
                Thisquantity = parseFloat($(this).closest('tr').find(".quantity1 input").val()) || 0;
            })
            if ($(this).find(".AmountwithoutTax").text() != '') {
                AmountwithoutTax += parseFloat($(this).find(".AmountwithoutTax").text());
            }
            if ($(this).find(".TotalTaxValue").text() != '') {
                TaxValue1 += parseFloat($(this).find(".TotalTaxValue").text());
            }
            if ($(this).find(".TotalValue").text() != '') {
                TotalValue += parseFloat($(this).find(".TotalValue").text());
            }
        });

        if (Number(Thisquantity) != '' && Number(Stock) >= Number(Thisquantity)) {
            $('#sale_totals > tbody  > tr').each(function(i, j) {
                if ($(this).find(".AmountwithoutTax").text() != '') {
                    $(this).find(".AmountwithoutTax").text(Number(AmountwithoutTax).toFixed(2));
                }
                if ($(this).find(".TaxValue").text() != '') {
                    $(this).find(".TaxValue").text(Number(TaxValue1).toFixed(2));
                }
                if ($(this).find(".TotalValue").text() != '') {
                    $(this).find(".TotalValue").text((Number(TotalValue).toFixed(2)));
                }
                $(this).find(".SaleQuantity").text(Number(Tquantity));
                $(this).find(".ProductQuantity").text('Quantity of ' + TbRow + ' Items');
            });
        }
        return getResult;

    }
$('body').on('change', 'input[name=qty]',function(){
    var t = $(this);

    if (t.val()==0) {
        t.val(1)
    }
})
$('body').on('change | input', 'input[name=qty]',function(){
    var t = $(this);
    if (t.val()=='0') {
        t.val(1)
    }
   
    var qty = t.val();

    var tr = t.parents('tr');
    var id = tr.data('product_code');
    var mrp = tr.find(".mrp").text();
    var TaxValue1 = tr.find(".TaxValue1").text();
    var Stock = tr.find(".Stock").text();
    var productCode = tr.data("product_code");
    if (Number(Stock) >= Number(qty)) {
        var totalAmount = mrp * qty;
        var GetResult = GetSaleRecord(totalAmount, TaxValue1, Stock)
        var getV = GetResult.split(",");
        var AmountwithoutTax = getV[0];
        var TaxValue = getV[1];
        parseFloat(tr.find(".totalamount").text(totalAmount.toFixed(2)));
        tr.find(".AmountwithoutTax").text(Number(AmountwithoutTax).toFixed(2));
        tr.find(".TotalTaxValue").text(Number(TaxValue).toFixed(2));
        tr.find(".TotalValue").text((Number(AmountwithoutTax) + Number(TaxValue)).toFixed(2));
    }
    else{
        t.val('');
        toastr.warning('You dont have enough stock', 'Warning', 'positionclass:toast-bottom-full-width');
    }
})


$('body').on('change | input', 'input[name=free]',function(){
    var t = $(this);
    var free = t.val();
    var tr = t.parents('tr');
    var qty = tr.find('.quantity1').find("input").val();
    var tqty = Number(qty) + Number(free);
    var Stock = tr.find(".Stock").text();
    if (Number(Stock) >= Number(tqty)) {
        
    }
    else{
        t.val('0');
        toastr.warning('You dont have enough stock', 'Warning', 'positionclass:toast-bottom-full-width');
    }
})


    function gettotalamount(e, id) {   //remove this
        // alert()
        var mrp = '';
        var Stock = ''; 
        var TaxValue1 = '';
        var qty = e;
        var totalAmount = '';
        var productCode = '';
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).find(".product_code").each(function() {
                if ($(this).html() == id) {
                    mrp = $(j).find(".mrp").text();
                    TaxValue1 = $(j).find(".TaxValue1").text();
                    Stock = $(j).find(".Stock").text();
                    productCode = $(j).find(".product_code").text();
                }
            });
        });
        if (Number(Stock) >= Number(qty)) {

            var totalAmount = mrp * e;
            var GetResult = GetSaleRecord(totalAmount, TaxValue1, Stock)
            var getV = GetResult.split(",");
            var AmountwithoutTax = getV[0];
            var TaxValue = getV[1];
            $('#item-table > tbody  > tr').each(function(i, j) 
            {
                $(this).find(".product_code").each(function() 
                {
                    if ($(this).html() == id) {
                        parseFloat($(j).find(".totalamount").text(totalAmount.toFixed(2)));
                        $(j).find(".AmountwithoutTax").text(Number(AmountwithoutTax).toFixed(2));
                        $(j).find(".TotalTaxValue").text(Number(TaxValue).toFixed(2));
                        $(j).find(".TotalValue").text((Number(AmountwithoutTax) + Number(TaxValue)).toFixed(2));
                    }
                });
            });
        } else {
            $('#item-table > tbody  > tr').each(function(i, j) {
                $(this).find(".product_code").each(function() {
                    if ($(this).html() == productCode) {
                        $(this).closest('tr').find("input").each(function(k) {
                            $(this).closest('tr').find("input").val('');
                        })
                    }
                });
            });
            toastr.warning('You dont have enough stock', 'Warning', 'positionclass:toast-bottom-full-width');
        }
        GetSaleRecord(totalAmount, TaxValue1, Stock);

    }




    $("#item-table").on("click", "#DeleteButton", function() {
        $(this).closest("tr").remove();
        if ($('#item-table >tbody >tr').length == 1) {
            $("#item-table").find("tr.noItem").show();
            $("#sale-record").show();
            $("#sale-record1").remove();
        }
        var AmountwithoutTax = 0;
        var TaxValue1 = 0;
        var TotalValue = 0;
        var Tquantity = 0;
        var Thisquantity = 0;
        var Stock = 0;
        var TbRow = $('#item-table >tbody >tr').length - 1;
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).closest('tr').find(".quantity1 input").each(function(k) {
                Tquantity += parseFloat($(this).closest('tr').find(".quantity1 input").val()) || 0;
            })
        });
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).closest('tr').find(".quantity1 input").each(function(k) {
                Thisquantity = parseFloat($(this).closest('tr').find(".quantity1 input").val()) || 0;
            })
            if ($(this).find(".AmountwithoutTax").text() != '') {
                AmountwithoutTax += parseFloat($(this).find(".AmountwithoutTax").text());
            }
            if ($(this).find(".TotalTaxValue").text() != '') {
                TaxValue1 += parseFloat($(this).find(".TotalTaxValue").text());
            }
            if ($(this).find(".TotalValue").text() != '') {
                TotalValue += parseFloat($(this).find(".TotalValue").text());
            }
            if ($(this).find(".Stock").text() != '') {
                Stock += parseFloat($(this).find(".Stock").text());
            }
        });

        if (Number(Thisquantity) != '' && Number(Stock) >= Number(Thisquantity)) {
            $('#sale_totals > tbody  > tr').each(function(i, j) {
                if ($(this).find(".AmountwithoutTax").text() != '') {
                    $(this).find(".AmountwithoutTax").text(Number(AmountwithoutTax).toFixed(2));
                }
                if ($(this).find(".TaxValue").text() != '') {
                    $(this).find(".TaxValue").text(Number(TaxValue1).toFixed(2));
                }
                if ($(this).find(".TotalValue").text() != '') {
                    $(this).find(".TotalValue").text((Number(TotalValue).toFixed(2)));
                }
                $(this).find(".SaleQuantity").text(Number(Tquantity));
                $(this).find(".ProductQuantity").text('Quantity of ' + TbRow + ' Items');
            });
        }
    });


    function calculateAmount(){
        $('#item-table > tbody  > tr').each(function(key, data) {
            console.log(key);
            console.log(data);
        });
    }

    function getdiscount(Discount, InventoryId, SellingPrice,is_discount1=true,togBtnClass='.togBtn') {
        var togBtn = Boolean;
        var TaxValue = '';
        var Quantity = '';
        var inventoryId = '';
        var purchase_rate = '';
        var Stock = '';
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).find(".inventory_id").each(function() {
                if (InventoryId == $(this).html()) {
                    $(this).closest('tr').find("input").each(function(k) {
                        Quantity = $(this).closest('tr').find("input").val();
                    })
                    togBtn = $(j).find(togBtnClass).is(':checked');
                    TaxValue = $(j).find(".TaxValue1").text();
                    Stock = $(j).find(".Stock").text();
                    inventoryId = $(j).find(".inventory_id").text();
                    purchase_rate = $(j).find(".purchase_rate").text();
                }
            });
        });
        var GetDiscount = SellingPrice;
        if (togBtn == false) {


            if (Number(Discount) <= 100) {
                var DiscountValue = (Number(SellingPrice) * Number(Discount) / 100);
                var GetDiscount = (Number(SellingPrice) - Number(DiscountValue));
            } else {
                toastr.warning('You can not apply discount more then 100%.', 'Warning', 'positionclass:toast-bottom-full-width');

                if(is_discount1 == true){
                    $(".inventory_id").each(function() {
                        if (InventoryId == $(this).html()) {
                            $(this).closest('tr').find("[name=discount]").val('');
                        }
                    });
                }
                else{
                    $(".inventory_id").each(function() {
                        if (InventoryId == $(this).html()) {
                            $(this).closest('tr').find("[name=discount2]").val('');
                        }
                    });
                }
            }
        } else {
            
            if (Number(SellingPrice) >= Number(Discount)) {
                // alert()
                GetDiscount = (Number(SellingPrice) - Number(Discount));
            } else {
                toastr.warning('You can not apply discount more then MRP.', 'Warning', 'positionclass:toast-bottom-full-width');
                if(is_discount1 == true){
                    $(".inventory_id").each(function() {
                        if (InventoryId == $(this).html()) {
                            $(this).closest('tr').find("[name=discount]").val('');
                        }
                    });
                }
                else{
                    $(".inventory_id").each(function() {
                        if (InventoryId == $(this).html()) {
                            $(this).closest('tr').find("[name=discount2]").val('');
                        }
                    });
                }
            }
        }
        
        var TaxValue1 = '';
        var DisAmountWithoutTax = 0;
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).find(".inventory_id").each(function() {
                if ($(this).html() == inventoryId) {
                    $(j).find(".mrp").text(Number(GetDiscount).toFixed(2));

                    var profit =  GetDiscount - purchase_rate;
                    var profit_percentage =   (profit / purchase_rate) * 100;
                    $(j).find(".profit").text(Number(profit_percentage).toFixed(2));

                    if(is_discount1 == true){
                        $(j).find(".sellingPriceForDics2").text(Number(GetDiscount).toFixed(2));
                    }
                    
                    $(j).find(".totalamount").text(((Number(GetDiscount) * Number(Quantity))).toFixed(2));
                    TaxValue1 = (Number(GetDiscount) - (Number(GetDiscount) * (100 / (100 + Number(TaxValue)))));
                    DisAmountWithoutTax = (Number(GetDiscount) - (Number(TaxValue1)));
                    $(j).find(".TotalTaxValue").text(Number(TaxValue1) * Number(Quantity).toFixed(2));
                    $(j).find(".AmountwithoutTax").text(Number(DisAmountWithoutTax) * Number(Quantity).toFixed(2));
                    $(j).find(".TotalValue").text((Number(GetDiscount) * Number(Quantity)).toFixed(2));
                }
            });
        });
        GetSaleRecord(GetDiscount, TaxValue, Stock)
        // alert(GetDiscount);
        return GetDiscount;
    }

    function getdiscount2(Discount, InventoryId) {
        var togBtn = Boolean;
        var TaxValue = '';
        var SellingPrice = '';
        var inventoryId = '';
        var Disc = '';
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).find(".inventory_id").each(function() {
                if (InventoryId == $(this).html()) {
                    $(this).closest('tr').find(".Disc input").each(function(k) {
                        Disc = $(this).closest('tr').find(".Disc input").val();
                    })
                    // togBtn = $(j).find(".togBtn").is(':checked');
                    // SellingPrice = $(j).find(".mrp").text();
                    SellingPrice = $(j).find(".sellingPriceForDics2").text();
                    // Disc = $(j).find(".Disc").text();
                    inventoryId = $(j).find(".inventory_id").text();
                }
            });
        });
        if (Disc != "") {
            getdiscount(Discount, InventoryId, SellingPrice,is_discount1=false,togBtnClass='.togBtn2')
        } else(
            toastr.warning('Please apply first discount.', 'Warning', 'positionclass:toast-bottom-full-width')
        )

    }

    function SetValueBlank(InventoryId, disTd) {
        $('#item-table > tbody  > tr').each(function(i, j) {
            $(this).find(".inventory_id").each(function() {
                if ($(this).html() == InventoryId) {
                    // $(this).closest('tr').find(`.${disTd} input`".Disc input").each(function(k) {
                    //     $(this).closest('tr').find(".Disc input").val('');
                    // })

                    $(this).closest('tr').find(`.${disTd} input`).val('').keyup();
                }
            });
        });
    }

    function fetch_city(state) {
        $.ajax({
            url: "<?php echo base_url('shop-master-data/fetch_city'); ?>",
            method: "POST",
            data: {
                state: state
            },
            success: function(data) {
                $(".city").html(data);
            },
        });
    }
</script>



