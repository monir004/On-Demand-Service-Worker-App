<?php
session_start();
require_once 'includes/connection.php';

    $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
     if($loggedin != 'True'){
        echo "<script>window.location.href = \"login.php\"</script>";
    }
    else{
        $user_name = $_SESSION['user_name'];
    }

if(isset($_POST['addadEntry'])){
    $adName = $_POST['adName'];
    $URL = $_POST['url'];
    $adImage = $_FILES['adImage'];
    $ext = explode(".",$adImage['name']);
    $ext = end($ext);
    $imageName = time() . "." . $ext;

    move_uploaded_file($adImage['tmp_name'], 'images/ad/'.$imageName);

    $query = "INSERT INTO ad(ad_name,ad_image,link) VALUES (:adName,:adImage,:link)";
    $query = $dbcon->prepare($query);
    $query->bindValue(":adName",$adName);
    $query->bindValue(":adImage",$imageName);
    $query->bindValue(":link",$URL);
    $query->execute();
    header("Location: viewad.php");
}

if(isset($_GET['deletedId'])){
    $query = "DELETE FROM ad WHERE id=:id";
    $query = $dbcon->prepare($query);
    $query->bindValue(":id",$_GET['deletedId']);
    $query->execute();
    header("Location: viewad.php");
}