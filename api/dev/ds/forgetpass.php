<?php
    session_start();
    require_once 'admin-functions.php';

    $everything = true;
    $forgotAdmin = new DhakaAdmin();

    if (isset($_GET['authID']) && isset($_GET['user'])) {
        if($_GET['authID'] != '' && $_GET['user'] !=''){
            $hash = $_GET['authID'];
            $user_name = $_GET['user'];
            $sql = "SELECT * FROM admin WHERE user_name=:user AND admin_hash=:hash";
            $query = $forgotAdmin->dbcon->prepare($sql);
            $query->bindValue(":user",$user_name);
            $query->bindValue(":hash",$hash);
            $query->execute();
            if($query->rowCount()>0){
                $everything = true;
            }
            else{
                $everything= false;
            }
        }
        else{
            $everything=false;
        }
    }
    else{
        header("Location: login.php");
    }

    if(!$everything){
        header("Location: login.php");
    }
?>


<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Login - DhakaSetup</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="css/dashboard.css">
    </head>

    <body id="login-body">
        <div class="container">
            <div class="login-main">
                <img src="images/Logo-DhakaSetup.png" class="img-responsive" alt="">
                <h1>Password Reset</h1>
                <div class="login-box">
                    <form class="login" method="POST" action="updatePass.php">
                        <div class="login-input">
                            <input type="password" placeholder="New Password" name="new_pass" required />
                            <span><i class="fa fa-lock"></i></span>
                        </div>

                        <div class="login-input">
                            <input type="password" placeholder="Confirm Password" name="confirm_pass" required />
                            <span><i class="fa fa-lock"></i></span>
                        </div>

                        <input type="hidden" value="<?php echo $user_name?>" name="username" />
                        <button class="btn btn-default" name="update_btn">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </body>

</html>