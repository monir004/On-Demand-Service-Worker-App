<?php
require_once "main-header-dhaka-setup.php";
require_once "includes/connection.php";

$_SESSION['user_id'] = 110464512344952769414;



$user_query = "SELECT first_name,last_name,email,user_mobile FROM users WHERE oauth_uid= '$user_id'";
$user_query = $dbcon->query($user_query);
$user_data = $user_query->fetch(PDO::FETCH_OBJ);
header("Location: index.php");

?>