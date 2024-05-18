<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Product List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('super_admin/shops') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Product List</li>
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
                            <a href="<?php echo base_url('super_admin/demo_product'); ?>" class="btn btn-xs btn-primary float-right"><i class="fas fa-list"></i> Product add</a>
                            <h3 class="card-title">Product List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row" >
                                <div class="col-md-12" id="message">
                                    <?php echo  isset(newSession()->message) ? newSession()->message :''; ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="int">Product Filter</label>
                                    <input type="text" class="form-control" oninput="_productNameSearch(this.value)" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="int">Category Filter</label>
                                    <select class="form-control" style="text-transform:capitalize;" onchange="_prodSearch(this.value)">
                                        <option value="">Please select</option>
                                        <?php foreach ($category as $cat) { ?>
                                            <optgroup label="---------------------------------">
                                                <option value="<?php echo $cat->cat_id; ?>" style="font-weight: bold; "><?php echo $cat->product_category; ?></option>
                                                <?php echo subCatDemoOption($cat->cat_id) ?>
                                            </optgroup>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped" id="example2">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Purchase price</th>
                                            <th>Selling price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="subCat">
                                    <?php foreach ($product as $val) { ?>
                                        <tr id="update_row_<?= $val->id;?>">
                                            <td><?php echo $val->id ?></td>
                                            <td><?php echo $val->name ?></td>

                                            <td><?php echo demo_singleImage_by_productId($val->id,'70','0','');?> </td>
                                            <td><?php echo get_data_by_id('product_category', 'demo_category', 'cat_id', $val->prod_cat_id) ?></td>
                                            <td>
                                                <p onclick="updateFunction('<?= $val->id ?>', 'purchase_price', '<?= $val->purchase_price ?>', 'pur_view_<?= $val->id ?>', 'pur_price_update_<?= $val->id ?>','update_row_<?= $val->id;?>')"><?php echo showWithCurrencySymbol($val->purchase_price) ?></p>
                                                <p id="pur_view_<?= $val->id;?>"></p>
                                            </td>
                                            <td>
                                                <p onclick="updateFunction('<?= $val->id ?>', 'selling_price', '<?= $val->selling_price ?>', 'sel_view_<?= $val->id ?>', 'sell_price_update_<?= $val->id ?>','update_row_<?= $val->id;?>')"><?php echo showWithCurrencySymbol($val->selling_price) ?></p>
                                                <p id="sel_view_<?= $val->id;?>"></p>
                                            </td>

                                            <td>
                                                <a href="<?php echo site_url('super_admin/demo_product_update/' . $val->id) ?>" class="btn btn-xs btn-info ">Edit</a>
                                                <a href="<?php echo site_url('super_admin/demo_product_delete/' . $val->id) ?>" onclick="javasciprt: return confirm('Are You Sure ?')" class="btn btn-xs btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Purchase price</th>
                                            <th>Selling price</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
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