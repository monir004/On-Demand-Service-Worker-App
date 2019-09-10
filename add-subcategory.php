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
    require_once 'includes/dashboard-header.php';

    $sql = "SELECT id as cat_id, name as cat_name FROM category";
    $statement = $dbcon->prepare($sql);
    $statement->execute();
                
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
                            <h2>ADD NEW SUBCATEGORY</h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <br />
                            <form action="add-subcategory.php" method="post" data-parsley-validate class="form-horizontal form-label-left">

                                
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status 
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                    <input type="checkbox" checked name="status" class="js-switch" id="commercial" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"">SELECT CATEGORY <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <select name="category" required class="form-control" id="">
                                            <option value="">--SELECT CATEGORY--</option>
                                            <?php
                                            while ($result = $statement->fetch(PDO::FETCH_OBJ)){
                                                echo "<option value='".$result->cat_id."'>".$result->cat_name."</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                   
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subcat-name">SUBCATEGORY NAME <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" name="subcat-name" required value="" class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" name="create-subcat" style="font-size: 16px;
                                            padding: 15px 24px">ADD SUBCATEGORY</button>
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

        <?php

        if(isset($_POST['create-subcat'])){
            $category = $_POST['category'];
            $subcat_name = $_POST['subcat-name'];
            $status = isset($_POST['status'])? "active" : "inactive";

            $sql = "INSERT INTO subcategory(name,category_id,status) VALUES (:name, :category,:status)";
            $query = $dbcon->prepare($sql);
            $query->bindValue(':name',$subcat_name);
            $query->bindValue(':category',$category);
            $query->bindValue(':status',$status);

            $query->execute();
            echo "<script>window.location.href = \"viewSubcategory.php\"</script>";
        }

        ?>
        