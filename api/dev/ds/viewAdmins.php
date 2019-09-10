<?php
        session_start();
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        require_once 'includes/connection.php';

        
        $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
        if($loggedin != 'True'){
            echo "<script>window.location.href = \"login.php\"</script>";
        }
        else{
            $user_name = $_SESSION['user_name'];
        }

    $query = "SELECT * FROM admin";
    $statement = $dbcon->prepare($query);
    $statement->execute();

?>

<?php

require_once 'includes/dashboard-header.php';

?>

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                        </div>

                        <div class="title_right">
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>ALL USERS</h2>

                                    <ul class="nav navbar-right panel_toolbox">

                                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>

                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <br />

                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>User Email</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($result = $statement->fetch(PDO::FETCH_OBJ)) : ?>
                                            <tr>
                                                <td><?php echo $result->first_name . " " . $result->last_name?></td>
                                                <td><?php echo $result->admin_email?></td>
                                                <td class="action text-center"><a href="adminDetails.php?id=<?php echo $result->Id?>" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                 <!-- &nbsp;&nbsp;/&nbsp;&nbsp;<a  href="edit-profile.php?id=<?php //echo $result->Id?>" title="Edit Details"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> -->
                                                </td>
                                            </tr>
                                         <?php endwhile;?>
                                        </tbody>
                                    </table>

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