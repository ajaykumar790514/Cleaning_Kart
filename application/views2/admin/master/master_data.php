<style>
    .center {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 20%;
    }
</style>
<!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-wrapper">
                <div class="container-fluid" style="max-width: 100% !important;">
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
                            <li class="breadcrumb-item active">Master Data</li>
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
                                                <h3 class="card-title">Master Data</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <?php foreach($sub_menus as $menus){ ?>
                                                <div class="col-lg-3 col-md-6">
                                                    <a href="<?php echo base_url($menus->url.'/'.$menu_id); ?>">
                                                    <div class="card text-center" style="padding:10px;">
                                                        <img class="center" src="<?php echo base_url($menus->icon_class); ?>" alt="Master data">
                                                        <div class="card-body">
                                                            <h4 class="card-title"><?= $menus->title; ?></h4>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                                        <!-- <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('categories'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                                <img class="center" src="<?php echo base_url('application/photo/masters/categories.png'); ?>" alt="Category">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Category</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div> -->
                                                        <!-- <div class="col-lg-3 col-md-6">
                                                            <a href="">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <a href="<?php echo base_url('products'); ?>">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/products.png'); ?>" alt="product">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Product</h4>
                                                                </div>
                                                            </a>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('product-property'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/product.png'); ?>" alt="property">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Product Property</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('society'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/society.png'); ?>" alt="socity">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Society</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('unit-master'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/unit.png'); ?>" alt="unit">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Unit Master</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('tax-slab'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/tax.png'); ?>" alt="tax slab">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Tax Slab</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('pincodes-criteria'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/pincode.png'); ?>" alt="property">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Pincode Criteria</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('booking-slots'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/booking.png'); ?>" alt="property">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Booking Slots</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('home-banners'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                                <img class="center" src="<?php echo base_url('application/photo/masters/home-banner.png'); ?>" alt="Category">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Home Banners</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('home-header'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                                <img class="center" src="<?php echo base_url('application/photo/masters/categories.png'); ?>" alt="Category">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Home Header</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('vendors'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/booking.png'); ?>" alt="property">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Vendors</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('brand-master'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/booking.png'); ?>" alt="property">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Brand</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('shop-category'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/product.png'); ?>" alt="property">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Shop Category</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('market-place-home-banners'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                                <img class="center" src="<?php echo base_url('application/photo/masters/home-banner.png'); ?>" alt="Category">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Market Place Home Banners</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('cancellation-reason'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/unit.png'); ?>" alt="unit">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Cancellation Reason</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="<?php echo base_url('shop-social'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/unit.png'); ?>" alt="unit">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Shop Social</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div> -->
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