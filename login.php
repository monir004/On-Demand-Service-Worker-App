<?php
    session_start();
    require_once 'admin-functions.php';

    if (isset($_POST['admin_login'])) {

        $username = $_POST['admin_name'];
        $userpassword = md5($_POST['admin_pass']);

        $admin = new DhakaAdmin();
        $admin->admin_login($username,$userpassword);
    }

    if(isset($_SESSION['forget_msg'])){
        $msg= $_SESSION['forget_msg'];
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
                <h1>DhakaSetup Login</h1>
                <div class="login-box">
                    <?php if(isset($_SESSION['forget_msg'])) {?>
                        <div class="alert alert-info" role="alert"><?php echo $msg?></div> <?php } unset($_SESSION['forget_msg']);?>
                    <form class="login" method="POST" action="">
                        <div class="login-input">
                            <input type="text" placeholder="Username" name="admin_name" required />
                            <span><i class="fa fa-user"></i></span>
                        </div>

                        <div class="login-input">
                            <input type="password" placeholder="Password" name="admin_pass" required />
                            <span><i class="fa fa-lock"></i></span>
                        </div>

                        <button class="btn btn-default" name="admin_login">LOGIN</button>
                    </form>
                </div>
                <div class="sign-box">
                    <a href="forget.php">Forgot Password?</a>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/script.js" type="text/javascript"></script>
    </body>

</html>