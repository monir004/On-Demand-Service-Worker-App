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
                    <div class="page-title">
                        <div class="title_left">
                            <h3>CREATE NEW ADD</h3>
                        </div>

                        <div class="title_right">
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2>AD Details</h2>

                                    <ul class="nav navbar-right panel_toolbox">

                                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>

                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <br />
                                    <form id="createorder-form" action="handleAd.php" data-parsley-validate class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                                    	<div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-name">Title <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" id="ad-name" name="adName" class="form-control col-md-7 col-xs-12" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Redirect URL <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" id="ad-name" name="url" class="form-control col-md-7 col-xs-12" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="inputfile"> AD Image
                                            </label>
                                            <div class="col-md-3 col-sm-4 col-xs-8">
                                                <img src="images/imageplaceholder.jpg" class="img-responsive" id="imagepreview" style="" alt="">
                                                
                                                <input type="file" name="adImage" required accept=".jpg, .jpeg" class="form-control" id="inputfile" data-input="false" data-classIcon="icon-plus" onchange="document.getElementById('imagepreview').src = window.URL.createObjectURL(this.files[0])">
                                                <label for="inputfile" style="margin-left:0px">Choose Image</label>
                                            </div>
                                            <!-- <div class="imageuploaderdiv"></div> -->
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" id="addadBtn" name="addadEntry">Add</button>
                                        </div>
                                    </form>
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