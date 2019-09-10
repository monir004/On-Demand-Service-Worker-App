<?php

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
        case 'GET':
            getOperation();
            break;
        default:
            print('{"result": "Requested http method not supported here."}');
}

function getOperation(){
	include "../db2.php";
	if (isset($_GET['uid'])) {
		$sql = "select * from app_order where oauth_uid=".$_GET['uid'];
	    $result = mysqli_query($conn, $sql);
	    if (mysqli_num_rows($result) > 0) {
	    	$user = array();
	    	while($r = mysqli_fetch_assoc($result)) {
	        	$sql = "select * from app_order_details where order_sl=".$r['order_sl'];
	        	$result2 = mysqli_query($conn,$sql);
	        	$items = array();
	        	while($r2 = mysqli_fetch_assoc($result2)){
        			array_push($items,$r2);
	        	}
	        	$r['items'] = $items;

	        	array_push($user,$r);
	      	}
	      	$data['data'] = $user;
	      	$data['found'] = true;
		}
		else {
			$data = array('found'=>false);
		}
		echo json_encode($data);
	}
}
?>