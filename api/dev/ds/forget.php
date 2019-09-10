<?php
/**
 * Created by PhpStorm.
 * User: Fazlee Rabby
 * Date: 08-Jan-17
 * Time: 5:24 PM
 */
session_start();
require_once 'admin-functions.php';
require_once 'includes/PHPMailer/PHPMailerAutoload.php';
?>

<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['forget_button'])) {

    $adminMail = $_POST['admin_mail'];
    $query = "SELECT * FROM admin WHERE admin_email=:mail";
    $admin = new DhakaAdmin();
    $statement = $admin->dbcon->prepare($query);
    $statement->bindValue(":mail",$adminMail);
    $statement->execute();
    if($statement->rowCount() > 0){
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $username = $result['user_name'];
        $hash = md5(rand(0,100000));
        $sql = "UPDATE admin SET admin_hash=:code WHERE user_name=:adminname";
        $query= $admin->dbcon->prepare($sql);
        $query->bindValue(":code",$hash);
        $query->bindValue(":adminname",$username);
        $query->execute();
        $url = "http://localhost/dhakasetup/forgetpass.php?authID=".$hash."&user=".$username;
        
        $mailer = new PHPMailer();
        $mailer->isSMTP();
        $mailer->SMTPAuth = true;

        $mailer->Host = 'mini.websitewelcome.com';
        $mailer->Username = 'developer@dhakasetup.com';
        $mailer->Password = '123456';
        $mailer->SMTPSecure = 'ssl';
        $mailer->Port = 465;

        $mailer->FromName= 'admin@dhakasetup.com';
        $mailer->AddAddress($adminMail);

        $mailer->Subject = 'Change Password for Dhakasetup.com';
        $mailer->Body = $url;
        if($mailer->send()){
            $_SESSION['forget_msg'] = "A Confirmation Mail has been sent to your email address.";
            header("Location: login.php");
        }
        else{
            echo "<script>alert('There was a problem sending the mail!! Please try again after sometime.')</script>";
        }
    }
    else{
        echo "<script>alert('USER DOES NOT EXIST!!')</script>";
    }
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
            <form class="login" method="POST" action="forget.php">
                <div class="login-input">
                    <input type="text" placeholder="Email" name="admin_mail" required />
                    <span><i class="fa fa-user"></i></span>
                </div>

                <button class="btn btn-default" name="forget_button">SUBMIT</button>
            </form>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/script.js" type="text/javascript"></script>
</body>

</html>
