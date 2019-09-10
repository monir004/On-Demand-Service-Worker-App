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
                            <h2>ADD NEW CATEGORY</h2>
                            <ul class="nav navbar-right panel_toolbox">

                                <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <br />
                            <form id="createorder-form" action="add-category.php" method="post" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

                                
                                <div class="form-group" style="margin-bottom:50px;">
                                    <div class="col-md-3 col-md-offset-2">
                                        <label for="domestic">Domestic</label>
                                        <input type="checkbox" name="domestic" class="js-switch" id="domestic" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="industrial">Industrial</label>
                                        <input type="checkbox" name="industrial" class="js-switch" id="industrial" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="commercial">commercial</label>
                                        <input type="checkbox" name="commercial" class="js-switch" id="commercial" />
                                    </div>
                                </div>
                                   
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name <span>*</span>
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                        <input type="text" name="category-name" value="" required class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Status 
                                    </label>
                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                    <input type="checkbox" checked name="status" class="js-switch" id="commercial" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory"> Category Image
                                    </label>
                                    <div class="col-md-3 col-sm-4 col-xs-8">
                                        <img src="images/category/default.png?<?php echo time(); ?>" class="img-responsive" id="imagepreview" style="height:180px; width:180px; float:left; border: 1px solid #95a5a6 ;padding: 2px; margin-top:10px;" alt="">
                                        <input type="file" accept=".jpg, .jpeg" class="form-control" id="inputfile" name="category-image">
                                        <label for="inputfile" style="margin-left:0px">Choose Image</label>
                                    </div>
                                    <div class="imageuploaderdiv">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" name="create-button" style="font-size: 16px;
                                            padding: 15px 24px">ADD CATEGORY</button>
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
            $domestic = isset($_POST['domestic'])? "1" : "0";
            $industrial = isset($_POST['industrial'])? "1" : "0";
            $commercial = isset($_POST['commercial'])? "1" : "0";
            $status = isset($_POST['status'])? "active" : "inactive";

            $category= $_POST['category-name'];
            $imagename = 'default.png';

            if($_FILES['category-image']['size']>0){
                $filename = $_FILES['category-image']['name'];
                $file_array = explode('.',$filename);
                $ext = end($file_array);
                $imagename = explode(' ',$category);
                $imagename = $imagename[0];
                $imagename = $imagename . rand(1,100) . '.' . $ext;
            }

            if($_FILES['category-image']['size']>0){
                move_uploaded_file($_FILES['category-image']['tmp_name'], "images/category/" . $imagename);
            }

            $query = "INSERT INTO category(`name`,`image`,domestic,industrial,commercial,`status`) VALUES (:name,:imagename,:domestic,:industrial,:commercial,:status)";
            $statement = $dbcon->prepare($query);

            $statement->bindValue(':name',$category);
            $statement->bindValue(':imagename',$imagename);
            $statement->bindValue(':domestic',$domestic);
            $statement->bindValue(':industrial',$industrial);
            $statement->bindValue(':commercial',$commercial);
            $statement->bindValue(':status',$status);

            $statement->execute();
            echo "<script>window.location.href = \"viewCategory.php\"</script>";
        }

    ?>