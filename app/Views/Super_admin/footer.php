<footer class="main-footer">
    <strong>Copyright &copy; 2024 <a href="https://dnationsoft.com/">DNationSoft</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url()?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url()?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url()?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url()?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url()?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url()?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url()?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url()?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url()?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url()?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url()?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>assets/dist/js/adminlte.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url()?>assets/dist/js/pages/dashboard.js"></script>

<!-- DataTables  & Plugins -->
<script src="<?php echo base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "order": [
                [0, "desc"]
            ],
            "buttons": ["copy", "csv", "excel", "pdf", "print"]
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $("#example3").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "order": [
                [0, "desc"]
            ],
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    function shopSubCategory(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/shops_sub_category') ?>",
            dataType: "text",
            data: {
                catId: id
            },
            success: function(data) {
                $('#subCat').html(data);
            }
        });
    }

    function viewdistrict(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/search_district') ?>",
            dataType: "text",
            data: {
                divisionsId: id
            },

            beforeSend: function() {
                $('#district').html(
                    '<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...'
                );
            },
            success: function(msg) {
                $('#district').html(msg);
                $('#district2').html(msg);
            }

        });
    }

    function viewupazila(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/search_upazila') ?>",
            dataType: "text",
            data: {
                districtId: id
            },

            beforeSend: function() {
                $('#upazila').html(
                    '<img src="<?php print base_url(); ?>/assets/images/loading.gif" width="20" alt="loading"/> Progressing...'
                );
            },
            success: function(msg) {
                $('#upazila').html(msg);
                $('#upazila2').html(msg);
            }

        });
    }

    function eventCheckBox() {
        let checkboxs = document.getElementsByTagName("input");
        for (let i = 1; i < checkboxs.length; i++) {
            checkboxs[i].checked = !checkboxs[i].checked;
        }
    }

    function printDiv(){
        window.print();
    }

    function request_status(status, id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/calling_status_update') ?>",
            dataType: "text",
            data: {
                status: status,
                calling_id: id
            },
            success: function(msg) {
                $('#message').html(msg);
            }
        });
    }

    function shopdata(id, sellerId) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/commission_data') ?>",
            dataType: "text",
            data: {
                sch_id: id,
                seller_id: sellerId
            },
            success: function(data) {

                $('#commDetail').html(data);

            }

        });
    }

    function shoptotaldata(id, sellerId) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/commission_data_total') ?>",
            dataType: "text",
            data: {
                sch_id: id,
                seller_id: sellerId
            },

            success: function(data) {
                $('#commTotalDetail').html(data);
            }

        });
    }

    function allshopcom(sellerId) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/commission_all') ?>",
            dataType: "text",
            data: {
                seller_id: sellerId
            },

            success: function(data) {
                $('#commTotalDetail').html(data);
            }

        });
    }

    function shopbyorder(schId, sellerId) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/sellers_order_data') ?>",
            dataType: "text",
            data: {
                sch_id: schId,
                seller_id: sellerId
            },
            success: function(data) {
                $('#shopOrder').html(data);
            }

        });
    }

    function shopdatadeliveryBoy(id, deliveryBoyId) {

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/delivery_boy_commission_data') ?>",
            dataType: "text",
            data: {
                sch_id: id,
                delivery_boy_id: deliveryBoyId
            },

            success: function(data) {
                $('#commDetail').html(data);
            }

        });
    }

    function shoptotaldaliverydata(id, deliveryBoyId) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/delivery_boy_commission_data_total') ?>",
            dataType: "text",
            data: {
                sch_id: id,
                delivery_boy_id: deliveryBoyId
            },

            success: function(data) {
                $('#commTotalDetail').html(data);
            }

        });
    }

    function allshopcomdeliveryBoy(deliveryBoyId) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('super_admin/delivery_boy_commission_all') ?>",
            dataType: "text",
            data: {
                delivery_boy_id: deliveryBoyId
            },
            success: function(data) {
                $('#commTotalDetail').html(data);
            }

        });
    }

</script>
</body>
</html>