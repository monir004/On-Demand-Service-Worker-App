<?php
/*
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
    $srvID=$_GET['id'];
} else{
    // $user = "";
    echo '<script language="javascript">';
    echo 'window.location.href = "dashboard.php";';
    echo '</script>';
    
}
*/
require_once '../../includes/connection.php';
// require_once 'includes/servicesInDetails.php';

$data = $_POST['data'];
echo $_POST['id'].'?';

for ($i=0; $i < count($data); $i++) { 
    $item = $data[$i];

    $query = "DELETE FROM `variant_price` WHERE variant_a_id=:vara AND variant_b_id=:varb";
    $query = $dbcon->prepare($query);
    $query->bindValue(":vara",$item['vara']);
    $query->bindValue(":varb",$item['varb']);
    $query->execute();

    $sql = "INSERT INTO variant_price(variant_a_id,variant_b_id,price) VALUES(:vara,:varb,:price)";
    $statement = $dbcon->prepare($sql);
    $statement->bindValue(':vara',$item['vara']);
    $statement->bindValue(':varb',$item['varb']);
    $statement->bindValue(':price',$item['price']);
    $statement->execute();
}
?>
