<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Customer update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('super_admin/shops')?>">Home</a></li>
                        <li class="breadcrumb-item active">Customer update</li>
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
                            <h3 class="card-title">Customer update</h3>
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
                                                    <form action="<?php echo base_url('super_admin/customer_update_action'); ?>" method="post">

                                                        <div class="form-group">
                                                            <label for="varchar">CustomerName</label>
                                                            <input type="text" class="form-control" name="customer_name" id="CustomerName" placeholder="CustomerName" value="<?php echo $category->customer_name; ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="int">Mobile </label>
                                                            <input type="text" class="form-control" name="mobile" id="Mobile" placeholder="Mobile" value="<?php echo $category->mobile; ?>" />
                                                        </div>
                                                        <div class="form-group has-feedback">
                                                            <label for="int">Password</label>
                                                            <input type="password" class="form-control" placeholder="Password" name="password" required  />
                                                        </div>
                                                        <div class="form-group has-feedback">
                                                            <label for="int">Confirm Password </label>
                                                            <input type="password" class="form-control" placeholder="Conform Password" name="con_password" required  />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="varchar">User Type</label>
                                                            <select class="form-control" name="cus_type_id" >
                                                                <?php echo getListInOption($category->cus_type_id,'cus_type_id','type_name', 'customer_type')?>
                                                            </select>
                                                        </div>

                                                        <input type="hidden" name="customer_id" value="<?php echo $category->customer_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="<?php echo site_url('super_admin/customer') ?>" class="btn btn-danger">Cancel</a>

                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade <?php echo (!empty($_GET) && ($_GET['active'] == 'personal'))?'active show':'';?>" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?php echo base_url('super_admin/customer_personal_update'); ?>" method="post">

                                                        <div class="form-group">
                                                            <label for="varchar">FatherName</label>
                                                            <input type="text" class="form-control" name="father_name" id="FatherName" placeholder="FatherName" value="<?php echo $category->father_name; ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="varchar">MotherName</label>
                                                            <input type="text" class="form-control" name="mother_name" id="MotherName" placeholder="MotherName" value="<?php echo $category->mother_name; ?>" />
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Age</label>
                                                            <input type="text" class="form-control" name="age" id="Age" placeholder="Age" value="<?php echo $category->age; ?>" />
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="int">NID</label>
                                                            <input type="text" class="form-control" name="nid" id="NID" placeholder="NID" value="<?php echo $category->nid; ?>" />
                                                        </div>


                                                        <input type="hidden" name="customer_id" value="<?php echo $category->customer_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="<?php echo site_url('super_admin/customer') ?>" class="btn btn-danger">Cancel</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade <?php echo(!empty($_GET) && ($_GET['active'] == 'user'))?'active show':'';?>" id="custom-tabs-four-settings" role="tabpanel" aria-labelledby="custom-tabs-four-settings-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?php echo base_url('super_admin/customer_address_update'); ?>" method="post">
                                                        <div class="form-group">
                                                            <label for="varchar">Division </label>
                                                            <select class="form-control" name="division" onchange="viewdistrict(this.value)"  >
                                                                <option>Please Select</option>
                                                                <?php echo divisionView($address->division) ; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">District  </label>
                                                            <select class="form-control" name="district" onchange="viewupazila(this.value)" id="district" required>
                                                                <option>Please Select</option>
                                                                <?php echo districtselect($address->zila,$address->division) ; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Upazila  </label>
                                                            <select class="form-control" name="upazila" id="upazila"  required>
                                                                <option>Please Select</option>
                                                                <?php echo upazilaselect($address->upazila,$address->zila) ; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Pourashava/Union  </label>
                                                            <select class="form-control" name="pourashava"  >
                                                                <option>Please Select</option>
                                                                <?php echo pourashavaUnion($address->pourashava) ; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">Ward </label>
                                                            <select class="form-control" name="ward">
                                                                <option>Please Select</option>
                                                                <?php echo wardView($address->ward) ; ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="varchar">House Address </label>
                                                            <textarea name="address" class="form-control"><?php echo $category->address ?></textarea>
                                                        </div>

                                                        <input type="hidden" name="customer_id" value="<?php echo $category->customer_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="<?php echo site_url('super_admin/customer') ?>" class="btn btn-danger">Cancel</a>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade <?php echo(!empty($_GET) && ($_GET['active'] == 'photo'))?'active show':'';?>" id="custom-tabs-four-messages" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form action="<?php echo base_url('super_admin/customer_photo_update'); ?>" method="post" enctype="multipart/form-data">

                                                        <div class="form-group">
                                                            <?php echo image_view('uploads/customer_image', '', $category->pic, 'no_image.jpg', 'w-25', '');?><br>
                                                            <label for="varchar">Photo </label>
                                                            <input type="file" class="form-control" name="pic" id="pic" />
                                                            <span class="help-block"><b>Max. file size 1024KB and (width=300px) x (height=300px)</b></span>
                                                        </div>

                                                        <input type="hidden" name="customer_id" value="<?php echo $category->customer_id; ?>" >
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="<?php echo site_url('super_admin/customer') ?>" class="btn btn-danger">Cancel</a>
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