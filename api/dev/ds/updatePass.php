<?php
/**
 * Created by PhpStorm.
 * User: Fazlee Rabby
 * Date: 08-Jan-17
 * Time: 10:07 PM
 */

require_once 'admin-functions.php';

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['update_btn'])){
    $forgotAdmin = new DhakaAdmin();
    $pass = trim($_POST['new_pass']);
    $confirm_pass = trim($_POST['confirm_pass']);
    $user_name = trim($_POST['username']);
    $hash = md5(rand(1,10000));
    if($pass === $confirm_pass){
        $pass = md5($pass);
        $sql = "UPDATE admin SET admin_pass=:password,admin_hash=:hash WHERE user_name=:username";
        $statement = $forgotAdmin->dbcon->prepare($sql);
        $statement->bindValue(":password",$pass);
        $statement->bindValue(":username",$user_name);
        $statement->bindValue(":hash",$hash);
        $statement->execute();
        echo "<script>alert('Your Password Has Been Successfully Updated!!')</script>";
        $_SESSION['forget_msg'] = "Your Password Has Been Successfully Updated";
        header("Location: login.php");
    }
}