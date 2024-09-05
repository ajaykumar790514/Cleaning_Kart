                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Stocks</li>
                        </ol>
                    </div>
                    <!--<div class="col-md-7 col-4 align-self-center">
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
                    </div>--->
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
                                            <div>
                                                <h3 class="card-title">Products Category</h3>
                                                <!--<h6 class="card-subtitle">Ample Admin Vs Pixel Admin</h6>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <?php
                                            if ($product_category !== FALSE) {
                                                foreach ($product_category as $category) {
                                                    //code added on 12-1-2022 for redirecting to product list page in case of having sub categories under category  
                                                    if ($cat_or_pro_flg) {
                                                        $url = base_url() . 'stocks/' . $category['id'];
                                                    } else {
                                                        $url = base_url() . 'stocks/category/' . $category['id'];
                                                    }
                                                    //end
                                                    echo '<div class="col-lg-3 col-md-6">
                                                            <a href="' . $url . '">
                                                            <div class="card" style="padding:10px;height:300px;">
                                                                <img class="card-img-top" src="' . IMGS_URL . $category['icon'] . '" alt="Card image cap" style="height:220px;">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">' . $category['name'] . '</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>';
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
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->