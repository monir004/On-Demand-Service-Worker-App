<?php
        session_start();

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require_once 'admin-functions.php';
        $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
         if($loggedin != 'True'){
            echo "<script>window.location.href = \"login.php\"</script>";
        }
        else{
            $user_name = $_SESSION['user_name'];
        }
    
?>
                <?php

                require_once 'includes/dashboard-header.php';

                ?>

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="page-title">
                            <div class="title_left">
                                <h3>CREATE NEW ADMINISTRATOR</h3>
                            </div>

                            <div class="title_right">
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>ADMINISTRATOR INFORMATION</h2>

                                        <ul class="nav navbar-right panel_toolbox">

                                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                            </li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="x_content">
                                        <br />
                                        <form id="createorder-form" action="" data-toggle="validator" class="form-horizontal form-label-left" method="post" role="form">

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_name">User Name<span>*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="text" id="user_name" class="form-control col-md-7 col-xs-12" name="user_name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span>*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="text" id="first-name" class="form-control col-md-7 col-xs-12" name="first_name" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="text" id="last-name" class="form-control col-md-7 col-xs-12" name="last_name" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="admin_email">Email<span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="email" id="admin_email" name="admin_email" class="form-control col-md-7 col-xs-12" data-error="Opps!!, email address is invalid"required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="form-group has-feedback">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="admin_pass">Password<span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="password" id="admin_pass" class="form-control col-md-7 col-xs-12" name="admin_pass" data-minlength="6" pattern="[_A-z0-9]{1,}" required>
                                                    <div class="help-block with-errors">Minimum of 6 characters</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="cnf_admin_pass">Confirm Password<span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <input type="password" id="cnf_admin_pass" name="cnf_admin_pass" class="form-control col-md-7 col-xs-12" data-match="#admin_pass" data-match-error="Whoops, these don't match" required>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-default col-md-offset-3 col-sm-offset-3" name="addNewAdmin">Add New Admin</button>
                                            </div>
                                        </form>
                                        <?php
                                        if (isset($_POST['addNewAdmin'])) {
                                            $user_name = $_POST["user_name"];
                                            $first_name = $_POST["first_name"];
                                            $last_name = $_POST["last_name"];
                                            $admin_email = $_POST["admin_email"];
                                            $admin_pass = md5($_POST["admin_pass"]);
                                            $admin_created = date('Y-m-d H:i:s');
                                            $create_admin = new DhakaAdmin();
                                            $create_admin -> create_admin($user_name, $first_name, $last_name, $admin_email, $admin_pass, $admin_created); 
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php

                    require_once 'includes/dashboard-footer.php';

                    ?>
    </body>

</html>