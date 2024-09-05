 <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                
                <div class="float-right">
                    Page rendered in <strong>{elapsed_time}</strong> seconds.
                </div>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="public/assets/plugins/popper/popper.min.js"></script>
    <script src="public/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="public/assets/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="public/assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="public/assets/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="public/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="public/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="public/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="public/assets/plugins/switchery/dist/switchery.min.js"></script>
    <script src="public/assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <script src="public/assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="public/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="public/assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
    <script src="public/assets/plugins/dff/dff.js" type="text/javascript"></script>
    <script type="text/javascript" src="public/assets/plugins/multiselect/js/jquery.multi-select.js"></script>

    <script src="public/assets/js/custom.min.js"></script>
    <!-- Toastr -->
<script src="<?php echo base_url('public/assets/plugins/toastr/toastr.min.js'); ?>"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <script src="public/assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
    <!-- Sweet-Alert  -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="public/assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>
    <!--c3 JavaScript -->
    <script src="public/assets/plugins/d3/d3.min.js"></script>
    <script src="public/assets/plugins/c3-master/c3.min.js"></script>
    <!-- Chart JS -->
    <script src="public/assets/js/dashboard1.js"></script>
    <script>
        $(".select2").select2();
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="public/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <script>
    $(document).ready(function() {
        // ----------------Sweetalert2-----------------//
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-right',
                showConfirmButton: false,
                timer: 3000
            });

            <?php if ($this->session->flashdata('success')) { ?>

                toastr.success('<?php echo $this->session->flashdata('success'); ?>')
            <?php }
            if ($this->session->flashdata('error')) { ?>

                toastr.error('<?php echo $this->session->flashdata('error'); ?>')
            <?php } ?>


        });

    });
</script>
</body>

</html>
