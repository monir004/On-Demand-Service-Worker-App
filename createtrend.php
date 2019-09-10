<?php

    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
    if($loggedin != 'True'){
        echo "<script>window.location.href = \"login.php\"</script>";
    }
    else{
        $user_name = $_SESSION['user_name'];
    }

    require_once 'admin-functions.php';
    require_once 'includes/connection.php';
    
    require_once 'includes/dashboard-header.php'
                
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3></h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>ADD NEW TRENDING</h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <br />
                            <form id="createorder-form" action="createtrend.php" method="post" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

                                
                                   
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Trending Title <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" name="trend-name" value="" required class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>


                                

                                <div class="form-group">
                                    <button class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" name="create-button" style="font-size: 16px;
                                            padding: 15px 24px">ADD TRENDING</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        <?php

            require_once 'includes/dashboard-footer.php'
                

        ?>
        
    <?php

        if(isset($_POST['create-button'])){

            $trend= $_POST['trend-name'];

            $query = "INSERT INTO `trending`(`name`) VALUES (:name)";
            $statement = $dbcon->prepare($query);

            $statement->bindValue(':name',$trend);

            $statement->execute();
            echo "<script>window.location.href = \"ViewTrend.php\"</script>";
        }

    ?>