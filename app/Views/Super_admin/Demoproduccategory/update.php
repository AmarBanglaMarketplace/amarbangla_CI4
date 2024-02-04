<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product category update</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('super_admin/shops')?>">Home</a></li>
                        <li class="breadcrumb-item active">Product category update</li>
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
                            <h3 class="card-title">Product category update</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo  isset(newSession()->message) ? newSession()->message :''; ?>
                                </div>
                                <div class="col-md-6">
                                    <form action="<?php echo base_url('super_admin/demo_product_category_update_action'); ?>" method="post">
                                        <div class="form-group">
                                            <label for="varchar">Category </label>
                                            <input type="text" class="form-control" name="product_category" id="product_category" placeholder="Product Category" value="<?php echo $category->product_category; ?>" />
                                        </div>
                                        <div class="form-group">
                                            <label for="varchar">Parent Category </label>
                                            <select class="form-control" name="parent_pro_cat">
                                                <option value="">Please Select</option>
                                                <?php echo subCategoryListOptionSuper($category->parent_pro_cat); ?>
                                            </select>
                                        </div>

                                        <input type="hidden" name="cat_id" value="<?php echo $category->cat_id; ?>" />
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="<?php echo site_url('super_admin/demo_product_category') ?>" class="btn btn-danger">Cancel</a>
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