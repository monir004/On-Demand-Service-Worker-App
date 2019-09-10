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
?>


    <?php

            require_once 'includes/dashboard-header.php';

            ?>
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form action="csv.php" method="post">
                            <button class="btn btn-default download" name="ord_btn">Order CSV</button>
                        </form>
                    </div>
                </div>
            </div>   

                <?php 

                require_once 'includes/dashboard-footer.php';

                ?>
                    </body>

                    </html>