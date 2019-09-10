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
        require_once 'includes/connection.php';

$query = "SELECT * FROM ad";
$query = $dbcon->query($query);
$i=1;
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
                                    <h2>ALL ADs</h2>
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
                                                <th style="text-align: center;">Sl. No.</th>
                                                <th style="text-align: center;">Title</th>
                                                <th style="text-align: center;">AD Image</th>
                                                <th style="text-align: center;">URL</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                            <?php while ($ad = $query->fetch(PDO::FETCH_OBJ)) : ?>
                                            <tr>
                                                <th style="text-align: center; vertical-align: middle"><?php echo $i++?></th>
                                                <th style="text-align: center; vertical-align: middle"><?php echo $ad->ad_name?></th>
                                                <th style="text-align: center; vertical-align: middle"><img src="images/ad/<?php echo $ad->ad_image?>" height="100" width="100" alt=""></th>
                                                <th style="text-align: center; vertical-align: middle"><?php echo $ad->link?></th>
                                                <th style="text-align: center; vertical-align: middle"><a href="handleAd.php?deletedId=<?php echo $ad->id?>"><i class="fa fa-trash-o"></i></a></th>
                                            </tr>
                                        <?php endwhile;?>
                                        </thead>
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
