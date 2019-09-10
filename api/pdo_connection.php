<?php
$db_user = "ds2016_user_ad";
$db_pass = "@LexhlaEzPKF";
$db_name = "ds2016_18";
$db_host = "192.185.2.151";
class connect
{
    var $host;
    var $user;
    var $pass;
    var $db;
    public $connect;

    public function connection($hostname, $username, $passwoard, $database)
    {
        $this->host = $hostname;
        $this->user = $username;
        $this->pass = $passwoard;
        $this->db = $database;
        $connect = new PDO("mysql:host=$this->host;dbname=$this->db", $this->user, $this->pass, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ));
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connect->setAttribute(PDO::ATTR_PERSISTENT, true);

        return $connect;
    }
}

$connection_object=new connect();
$dbcon = $connection_object->connection($db_host, $db_user, $db_pass, $db_name);
?>