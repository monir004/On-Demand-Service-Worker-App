<?php
require_once 'database_config.php'; 
require_once 'pdo_connection.php'; 
$db_user = $database_user;
$db_pass = $database_pass;
$db_name = $database_name;
$db_host = $database_host;
$dbcon = $connection_object->connection($db_host, $db_user, $db_pass, $db_name);
?>