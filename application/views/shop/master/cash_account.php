<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">
        <h3 class="text-themecolor">Dashboard</h3>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('admin-dashboard'); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('master-data'); ?>">Master</a></li>
            <li class="breadcrumb-item active">Shop Bank Accounts</li>
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
                            <div class="float-left col-md-10 col-lg-10 col-sm-12 p-0">
                                <h3 class="card-title" id="test">Shop Cash Account</h3>
                                <h6 class="card-subtitle"></h6>
                            </div>

                            
                        </div>
                    </div>


                    <div class="col-12">
                        <div class="d-flex flex-wrap">
                            <div class="float-left col-12 p-0">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="control-label">Opening</label>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="control-label">Dr./Cr.:</label>
                                                <select class="form-control" name="dr_cr">
                                                    <option value="">-- Select --</option>
                                                   <option value="cr" <?=(@$row->dr_cr=='cr') ? 'selected' : ''?> >Credit</option>
                                                    <option value="dr" <?=(@$row->dr_cr=='dr') ? 'selected' : ''?> >Debit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="control-label">Amount:</label>
                                                <input type="number" class="form-control" name="amount" value="<?=@$row->amount?>">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="control-label">Remark:</label>
                                                <input type="text" class="form-control" name="remark" value="<?=@$row->remark?>">
                                            </div>
                                        </div>

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label class="control-label"><br></label>
                                                <input type="submit" class="form-control bg-success text-white" value="Save">
                                            </div>
                                        </div>
                                       
                                    </div>
                                </form>
                            </div>

                           
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

