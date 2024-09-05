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
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="breadcrumb-item active">Offers & Coupons</li>
                            
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
                                            <div>
                                                <h3 class="card-title">Offer & Coupons Data</h3>
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
                                                            <a href="<?php echo base_url('shop-offers'); ?>">
                                                            <div class="card text-center" style="padding:10px;">
                                                                <img class="center" src="<?php echo base_url('application/photo/masters/categories.png'); ?>" alt="Offers">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Offers</h4>
                                                                </div>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <a href="<?php echo base_url('shop-coupons'); ?>">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/products.png'); ?>" alt="Coupons">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Coupons</h4>
                                                                </div>
                                                            </a>
                                                            </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6">
                                                            <a href="">
                                                            <div class="card text-center" style="padding:10px;">
                                                            <a href="<?php echo base_url('shop-apply-offer'); ?>">
                                                            <img class="center" src="<?php echo base_url('application/photo/masters/products.png'); ?>" alt="apply">
                                                                <div class="card-body">
                                                                    <h4 class="card-title">Apply Offer</h4>
                                                                </div>
                                                            </a>
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
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
          