<?php

    require_once 'admin-functions.php';

    $dhakaAdmin = new DhakaAdmin();
    $admin_info = $dhakaAdmin->admin_info($user_name);

    
?>

<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <img src="images/user/<?php echo $admin_info['admin_image'];?>?nocache=<?php echo time(); ?>" alt=""><?php echo $admin_info['first_name'];?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="edit-profile.php?id=<?php echo $admin_info['Id'];?>"> Profile</a></li>
                        <li><a href="logout-dhaka-admin.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                    </a>
                    <!-- <span class="badge bg-green">6</span>
                    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                        <li>
                            <a>
                                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                <span>
                                            <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                <span>
                                            <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                <span>
                                            <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                            </a>
                        </li>
                        <li>
                            <a>
                                <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                                <span>
                                            <span>John Smith</span>
                                <span class="time">3 mins ago</span>
                                </span>
                                <span class="message">
                                            Film festivals used to be do-or-die moments for movie makers. They were where...
                                            </span>
                            </a>
                        </li>
                        <li>
                            <div class="text-center">
                                <a>
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul> -->
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->
