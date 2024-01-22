<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('super_admin/shops')?>" class="brand-link">
<!--        <img src="--><?php //echo base_url()?><!--assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">-->
        <span class="brand-text font-weight-light">Amar Bangla</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php echo image_view('uploads/admin_image', '', profile_image_super(), 'no_image.jpg', 'img-circle elevation-2', '');?>
            </div>
            <div class="info">
                <a href="<?php echo base_url('super_admin/shops')?>" class="d-block"><?php echo newSession()->sup_name;?></a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="<?php echo base_url('super_admin/shops')?>" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Shops </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/shop_category')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Shop Category </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/license')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> License </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/settings')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Settings </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/shops_commission')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Shops commission </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/ledger')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Ledger </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            Customers
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('super_admin/customer_type')?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customers Type</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('super_admin/customer')?>" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer List</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/order')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Orders </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/calling_request')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Calling request </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/sellers')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Seller </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/delivery_boy')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Delivery Boy </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/agent')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p> Agent </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="<?php echo base_url('super_admin/agent')?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Global Address </p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>