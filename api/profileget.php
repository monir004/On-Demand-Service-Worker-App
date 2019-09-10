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
	include "db2.php";
	if (isset($_GET['uid'])) {
		$sql = "SELECT * FROM users where oauth_uid=".$_GET['uid'];
	    $result = mysqli_query($conn, $sql);
	    if (mysqli_num_rows($result) > 0) {
	    	$user = array();
	    	while($r = mysqli_fetch_assoc($result)) {
	        	$user = $r;
	        	$user['found'] = true;
	      	}
		}
		else {
			$user = array('found'=>false);
		}
		echo json_encode($user);
	}
}
?>