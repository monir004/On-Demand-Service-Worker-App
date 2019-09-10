<?php
	include "db2.php";
	$uid = $_POST['uid'];
	$firstname = $_POST['firstname'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$action = $_POST['action'];

	if ($action == "0") {
		$sql = "INSERT INTO 
		users(oauth_provider,oauth_uid,first_name,last_name,email,user_mobile,address,created) 
		VALUES('kit','$uid','$firstname','','$email','$phone','$address',NOW())";
	}
	else if($action == "1") {
		$sql = "UPDATE users SET 
		first_name = '$firstname', email = '$email', address = '$address' , modified=NOW() 
		WHERE oauth_uid = '$uid' AND user_mobile='$phone'";
	}

	if (mysqli_query($conn, $sql)) {
	    $last_id = mysqli_insert_id($conn);
	    echo "New record created successfully. Action is: " . $action;
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

	mysqli_close($conn);

	/***
		INSERT INTO users(oauth_provider,oauth_uid,first_name,last_name,email,user_mobile,address,created,modified) VALUES('facebook','12345','first_last','','email@gmail.com','01521220462','32/2,badda nagar',NOW(),NOW());
	***/
?>

