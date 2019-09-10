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

    if(isset($_GET['id'])){
        $admin_id = (int)($_GET['id']);
    }
    else{
        header("Location: dashboard.php"); 
    }
    require_once 'admin-functions.php';
        require_once 'includes/connection.php';


    $query = "SELECT * FROM admin WHERE id=:id";
    $statement = $dbcon->prepare($query);
    $statement->bindValue(":id",$admin_id);
    $statement->execute();
    $admin_details = $statement->fetch(PDO::FETCH_OBJ);
    
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
                                    <h2>UPDATE INFORMATION: <span class="text-capitalize"><em><?php echo $admin_details->user_name;?></em></span></h2>

                                    <ul class="nav navbar-right panel_toolbox">

                                        <li style="float: right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>

                                    </ul>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x_content">
                                    <br />
                                    <form id="createorder-form" action="edit-profile.php" method="post" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">First Name <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" name="first-name" value="<?php echo $admin_details->first_name;?>" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Last Name <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="text" name="last-name" value="<?php echo $admin_details->last_name;?>" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="change-password">New Password <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="password" name="change-password" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm-password">Confirm Password <span>*</span>
                                            </label>
                                            <div class="col-md-5 col-sm-6 col-xs-12">
                                                <input type="password" name="confirm-password" class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="service-subcategory"> Profile Image
                                            </label>
                                            <div class="col-md-3 col-sm-4 col-xs-8">
                                                <img src="images/user/<?php echo $admin_details->admin_image;?>?<?php echo time(); ?>" class="img-responsive" id="imagepreview" style="height:180px; width:180px; float:left; border: 1px solid #95a5a6 ;padding: 2px; margin-top:10px;" alt="">
                                                <input type="file" accept=".jpg, .jpeg" class="form-control" id="inputfile" name="imageuploader">
                                                <label for="inputfile" style="margin-left:0px">Choose Image</label>
                                            </div>
                                            <div class="imageuploaderdiv">

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-default col-md-offset-3 col-sm-offset-3 pull-right" name="update-button" style="font-size: 16px;
                                            padding: 15px 24px">Update</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <?php

            require_once 'includes/dashboard-footer.php'
                

      // if(isset($_POST['update-button'])){
      //     $firstName = trim($_POST['first-name']);
      //     $lastName = trim($_POST['last-name']);
      //     $password = $admin_details['admin_pass'];
          
      //     if(trim($_POST['change-password']) != ''){
      //         if(trim($_POST['change-password']) === trim($_POST['confirm-password'])){
      //             $password = md5(trim($_POST['change-password']));
      //         }
      //         else{
      //             echo '<script>alert("WRONG PASS")</script>';
      //         }
      //     }
      //     $imagename = $admin_details['admin_image'];

      //     if($imagename == 'admin.jpg'){
      //           if($_FILES['imageuploader']['size']>0){
      //               $filename = $_FILES['imageuploader']['name'];
      //               $file_array = explode('.',$filename);
      //               $ext = end($file_array);
      //               $imagename = $user_name . '.' . $ext;
      //     }
      // }
          
      //     if($_FILES['imageuploader']['size']>0){
      //         move_uploaded_file($_FILES['imageuploader']['tmp_name'], "images/user/" . $imagename);
      //     }
          
      //     $dhakaAdmin->update_info($user_name,$firstName,$lastName,$password,$imagename);
      // } 
    ?>

</body>

</html>