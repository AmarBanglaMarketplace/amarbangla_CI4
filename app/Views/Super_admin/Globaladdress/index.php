<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Global Address</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('super_admin/shops')?>">Home</a></li>
                        <li class="breadcrumb-item active">Global Address</li>
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
                            <a href="<?php echo base_url('super_admin/global_address_create');?>" class="btn btn-xs btn-primary w-25 float-right">Create</a>
                            <h3 class="card-title">Global Address list</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12 mb-2">
                                <form action="<?php echo site_url('global_address/search'); ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="varchar">Division </label>
                                            <select class="form-control" name="division" onchange="viewdistrict(this.value)" required >
                                                <option value="">Please Select</option>
                                                <?php echo divisionView(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="varchar">District </label>
                                            <select class="form-control" name="district" onchange="viewupazila(this.value)" id="district" >
                                                <option value="">Please Select</option>
                                                <?php echo districtselect(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="varchar">Upazila </label>
                                            <select class="form-control" name="upazila" id="upazila" onchange="checkCity(this.value)" >
                                                <option value="">Please Select</option>
                                                <?php echo upazilaselect(); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Division</th>
                                        <th>Zila</th>
                                        <th>Upazila</th>
                                        <th>Pourashava</th>
                                        <th>Ward</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i=1; foreach ($address_data as $address) { ?>
                                    <tr>
                                        <td width="80px"><?php echo $i++ ?></td>
                                        <td><?php echo divisionname($address->division) ?></td>
                                        <td><?php echo districtname($address->zila) ?></td>
                                        <td><?php echo upazilaname($address->upazila) ?></td>
                                        <td><?php echo pourashavaUnionName($address->pourashava) ?></td>
                                        <td><?php echo getwardname($address->ward) ?></td>
                                        <td width="160px">
                                            <a href="<?php echo base_url('super_admin/global_address_update/'.$address->global_address_id);?>" class="btn btn-xs btn-warning ">Update</a>
                                            <a href="<?php echo base_url('super_admin/global_address_delete/'.$address->global_address_id);?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-xs btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Division</th>
                                        <th>Zila</th>
                                        <th>Upazila</th>
                                        <th>Pourashava</th>
                                        <th>Ward</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
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