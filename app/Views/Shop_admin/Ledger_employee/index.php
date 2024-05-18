<?= $this->extend('Shop_admin/layout') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper overflow-hidden">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ledger Employee</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('shop_admin/dashboard') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Ledger Employee</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ledger Employee List</h3>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3 " >
                    <div class="col-md-3" >
                        <label>Employee name</label>
                        <select class="form-control select2 select2-hidden-accessible" onchange="employeeLedg(this.value)" id="employeeId" style=" width: 100%;" tabindex="-1" aria-hidden="true">
                            <option selected="selected"  value="">Please Select</option>
                            <?php echo getAllListInOption('employee_id','employee_id','name','employee'); ?>
                        </select>

                    </div>
                    <div class="col-md-3" >
                        <label>Start Date</label>
                        <input type="date" class="form-control" name="st_date" id="st_date"  required>
                    </div>
                    <div class="col-md-4"  >
                        <label>End Date</label>
                        <input type="date" class="form-control" name="en_date" id="en_date"  required>
                    </div>
                    <div class="col-md-2" style="padding: 4px;"  >
                        <button style="margin-top: 28px;" onclick="emplLedSerc()" class="btn btn-primary " type="submit">Filter</button>
                    </div>

                </div>

                <div  id="ledger_employee" ></div>

            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>


<?= $this->section('java_script') ?>
<script>
    function employeeLedg(employee_id){
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('shop_admin/ledger_employee_search') ?>",
            data: {employee_id: employee_id},
            success: function(data){
                $("#ledger_employee").html(data).show();
                $("#example1").DataTable({
                    "responsive": true, "lengthChange": true, "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            }
        });
    }

    function emplLedSerc(){
        var employeeId = $('#employeeId').val();
        var st_date = $('#st_date').val();
        var en_date = $('#en_date').val();
        var error = 0;
        $('span.select2-selection').css("border-color", "white");
        $('span.select2-selection').css("background-color", "#ccc");
        $('#st_date').css("border-color", "white");
        $('#st_date').css("background-color", "#ccc");
        $('#en_date').css("border-color", "white");
        $('#en_date').css("background-color", "#ccc");


        if (employeeId == '') {
            $('span.select2-selection').css("border-color", "red");
            $('span.select2-selection').css("background-color", "#ff9393");
            error = 1;
        }
        if (st_date == '') {
            $('#st_date').css("border-color", "red");
            $('#st_date').css("background-color", "#ff9393");
            error = 1;
        }
        if (en_date == '') {
            $('#en_date').css("border-color", "red");
            $('#en_date').css("background-color", "#ff9393");
            error = 1;
        }

        if (error == 0){
            // alert("ok");
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('shop_admin/ledger_employee_search_date') ?>",
                data: {employeeId:employeeId,st_date:st_date,en_date:en_date},

                success: function(data){
                    $("#ledger_employee").html(data).show();
                    $("#example1").DataTable({
                        "responsive": true, "lengthChange": true, "autoWidth": false,
                        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                }
            });
        }
    }
</script>
<?= $this->endSection() ?>
