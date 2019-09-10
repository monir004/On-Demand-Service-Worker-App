<?php

    require_once 'admin-functions.php';

    $dhakaAdmin = new DhakaAdmin();
    $admin_info = $dhakaAdmin->admin_info($user_name);

?>

<div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title">
                        <a href="dashboard.php" class="site_title"><span>Dhaka Setup</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="images/user/<?php echo $admin_info['admin_image'];?>?nocache=<?php echo time(); ?>" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo $admin_info['first_name'] . ' ' . $admin_info['last_name'];?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">

                            <ul class="nav side-menu">
                                
                                <li>
                                    <a class="logouttab" href="dashboard.php"><i class="fa fa-home"></i>DASHBOARD</a>
                                </li>

                                <li>
                                    <a class="logouttab" href="servicegroup.php"><i class="fa fa-home"></i>SERVICE</a>
                                </li>

                                <li>
                                    <a><i class="pe-7s-news-paper"></i>MANAGE ORDER <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a href="createorder.php">Create Order</a></li>
                                        <li><a href="createorder2.php">Create Order v2</a></li>
                                        <li><a href="manage-order2.php">Manage order v2</a></li>
                                        <li><a href="manage-order.php">View Orders</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a><i class="fa fa-graduation-cap"></i>ADMIN <span class="fa fa-chevron-down"></span></a>

                                    <ul class="nav child_menu">
                                        <li><a href="create-admin.php">Add New Admin</a></li>
                                        <li><a href="viewAdmins.php">View Admins</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a><i class="fa fa-paper-plane-o"></i>CATEGORY <span class="fa fa-chevron-down"></span></a>

                                    <ul class="nav child_menu">
                                        <li><a href="add-category.php">Add New Category</a></li>
                                        <li><a href="viewCategory.php">All Categories</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a><i class="fa fa-paper-plane-o"></i>SUBCATEGORY <span class="fa fa-chevron-down"></span></a>

                                    <ul class="nav child_menu">
                                        <li><a href="add-subcategory.php">Add New Subcategory</a></li>
                                        <li><a href="viewSubcategory.php">All Subcategories</a></li>
                                    </ul>
                                </li>
                                
                                <li>
                                    <a><i class="fa fa-paper-plane-o"></i>SERVICE <span class="fa fa-chevron-down"></span></a>

                                    <ul class="nav child_menu">
                                        <li><a href="createservices.php">Add New Service</a></li>
                                        <li><a href="ViewService.php">View All Services</a></li>
                                    </ul>
                                </li>
				<li>
                                    <a><i class="fa fa-paper-plane-o"></i>ADs <span class="fa fa-chevron-down"></span></a>

                                    <ul class="nav child_menu">
                                        <li><a href="ad.php">Add New AD</a></li>
                                        <li><a href="viewad.php">View All Ads</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="Report.php"><i class="fa fa-book"></i>REPORTING</a> 
                                    <!-- <span class="fa fa-chevron-down"></span>

                                    <ul class="nav child_menu">
                                        <li><a href="index.html">Demo 1</a></li>
                                        <li><a href="index2.html">Demo 2</a></li>
                                        <li><a href="index3.html">Demo 3</a></li>
                                    </ul> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /sidebar menu -->
                </div>
            </div>