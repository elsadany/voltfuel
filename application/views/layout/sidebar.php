<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <!-- <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span class="menu-arrow"></span></a>
                </li> -->
                <li class="<?php echo set_Topmenu('Dashboard'); ?>"> 
                    <a href="<?php echo base_url(); ?>admin/dashboard"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li class="<?php echo set_Topmenu('Outlets'); ?>"> 
                    <a href="<?php echo base_url(); ?>admin/outlets"><i class="la la-user-secret"></i> <span>Outlets</span></a>
                </li>
                <li class="<?php echo set_Topmenu('Devices'); ?>"> 
                    <a href="<?php echo base_url(); ?>admin/stations"><i class="la la-user-secret"></i> <span>Devices</span></a>
                </li>
                <li class="<?php echo set_Topmenu('Orders'); ?>"> 
                    <a href="<?php echo base_url(); ?>admin/orders"><i class="la la-user"></i> <span>Orders</span></a>
                </li>
                <li class="<?php echo set_Topmenu('Termsandconditions'); ?>"> 
                    <a href="<?php echo base_url(); ?>admin/termsandconditions"><i class="la la-user-secret"></i> <span>Terms & Conditions</span></a>
                </li> 
                <li class="<?php echo set_Topmenu('Privacypolicy'); ?>"> 
                    <a href="<?php echo base_url(); ?>admin/privacypolicy"><i class="la la-user-secret"></i> <span>Privacy Policy</span></a>
                </li>                
                <li class="submenu <?php echo set_Topmenu('Subscribers'); ?>"> 
                    <a href=""><i class="la la-user-secret"></i> <span>Subscribers</span><span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="<?php echo set_Submenu('installations'); ?>"><a href="<?php echo base_url(); ?>subscribers/installs">Installations</a></li>
                        <li class="<?php echo set_Submenu('subscriberslist'); ?>"><a href="<?php echo base_url(); ?>subscribers">Subscribers</a></li>
                    </ul>
                </li>
                <li class="submenu <?php echo set_Topmenu('Pricings'); ?>"> 
                    <a href="#"><i class="la la-dollar"></i> <span>Pricing Plans</span><span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li class="<?php echo set_Submenu('categories'); ?>"><a href="<?php echo base_url(); ?>admin/pricings/categories">Categories</a></li>
                        <!-- <li class="<?php echo set_Submenu('plans'); ?>"><a href="<?php echo base_url(); ?>admin/pricings">Plans</a></li> -->
                        <li class="<?php echo set_Submenu('plans'); ?>"><a href="<?php echo base_url(); ?>admin/pricings/pricingplanone">Plan-1</a></li>
                    </ul>
                </li>
                <!-- <li class="submenu <?php echo set_Topmenu('Orders'); ?>">
                    <a href="#"><i class="la la-user"></i> <span> Orders</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a href="<?php echo base_url(); ?>admin/orders/all">All Orders</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/orders/active">In renting Orders</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/pricings/finished">Finished Orders</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/pricings/cancelled">Cancelled Orders</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/pricings/timeout">Time out Orders</a></li>
                        <li><a href="<?php echo base_url(); ?>admin/pricings/error">Error Orders</a></li>
                    </ul>
                </li> -->
                <!-- <li> 
                    <a href=""><i class="la la-ticket"></i> <span>Tickets</span></a>
                </li>

                <li> 
                    <a href=""><i class="la la-file-pdf-o"></i> <span>Policies</span></a>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-pie-chart"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                    </ul>
                </li>
                <li> 
                    <a href=""><i class="la la-user-plus"></i> <span>Admin Users</span></a>
                </li>
                <li> 
                    <a href=""><i class="la la-cog"></i> <span>Settings</span></a>
                </li> -->

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
