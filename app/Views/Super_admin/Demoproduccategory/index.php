<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product category</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('super_admin/shops')?>">Home</a></li>
                        <li class="breadcrumb-item active">Product category</li>
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
                            <a href="<?php echo base_url('super_admin/demo_product_category_create');?>" class="btn btn-xs btn-primary w-25 float-right">Create</a>
                            <h3 class="card-title">Product category list</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  foreach ($proCategory as $val){
                                    $parentCat = get_data_by_id('parent_pro_cat','demo_category','cat_id',$val->cat_id);
                                    $pCat = (!empty($parentCat))?get_data_by_id('product_category','demo_category','cat_id',$parentCat).' >':'';
                                    ?>
                                    <tr>
                                        <td><?php echo $val->cat_id;?></td>
                                        <td><?php echo $pCat.$val->product_category;?></td>
                                        <td width="160px">
                                            <a href="<?php echo base_url('super_admin/demo_product_category_update/'.$val->cat_id);?>" class="btn btn-xs btn-warning ">Update</a>
                                            <a href="<?php echo base_url('super_admin/demo_product_category_delete/'.$val->cat_id);?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-xs btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
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