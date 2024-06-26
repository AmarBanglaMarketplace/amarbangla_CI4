<?= $this->extend('Agent/layout') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Delivery boy create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('agent/dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Delivery boy create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Delivery boy create</h3>
                            <a href="<?= base_url('agent/delivery_boy'); ?>" class="btn btn-xs btn-danger w-25 float-right">Back</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo  isset(newSession()->message) ? newSession()->message :''; ?>
                                </div>
                                <div class="col-md-6">
                                    <form action="<?php echo base_url('agent/delivery_boy_action'); ?>" method="post">
                                        <div class="form-group">
                                            <label for="varchar">Name </label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="" />
                                        </div>
                                        <div class="form-group">
                                            <label for="varchar">Phone </label>
                                            <input type="number" class="form-control" name="mobile" id="mobile" placeholder="mobile " value="" />
                                        </div>
                                        <div class="form-group">
                                            <label for="varchar">Password</label>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password " value="" />
                                        </div>

                                        <div class="form-group">
                                            <label for="varchar">Confirm Password</label>
                                            <input type="password" class="form-control" name="con_password" id="con_password" placeholder="Password " value="" />
                                        </div>

                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>


<?= $this->section('java_script') ?>
    <script>

    </script>
<?= $this->endSection() ?>