<?php

/*
*	upsert token if status is online (login), 
*	update token to null if status is offline (logout)
*/

include "db2.php";
$phone = $_POST['phone'];
$token = $_POST['token'];
$status = $_POST['status']; 

if ($status == 'online') {
	$sql = "select * from fcm_token where phone='".$phone."'";
	$result = mysqli_query($conn,$sql);
	if (mysqli_num_rows($result) == 0){
		$sql = "insert into fcm_token values(null,'".$phone."','".$token."','online',now())";
		mysqli_query($conn,$sql);
	}
	else {
		$sql = "update fcm_token set token='".$token."', status='online', updated_at=now() where phone='".$phone."'";
		mysqli_query($conn,$sql);
	}
}
elseif ($status == 'offline') {
	$sql = "update fcm_token set token=null, status='offline', updated_at=now() where phone='".$phone."'";
	echo $sql;
	mysqli_query($conn,$sql);
}

?>