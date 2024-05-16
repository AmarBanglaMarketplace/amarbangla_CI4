<?= $this->extend('Agent/layout') ?>

<?= $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Delivery boy update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('agent/dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active">Delivery boy update</li>
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
                            <h3 class="card-title">Delivery boy update</h3>
                            <a href="<?= base_url('agent/delivery_boy'); ?>" class="btn btn-xs btn-danger w-25 float-right">Back</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <?php echo  isset(newSession()->message) ? newSession()->message :''; ?>
                            </div>
                            <div class="card card-primary card-outline card-outline-tabs">
                                <div class="card-header p-0 border-bottom-0">
                                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo (!empty($_GET) && ($_GET['active'] == 'general'))?'active':'';?> <?php echo(empty($_GET))?'active':'';?>" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Registraion Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo(!empty($_GET) && ($_GET['active'] == 'personal'))?'active':'';?>" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile" aria-selected="false">Personal</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo(!empty($_GET) && ($_GET['active'] == 'user'))?'active':'';?>" id="custom-tabs-four-settings-tab" data-toggle="pill" href="#custom-tabs-four-settings" role="tab" aria-controls="custom-tabs-four-settings" aria-selected="false">Address</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link <?php echo(!empty($_GET) && ($_GET['active'] == 'photo'))?'active':'';?> " id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-four-messages" role="tab" aria-controls="custom-tabs-four-messages" aria-selected="false">Photo</a>
                                        </li>


                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade <?php echo (!empty($_GET) && ($_GET['active'] == 'general'))?'active show':'';?> <?php echo(empty($_GET))?'active show':'';?> " id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?php echo base_url('agent/delivery_boy_update_action'); ?>" method="post">

                                                        <div class="form-group">
                                                            <label for="varchar">Name </label>
                                                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo  $delivery->name; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="int">Mobile </label>
                                                            <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Mobile" value="<?php echo $delivery->mobile; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="int">Password </label>
                                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="int">Confirm Password </label>
                                                            <input type="password" class="form-control" name="con_password" id="password" placeholder="Confirm Password" required/>
                                                        </div>

                                                        <input type="hidden" name="delivery_boy_id" value="<?php echo $delivery->delivery_boy_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>

                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade <?php echo (!empty($_GET) && ($_GET['active'] == 'personal'))?'active show':'';?>" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?php echo base_url('agent/delivery_boy_personal_update'); ?>" method="post">

                                                        <div class="form-group">
                                                            <label for="varchar">Father Name </label>
                                                            <input type="text" class="form-control" name="father_name" id="father_name" placeholder="Father Name" value="<?php echo $delivery->father_name; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="int">Mother Name </label>
                                                            <input type="text" class="form-control" name="mother_name" id="mother_name" placeholder="Mother Name" value="<?php echo  $delivery->mother_name; ?>"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="int">Age </label>
                                                            <input type="text" class="form-control" name="age" id="age" placeholder="Age" value="<?php echo $delivery->age; ?>"/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="int">Status </label>
                                                            <select class="form-control" name="status">
                                                                <?php echo globalStatus($delivery->status)?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Agent </label>
                                                            <select name="agent_id" class="form-control" id="agent_id">
                                                                <option value="">Please select</option>
                                                                <?php echo getListInOption($delivery->agent_id, 'agent_id', 'agent_name', 'agent'); ?>
                                                            </select>
                                                        </div>


                                                        <input type="hidden" name="delivery_boy_id" value="<?php echo $delivery->delivery_boy_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade <?php echo(!empty($_GET) && ($_GET['active'] == 'user'))?'active show':'';?>" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?php echo base_url('agent/delivery_boy_address_update'); ?>" method="post">
                                                        <div class="form-group">
                                                            <label for="varchar">Division </label>
                                                            <select class="form-control" name="division" onchange="viewdistrict(this.value)">
                                                                <option>Please Select</option>
                                                                <?php echo divisionView($address->division); ?>
                                                            </select>


                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">District </label>
                                                            <select class="form-control" name="district" onchange="viewupazila(this.value)" id="district">
                                                                <option>Please Select</option>
                                                                <?php echo districtselect($address->zila,$address->division); ?>
                                                            </select>

                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Upazila </label>
                                                            <select class="form-control" name="upazila" id="upazila">
                                                                <option>Please Select</option>
                                                                <?php echo upazilaselect($address->upazila,$address->zila); ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Pourashava/Union </label> <span style="color: red;">*</span>

                                                            <select class="form-control" name="pourashava">
                                                                <option>Please Select</option>
                                                                <?php echo pourashavaUnion($address->pourashava); ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Ward </label>
                                                            <span style="color: red;">*</span>
                                                            <select class="form-control" name="ward" required>
                                                                <option value="">Please Select</option>
                                                                <?php echo wardView($address->ward); ?>
                                                            </select>
                                                        </div>

                                                        <input type="hidden" name="delivery_boy_id" value="<?php echo $delivery->delivery_boy_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade <?php echo(!empty($_GET) && ($_GET['active'] == 'photo'))?'active show':'';?>" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?php echo base_url('agent/delivery_boy_photo_update'); ?>" method="post" enctype="multipart/form-data">

                                                        <div class="form-group">
                                                            <?php echo image_view('uploads/delivery_boy_image', '', $delivery->pic, 'no_image.jpg', 'w-25', '');?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="longtext">Image </label>
                                                            <input type="file" class="form-control" name="pic"/>
                                                            <span class="help-block"><b>Max. file size 1024KB and (width=300px) x (height=300px)</b></span>
                                                        </div>

                                                        <input type="hidden" name="delivery_boy_id" value="<?php echo $delivery->delivery_boy_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- /.card -->
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