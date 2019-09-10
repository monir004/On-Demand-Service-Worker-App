<?php

/*
*	upsert token if status is online, 
*	update to null if status is offline
*/

include "db2.php";
$phone = $_POST['phone'];
$title = $_POST['title'];
$message = $_POST['message'];
$action = $_POST['action'];


$user_status = "offline";
$user_token = null;

$sql = "select * from fcm_token where phone='".$phone."'";
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result) > 0){
	$row = mysqli_fetch_assoc($result);
	$user_status = $row["status"];
	$user_token = $row["token"];
}


//echo $user_status."</br>".$user_token;
if($action == "clear"){
	if ($user_status == "online")
		clear_pending();
	die();
}

if ($user_status == "offline") {
	$status = "pending";
	echo save_notification($phone,$title,$message,"pending");
	die();
}else{
	$nid = save_notification($phone,$title,$message,"sent");
	send_notification($nid,$user_token,$title,$message);
	clear_pending();
}

function clear_pending(){
	include "db2.php";
	global $phone,$user_token;
	$sql = "select * from notification where phone='".$phone."' and status='pending'";
	echo $sql.'<br>';
	$pendings = mysqli_query($conn,$sql);
	$pending_arr = array();
	$i=0;
	if (mysqli_num_rows($pendings) > 0){
		while ($pending = mysqli_fetch_assoc($pendings)){
			$pending_arr[$i++] = $pending;
		}
		mysqli_close($conn);
	}
	while($i--){
		$nid = $pending_arr[$i]["id"];
		send_notification($nid,$user_token,$pending_arr[$i]["title"],$pending_arr[$i]["message"]);
		update_notification($nid,"sent");
	}
}

function save_notification($notify_phone,$notify_title,$notify_message,$notify_status){
	include "db2.php";
	$sql = "insert into notification values(null, '".$notify_phone."', '".$notify_title."','".$notify_message."','".$notify_status."',now())";
	echo $sql."<br>";
	mysqli_query($conn,$sql);
	return mysqli_insert_id($conn);
}

function update_notification($nid,$nstatus){
	include "db2.php";
	$sql = "update notification set status='".$nstatus."' where id=".$nid;
	echo $sql."<br>";
	mysqli_query($conn,$sql);
}

function send_notification($notify_id,$notify_token,$notify_title, $notify_message){
	echo $notify_id." notify_token ".$notify_title.$notify_message."<br>";
	$url = "https://fcm.googleapis.com/fcm/send";
	$server_key = "AIzaSyCm3iEMsullb8F9G_2ORQ4ZbyFMLM5vH6Q";
	$headers = array(
				'Content-Type:application/json',
				'Authorization:key='.$server_key
			);
	$fields = array(
				'to' => $notify_token,
				'data' => array('title' => $notify_title, 
										'body' => $notify_message, 
										'sound' => 'default',
										'color' => '#00aff0'
									)
			);
	$payload = json_encode($fields);

	$curl_session = curl_init();
	curl_setopt($curl_session, CURLOPT_URL, $url);
	curl_setopt($curl_session, CURLOPT_POST, true);
	curl_setopt($curl_session, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl_session, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_session, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($curl_session, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_session, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($curl_session, CURLOPT_POSTFIELDS, $payload );

	$result = curl_exec($curl_session);
	echo $result;
}


?>