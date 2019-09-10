<?php
/**
 * Created by PhpStorm.
 * User: Fazlee Rabby
 * Date: 09-Jan-17
 * Time: 10:48 PM
 */
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

    if(isset($_GET['id'])){
        $admin_id = (int)($_GET['id']);
    }
    else{
        header("Location: dashboard.php"); 
    }

    $query = "SELECT * FROM admin WHERE id=:id";
    $statement = $dbcon->prepare($query);
    $statement->bindValue(":id",$admin_id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_OBJ);
?>

<?php

require_once 'includes/dashboard-header.php';

?>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>User Details : <?php echo $result->name?></h2>

                        <ul class="nav navbar-right panel_toolbox">

                            <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">
                        <br />

                        <div class="col-md-9">
                            <div class="col-md-3">
                                <h4>Username : </h4>
                            </div>
                            <div class="col-md-8">
                                <h4><?php echo $result->username?></h4>
                            </div>
                            <div class="col-md-3">
                                <h4>Name : </h4>
                            </div>
                            <div class="col-md-8">
                                <h4><?php echo $result->name?></h4>
                            </div>
                            

                            <div class="col-md-3">
                                <h4>Email : </h4>
                            </div>
                            <div class="col-md-8">
                                <h4><?php echo $result->email?></h4>
                            </div>
                            <button class="btn btn-primary" style="margin-top: 50px;"><a href="viewAdmins.php" style="color:white">Back To List</a></button>
                        </div>

                        <div class="col-md-3">
                            <img src="images/user/<?php echo $result->image?>" width="250" height="250" style="border-radius: 100%" alt="">
                        </div>

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