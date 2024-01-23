<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('super_admin/shops')?>">Home</a></li>
                        <li class="breadcrumb-item active">Order</li>
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
                            <h3 class="card-title">Order list</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice Id</th>
                                    <th>Total</th>
                                    <th>Create date</th>
                                    <th>Status</th>
                                    <th>Delivery Status</th>
                                    <th>Customer order list</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php  foreach ($order as $view){ ?>
                                    <tr>
                                        <td><?php echo $view->invoice_id;?></td>
                                        <td><a href="<?php echo site_url('super_admin/order_invoice/' . $view->invoice_id) ?>">View Invoice</a></td>
                                        <td><?php echo showWithCurrencySymbol($view->final_amount); ?></td>
                                        <td>
                                            <?php echo invoiceDateFormat($view->createdDtm); ?>
                                        </td>
                                        <td><?php echo getinvoiceStatusNew($view->invoice_id); ?></td>

                                        <td>
                                            <?php
                                            if (!empty(deliverystatus($view->invoice_id))) {
                                                foreach (deliverystatus($view->invoice_id) as $row) {
                                                    $detail = 'Delivery By Admin';
                                                    if (!empty($row->delivery_boy_id)) {
                                                        $name = get_data_by_id('name', 'delivery_boy', 'delivery_boy_id', $row->delivery_boy_id);
                                                        $phone = get_data_by_id('mobile', 'delivery_boy', 'delivery_boy_id', $row->delivery_boy_id);
                                                        $detail = $name . '<br>' . showWithPhoneNummberCountryCode($phone);
                                                    }

                                                    if ($row->status == 0) {
                                                        echo '<span class="label bg-info p-1">Accepted</span><br>' .$detail. '<br>';
                                                    }
                                                    if ($row->status == 1) {
                                                        echo '<span class="label bg-success p-1">Complete</span><br>' . $detail . '<br>';

                                                    }
                                                }
                                            }else{
                                                echo '<span class="label bg-warning p-1">Not Accepted</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo site_url('super_admin/customer_order_list/'.$view->customer_id)?>" class="btn btn-xs btn-success" target="_blank">Order list</a>
                                        </td>

                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice Id</th>
                                    <th>Total</th>
                                    <th>Create date</th>
                                    <th>Status</th>
                                    <th>Delivery Status</th>
                                    <th>Customer order list</th>
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