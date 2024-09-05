                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="breadcrumb-item active">Offers & Coupons</li>
                            
                        </ol>
                    </div><!--
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
                    <div class="col-12">
                        <div class="card">
                            <!-- .left-right-aside-column-->
                            <div class="card-body">
                                <button class="btn btn-primary float-right" onclick="openAddModal();">Add New Offer/Coupon</button>
                                <!-- sample modal content -->
                                <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="OffersCouponsForm">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="control-label">Select Coupons/Offers:</label>
                                                                <input type="hidden" class="form-control" id="id" name="id" value="0">
                                                                <input type="hidden" class="form-control" name="offer_created_by" value="<?php echo $_SESSION['user_data']['id'];?>">
                                                                <select class="form-control" id="coupan_or_offer" name="coupan_or_offer">
                                                                    <option value="1">Offer</option>
                                                                    <option value="0">Coupon</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Title:</label>
                                                                <input type="text" class="form-control" id="title" name="title">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Description:</label>
                                                                <input type="text" class="form-control" id="description" name="description">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Discount Type:</label><br>
                                                                <input type="radio" id="discount_type_0" name="discount_type" class="radio-col-blue" value="0"/>
                                                                <label for="discount_type_0">Fixed</label>
                                                                <input type="radio" id="discount_type_1" name="discount_type" class="radio-col-blue" value="1"/>
                                                                <label for="discount_type_1">Percentage</label>
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Discount Value:</label>
                                                                <input type="text" class="form-control" id="value" name="value">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Start date:</label>
                                                                <input type="date" class="form-control" id="start_date" name="start_date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Expiry Date:</label>
                                                                <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Message:</label>
                                                                <input type="file" class="form-control" id="poster" name="poster">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="code-div" style="display:none;">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Coupon Code:</label>
                                                                <input type="text" class="form-control" id="code" name="code">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Minimum Cart Value required:</label>
                                                                <input type="text" class="form-control" id="minimum_coupan_amount" name="minimum_coupan_amount">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="message-text" class="control-label">Discount allowed Upto:</label>
                                                                <input type="text" class="form-control" id="maximum_coupan_discount_value" name="maximum_coupan_discount_value">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row" id="img-div">
                                                        <div class="col-md-12">
                                                            <div style="height:200px; width:300px;">
                                                                <img id="photo" style="max-height:100%; height:100%; width:100%; max-width:100%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger waves-effect waves-light" id="submitOffersCouponsForm">Save changes</button>
                                            </div>
                                        </div>
                                        <script>
                                            $('#submitOffersCouponsForm').click(function(e){
                                                e.preventDefault();
                                                
                                                if($('#expiry_date').val() >= $('#start_date').val()){
                                                    var form = $('#OffersCouponsForm')[0];
                                                    var fd = new FormData(form);
                                                    if($("#id").val() == '0'){
                                                        action = 'add';
                                                    }else{
                                                        action = 'update';
                                                    }

                                                    const swalWithBootstrapButtons = Swal.mixin({
                                                        customClass: {
                                                            confirmButton: 'btn btn-success',
                                                            cancelButton: 'btn btn-danger'
                                                        },
                                                        buttonsStyling: true
                                                    })
                                                    swalWithBootstrapButtons.fire({
                                                        title: 'Are you sure to you want to '+action+' this coupon/offer?',
                                                        icon: 'warning',
                                                        showCancelButton: true,
                                                        confirmButtonText: 'Yes, please!',
                                                        cancelButtonText: 'No, cancel!',
                                                        reverseButtons: true
                                                    }).then((result) => {
                                                        if (result.isConfirmed) {
                                                            return $.ajax({
                                                                        url: 'Coupons_offers/submitAddEdit',
                                                                        type: 'post',
                                                                        data: fd,
                                                                        dataType:'json',
                                                                        contentType: false,
                                                                        processData: false,
                                                                        success: function(response){
                                                                            if(response.status == true){
                                                                                swalWithBootstrapButtons.fire(
                                                                                    'Success!',
                                                                                    response.message,
                                                                                    'success',
                                                                                ).then((result) => {
                                                                                    location.reload();
                                                                                })
                                                                            }else{
                                                                                swalWithBootstrapButtons.fire(
                                                                                    'Error!',
                                                                                    response.message,
                                                                                    'error',
                                                                                )
                                                                            }
                                                                        },
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
                                                }else{
                                                    swal(
                                                                                'Error!',
                                                                                'Expiry Date should be greater or equal to start date',
                                                                                'error',
                                                                            )
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                                <script>
                                    $('#coupan_or_offer').change(function(){
                                        //alert($('#coupan_or_offer option:selected').val());
                                        if($('#coupan_or_offer option:selected').val()=='0'){
                                            $('#code-div').show();
                                        }else{
                                            $('#code-div').hide();
                                        }
                                    });
                                </script>
                                <!-- /.modal -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Offers</span></a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Coupons</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active" id="home" role="tabpanel">
                                        <div class="p-20">
                                            <div class="row">
                                                <?php
                                                    if($offersData!==FALSE){
                                                        foreach($offersData as $data){
                                                            echo '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                                                        <div class="card">
                                                                            <img class="card-img-top" src="';
                                                            
                                                            
                                                                            $ch = curl_init('https://techfizone.com/techfiprojects/shopzone'.$data['poster']);
                                                                            curl_setopt($ch, CURLOPT_NOBODY, true);
                                                                            curl_exec($ch);
                                                                            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                                                                            // Check if file exists
                                                                            if($code == 200){
                                                                                echo 'https://techfizone.com/techfiprojects/shopzone'.$data['poster'];
                                                                            }else{
                                                                                echo base_url($data['poster']);
                                                                            }                
                                                                            
                                                                                            
                                                                            echo '" alt="'.$data['title'].'">
                                                                            <div class="card-body">
                                                                                <h4 class="card-title">
                                                                                    '.$data['title'].'
                                                                                    <span class="float-right">';
                                                            if($data['isActive'] === '0'){
                                                                echo '<button type="button" style="height: 15px !important; width: 15px !important;" onclick="updateStatus(\''.$data['id'].'\', \''.$data['isActive'].'\');" class="btn btn-danger btn-circle"></button>';
                                                            }else{
                                                                echo '<button type="button" style="height: 15px !important; width: 15px !important;" onclick="updateStatus(\''.$data['id'].'\', \''.$data['isActive'].'\');" class="btn btn-success btn-circle"></button>';
                                                            }
                                                            echo ' </span>
                                                                                </h4>
                                                                                <p class="card-text">
                                                                                    '.$data['description'].'
                                                                                    <br>
                                                                                    <br>
                                                                                    <small>';
                                                                                        if($data['discount_type'] === '0'){
                                                                                            echo '<b>Discount Amount:</b> ₹'.$data['value'];
                                                                                        }else{
                                                                                            echo '<b>Discount Amount:</b> '.$data['value'].'% upto ₹'.$data['maximum_coupan_discount_value'];
                                                                                        }
                                                                                    echo '</small>
                                                                                </p>
                                                                                <a href="coupons-offers/'.$data['id'].'" class="btn btn-primary">View more...</a>
                                                                                <button class="btn btn-warning" id="editModal_'.$data['id'].'"><i class="fa fa-edit"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                                    echo '<script>
                                                                    $("#editModal_'.$data['id'].'").click(function(){
                                                                        $("#id").val(\''.$data['id'].'\');
                                                                        $(\'#coupan_or_offer option[value="'.$data['coupan_or_offer'].'"]\').attr("selected", "selected");
                                                                        $(\'input[name=discount_type][value="'.$data['discount_type'].'"]\').attr(\'checked\', true);
                                                                        $(\'#title\').val(\''.$data['title'].'\');
                                                                        $(\'#description\').val(\''.$data['description'].'\');
                                                                        $(\'#value\').val(\''.$data['value'].'\');
                                                                        $(\'#start_date\').val(\''.date('Y-m-d',strtotime($data['start_date'])).'\');
                                                                        $(\'#expiry_date\').val(\''.date('Y-m-d',strtotime($data['expiry_date'])).'\');
                                                                        $(\'#code\').val(\''.$data['code'].'\');
                                                                        $(\'#minimum_coupan_amount\').val(\''.$data['minimum_coupan_amount'].'\');
                                                                        $(\'#maximum_coupan_discount_value\').val(\''.$data['maximum_coupan_discount_value'].'\');
                                                                        $(\'#photo\').attr(\'src\',\'';
                                                            
                                                            
                                                                        $ch = curl_init('https://techfizone.com/techfiprojects/shopzone'.$data['poster']);
                                                                        curl_setopt($ch, CURLOPT_NOBODY, true);
                                                                        curl_exec($ch);
                                                                        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
                                                                        // Check if file exists
                                                                        if($code == 200){
                                                                            echo 'https://techfizone.com/techfiprojects/shopzone'.$data['poster'];
                                                                        }else{
                                                                            echo base_url($data['poster']);
                                                                        }                
                                                                        
                                                                                        
                                                                        echo '\');
                                                                        $(\'#responsive-modal\').modal(\'show\');
                                                                        $(\'#img-div\').show();
                                                                        $(\'#code-div\').hide();
                                                                    });
                                                                    </script>';
                                                        }
                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane  p-20" id="profile" role="tabpanel">
                                    <div class="p-20">
                                            <div class="row">
                                                <?php
                                                    if($couponData!==FALSE){
                                                        foreach($couponData as $data){
                                                            echo '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                                                        <div class="card">
                                                                            <img class="card-img-top" src="';
                                                            
                                                            
                                                            $ch = curl_init('https://techfizone.com/techfiprojects/shopzone'.$data['poster']);
                                                            curl_setopt($ch, CURLOPT_NOBODY, true);
                                                            curl_exec($ch);
                                                            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                                                            // Check if file exists
                                                            if($code == 200){
                                                                echo 'https://techfizone.com/techfiprojects/shopzone'.$data['poster'];
                                                            }else{
                                                                echo $data['poster'];
                                                            }                
                                                            
                                                                            
                                                            echo '" alt="'.$data['title'].'">
                                                                            <div class="card-body">
                                                                                <h4 class="card-title">
                                                                                    '.$data['title'].'
                                                                                    <span class="float-right">';
                                                            if($data['isActive'] === '0'){
                                                                echo '<button type="button" style="height: 15px !important; width: 15px !important;" onclick="updateStatus(\''.$data['id'].'\', \''.$data['isActive'].'\');" class="btn btn-danger btn-circle"></button>';
                                                            }else{
                                                                echo '<button type="button" style="height: 15px !important; width: 15px !important;" onclick="updateStatus(\''.$data['id'].'\', \''.$data['isActive'].'\');" class="btn btn-success btn-circle"></button>';
                                                            }
                                                            echo ' </span>
                                                                                </h4>
                                                                                <p class="card-text">
                                                                                    '.$data['description'].'
                                                                                    <br>
                                                                                    <br>
                                                                                    <small>';
                                                                                        echo '<b>Coupon Code:</b> '.$data['code'].'<br>';
                                                                                        if($data['discount_type'] === '0'){
                                                                                            echo '<b>Discount Amount:</b> ₹'.$data['value'];
                                                                                        }else{
                                                                                            echo '<b>Discount Amount:</b> '.$data['value'].'% upto ₹'.$data['maximum_coupan_discount_value'];
                                                                                        }
                                                                                    echo '</small>
                                                                                </p>
                                                                                <a href="coupons-offers/'.$data['id'].'" class="btn btn-primary">View more...</a>
                                                                                <button class="btn btn-warning" id="editModal_'.$data['id'].'"><i class="fa fa-edit"></i></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>';
                                                                    echo '<script>
                                                                    $("#editModal_'.$data['id'].'").click(function(){
                                                                        $("#id").val(\''.$data['id'].'\');
                                                                        $(\'#coupan_or_offer option[value="'.$data['coupan_or_offer'].'"]\').attr("selected", "selected");
                                                                        $(\'input[name=discount_type][value="'.$data['discount_type'].'"]\').attr(\'checked\', true);
                                                                        $(\'#title\').val(\''.$data['title'].'\');
                                                                        $(\'#description\').val(\''.$data['description'].'\');
                                                                        $(\'#value\').val(\''.$data['value'].'\');
                                                                        $(\'#start_date\').val(\''.date('Y-m-d',strtotime($data['start_date'])).'\');
                                                                        $(\'#expiry_date\').val(\''.date('Y-m-d',strtotime($data['expiry_date'])).'\');
                                                                        $(\'#code\').val(\''.$data['code'].'\');
                                                                        $(\'#minimum_coupan_amount\').val(\''.$data['minimum_coupan_amount'].'\');
                                                                        $(\'#maximum_coupan_discount_value\').val(\''.$data['maximum_coupan_discount_value'].'\');
                                                                        $(\'#photo\').attr(\'src\',\'';
                                                            
                                                            
                                                                        $ch = curl_init('https://techfizone.com/techfiprojects/shopzone'.$data['poster']);
                                                                        curl_setopt($ch, CURLOPT_NOBODY, true);
                                                                        curl_exec($ch);
                                                                        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
                                                                        // Check if file exists
                                                                        if($code == 200){
                                                                            echo 'https://techfizone.com/techfiprojects/shopzone'.$data['poster'];
                                                                        }else{
                                                                            echo base_url($data['poster']);
                                                                        }                
                                                                        
                                                                                        
                                                                        echo '\');
                                                                        $(\'#responsive-modal\').modal(\'show\');
                                                                        $(\'#img-div\').show();
                                                                        $(\'#code-div\').show();
                                                                    });
                                                                    </script>';
                                                        }
                                                    }
                                                ?>
                                            </div>
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
                <script>
                    function updateStatus(id, currstatus) {
                        if(currstatus == '0'){
                            action = 'enable';
                        }else{
                            action = 'disable';
                        }
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: true
                        })
                        swalWithBootstrapButtons.fire({
                            title: 'Are you sure to you want to '+action+' this coupon/offer?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, please!',
                            cancelButtonText: 'No, cancel!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                return $.ajax({
                                    type:"POST",
                                    url: "Coupons_offers/enableDisabled",
                                    data: {id:id,currstatus:currstatus},
                                    'success': function (data) {
                                        swalWithBootstrapButtons.fire(
                                            'Success!',
                                            'Offer/Coupon '+action+'d.',
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
                    function openAddModal(){
                        $('#id').val('0');
                        $('#coupan_or_offer option[value="1"]').attr("selected", "selected");
                        $('input:radio[name=discount_type]').attr('checked',false);
                        $('#title').val('');
                        $('#description').val('');
                        $('#value').val('');
                        $('#start_date').val('');
                        $('#expiry_date').val('');
                        $('#code').val('');
                        $('#minimum_coupan_amount').val('');
                        $('#maximum_coupan_discount_value').val('');
                        $('#photo').attr('src','');
                        $('#responsive-modal').modal('show');
                        $('#img-div').hide();
                    }
                </script>