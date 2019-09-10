<?php
header('Content-Type: application/json');
include "pdo_connection.php";
$phone = $_POST['phone'];



$query = "select * from notification where phone=? order by created_at desc";
$stm = $dbcon->prepare($query);
$stm->execute([$phone]);
$data = $stm->fetchAll(PDO::FETCH_ASSOC);
$arr = array();
$arr['data'] = $data;
echo json_encode($arr);



?>