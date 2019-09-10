<?php
/*
$servername = "192.185.2.151";
$username = "ds2016_user_ad";
$password = "@LexhlaEzPKF";
$dbname = "ds2016_dhakasetup";
*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ds2016_dhakasetup";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn,"utf8");

//Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 
// echo "Connected successfully";


?>