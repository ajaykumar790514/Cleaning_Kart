 <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="breadcrumb-item"><a href="coupons-offers">Offers & Coupons</a></li>
                            <li class="breadcrumb-item active"><?php echo $couponOfferData[0]['title'];?></li>
                            
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
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card blog-widget">
                            <div class="card-body">
                                <div class="blog-image"><img src="<?php
                                    $ch = curl_init('https://techfizone.com/techfiprojects/shopzone'.$couponOfferData[0]['poster']);
                                    curl_setopt($ch, CURLOPT_NOBODY, true);
                                    curl_exec($ch);
                                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                                    // Check if file exists
                                    if($code == 200){
                                        echo 'https://techfizone.com/techfiprojects/shopzone'.$couponOfferData[0]['poster'];
                                    }else{
                                        echo base_url($couponOfferData[0]['poster']);
                                    } 
                                ?>" alt="<?php echo $couponOfferData[0]['title']; ?>" class="img-responsive" style="max-height:200px; height:200px;" /></div>
                                <h3>
                                    <?php 
                                        if($couponOfferData[0]['coupan_or_offer'] === '0'){
                                            echo "Coupon: ".$couponOfferData[0]['title'];
                                        }else{
                                            echo "Offer: ".$couponOfferData[0]['title'];
                                        }
                                    ?>
                                    <span class="float-right">
                                        <?php
                                        if($couponOfferData[0]['isActive'] === '0'){
                                            echo '<button type="button" style="height: 15px !important; width: 15px !important;" onclick="updateStatus(\''.$couponOfferData[0]['id'].'\', \''.$couponOfferData[0]['isActive'].'\');" class="btn btn-danger btn-circle"></button>';
                                        }else{
                                            echo '<button type="button" style="height: 15px !important; width: 15px !important;" onclick="updateStatus(\''.$couponOfferData[0]['id'].'\', \''.$couponOfferData[0]['isActive'].'\');" class="btn btn-success btn-circle"></button>';
                                        }
                                        ?>
                                    </span>
                                </h3>
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
                                </script>
                                <p class="m-t-20 m-b-20">
                                    <?php echo $couponOfferData[0]['description']; ?>
                                    <br>
                                    <br>
                                    <small>
                                    <?php 
                                        if($couponOfferData[0]['coupan_or_offer'] === '0'){
                                            echo '<b>Coupon Code:</b> '.$couponOfferData[0]['code'].'<br>';
                                        }
                                        if($couponOfferData[0]['discount_type'] === '0'){
                                            echo '<b>Discount Type:</b> Fixed Amount<br>';
                                            echo '<b>Discount Amount:</b> ₹'.$couponOfferData[0]['value'];
                                        }else{
                                            echo '<b>Discount Type:</b> Percentage based<br>';
                                            echo '<b>Discount Amount:</b> '.$couponOfferData[0]['value'].'% upto ₹'.$couponOfferData[0]['maximum_coupan_discount_value'];
                                        }
                                        if($couponOfferData[0]['coupan_or_offer'] === '0'){
                                            echo '<br>';
                                            echo '<b>Minimum Cart Value required:</b> ₹'.$couponOfferData[0]['minimum_coupan_amount'];
                                        }
                                        echo '<br>';
                                        echo '<b>Start Date:</b> '.date('d F, y',strtotime($couponOfferData[0]['start_date']));
                                        echo '<br>';
                                        echo '<b>End Date:</b> '.date('d F, y',strtotime($couponOfferData[0]['expiry_date']));
                                        echo '</small>';
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                        if($couponOfferData[0]['coupan_or_offer'] === '1'){
                    ?>
                    <div class="col-lg-8 col-xlg-9 col-md-7">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title" >Products Tagged Under Offers
                                    <div class="float-right">
                                        <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Assign products</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="category_id" class="control-label">Category:</label>
                                                                <input type="hidden" id="shop_id" value="<?php echo $_SESSION['user_data']['id'];?>" >
                                                                <input type="hidden" id="offer_assosiated_id" value="<?php echo $couponOfferData[0]['id'];?>" >
                                                                <input type="hidden" id="offer_associated" value="<?php echo $couponOfferData[0]['title'];?>" >
                                                                <select class="form-control select2" name="category_id" id="category_id" style="width:100%;">
                                                                    <option value="0">Select Category</option>
                                                                    <?php
                                                                    if($categoryList!==FALSE){
                                                                        foreach($categoryList as $category){
                                                                            echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group" id="sub-cat" style="display:none;">
                                                                <label for="sub_category_id" class="control-label">Sub-Category:</label>
                                                                <select class="form-control select2" name="sub_category_id" id="sub_category_id" style="width:100%;">
                                                                    <option value="0">Select sub-Category</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group" id="productList" style="display:none;">
                                                                <label for="product_id" class="control-label">Product List:</label>
                                                                <select class="form-control select2" name="product_id" id="product_id" style="width:100%;">
                                                                    <option value="0">Select Product</option>
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                        <button type="button" id="addButton" class="btn btn-danger waves-effect waves-light">Save changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#responsive-modal">Add Product</button>
                                        <script>
                                            $('#category_id').change(function(){
                                                $('#sub-cat').hide();
                                                $('#productList').hide();
                                                $.ajax({
                                                    url: 'Coupons_offers/getCategorydata',
                                                    type: 'post',
                                                    data: {cat_id: $('#category_id :selected').val()},
                                                    dataType:'json',
                                                    success: function(response){
                                                        if(response.subCat == true){
                                                            $('#sub_category_id').html(response.subCatData);
                                                            $('#sub-cat').show();
                                                        }else{
                                                            $('#product_id').html(response.productList);
                                                            $('#productList').show();
                                                        }
                                                    },
                                                });
                                            });

                                            $('#sub_category_id').change(function(){
                                                $('#productList').hide();
                                                $.ajax({
                                                    url: 'Coupons_offers/getCategorydata',
                                                    type: 'post',
                                                    data: {cat_id: $('#sub_category_id :selected').val()},
                                                    dataType:'json',
                                                    success: function(response){
                                                        if(response.subCat == true){
                                                            $('#sub_category_id').html(response.subCatData);
                                                            $('#sub-cat').show();
                                                        }else{
                                                            $('#product_id').html(response.productList);
                                                            $('#productList').show();
                                                        }
                                                    },
                                                });
                                            });

                                            $('#addButton').click(function(e){
                                                e.preventDefault();
                                                const swalWithBootstrapButtons = Swal.mixin({
                                                    customClass: {
                                                        confirmButton: 'btn btn-success',
                                                        cancelButton: 'btn btn-danger'
                                                    },
                                                    buttonsStyling: true
                                                })
                                                swalWithBootstrapButtons.fire({
                                                    title: 'Do you want to add product to this coupon/offer?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Yes, please!',
                                                    cancelButtonText: 'No, cancel!',
                                                    reverseButtons: true
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        return $.ajax({
                                                                    url: 'Coupons_offers/submitAddProduct',
                                                                    type: 'post',
                                                                    data: {
                                                                        shop_id: $('#shop_id').val(),
                                                                        offer_assosiated_id: $('#offer_assosiated_id').val(),
                                                                        offer_associated: $('#offer_associated').val(),
                                                                        product_id: $('#product_id :selected').val(),
                                                                        category_id: $('#category_id :selected').val()
                                                                    },
                                                                    dataType:'json',
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
                                            });
                                        </script>
                                    </div>
                                </h3>
                                <div class="table-responsive">
                                    <table class="table full-color-table full-inverse-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($productAssociated !== FALSE){
                                                    $count=1;
                                                    foreach($productAssociated as $productData){
                                                        echo '<tr>';
                                                        echo '<td>'.$count.'</td>';
                                                        $ch = curl_init($productData['img']);
                                                        curl_setopt($ch, CURLOPT_NOBODY, true);
                                                        curl_exec($ch);
                                                        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                                                        // Check if file exists
                                                        if($code == 200){
                                                            echo '<td><img src="'.$productData['img'].'" style="max-height:70px;"></td>';
                                                        }else{
                                                            echo '<td><img src="https://user-images.githubusercontent.com/194400/49531010-48dad180-f8b1-11e8-8d89-1e61320e1d82.png" style="max-height:70px;"></td>';
                                                        } 

                                                        echo '<td>'.$productData['name'].'</td>';
                                                        echo '<td>'.$productData['category'].'</td>';
                                                        echo '<td><i class="mdi mdi-delete text-danger" style="font-size:30px; cursor:pointer;" onclick="removeProduct(\''.$productData['co_id'].'\',\''.$productData['name'].'\');"></i></td>';
                                                        echo '</tr>';
                                                        $count++;
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                    
                </div>
                <script>
                    function removeProduct(co_id,productName){
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-success',
                                cancelButton: 'btn btn-danger'
                            },
                            buttonsStyling: true
                        })
                        swalWithBootstrapButtons.fire({
                            title: 'Do you want to remove '+productName+' from this offer?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, please!',
                            cancelButtonText: 'No, cancel!',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                return $.ajax({
                                            url: 'Coupons_offers/removeProductFromOffers',
                                            type: 'post',
                                            data: {co_id:co_id},
                                            dataType:'json',
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
                    } 
                </script>