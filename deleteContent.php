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
    
    if(isset($_GET['catId'])){
    	$query = "DELETE FROM category WHERE id=:category_id";
    	$query = $dbcon->prepare($query);
    	$query->bindValue(":category_id",$_GET['catId']);
    	$query->execute();
    	echo "<script>window.location.href = \"viewCategory.php\"</script>";
    }
    
    elseif(isset($_GET['subcatId'])){
    	$query = "DELETE FROM subcategory WHERE id=:subcategory_id";
    	$query = $dbcon->prepare($query);
    	$query->bindValue(":subcategory_id",$_GET['subcatId']);
    	$query->execute();
    	echo "<script>window.location.href = \"viewSubcategory.php\"</script>";
    }
    
    if(isset($_GET['serviceId'])){
    	$query = "DELETE FROM `service` WHERE id=:service_id";
    	$query = $dbcon->prepare($query);
    	$query->bindValue(":service_id",$_GET['serviceId']);
    	$query->execute();
    	echo "<script>window.location.href = \"ViewService.php\"</script>";
    }

    if(isset($_GET['trendId'])){
    	$query = "DELETE FROM `trending` WHERE id=:trendId";
    	$query = $dbcon->prepare($query);
    	$query->bindValue(":trendId",$_GET['trendId']);
    	$query->execute();
    	echo "<script>window.location.href = \"ViewTrend.php\"</script>";
    }

?>