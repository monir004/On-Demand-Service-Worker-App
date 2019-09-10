<?php

require_once 'includes/pdo_connection.php';

class DhakaAdmin {

    /*
    private $db_user = 'ds2016_user_ad';
    private $db_pass = '@LexhlaEzPKF';
    private $db_name = 'ds2016_dhakasetup';
    private $db_host = '192.185.2.151';
    */

    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "ds19";
    private $db_host = "localhost";

    public  $admin_id;
    public  $database_manager;
    public  $dbcon;

    public function __construct() {
        $this->database_manager = new connect();
        $this->dbcon = $this->database_manager->connection($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
    }

    public function admin_login($username, $password) {
        $userchk = "SELECT * FROM `admin` WHERE `username` = '$username' AND `password` = '$password'";
        $userchkdata = $this->dbcon->query($userchk);
        $row = $userchkdata->fetch(PDO::FETCH_ASSOC);

        $user_Name = $row['username'];
        $user_Pass = $row['password'];

        if ($user_Name != "" && $user_Pass != "") {
            $_SESSION['login'] = "True";
            $_SESSION['user_name'] = $user_Name;

            header('Location: dashboard.php');
        } else {
            $error = "Wrong Username or Password";
            echo ("<script>alert(\"$error\")</script>");
            echo("<script>location.href='login.php'</script>");
        }
    }

    public function create_admin($user_name, $first_name, $last_name, $admin_email, $admin_pass, $admin_created) {
        $sqlLogin = "INSERT INTO admin(user_name, first_name, last_name, admin_email, admin_pass, admin_image, created) VALUES ('$user_name', '$first_name', '$last_name', '$admin_email', '$admin_pass', 'admin.jpg', '$admin_created')";
        if ($this->dbcon->query($sqlLogin)) {
            echo '<script language="javascript">';
            echo 'alert("Thanks!  New ADMINISTRATOR created sucessfully.");';
            echo 'window.location.href = "create-admin.php";';
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Sorry! New ADMINISTRATOR creation failed. Please try again later");';
            echo 'window.location.href = "create-admin.php";';
            echo '</script>';
        }
    }
    
    public function admin_info($adminname) {
        $admincheck = "SELECT * FROM admin WHERE `username` = '$adminname' ";
        $admindata = $this->dbcon->query($admincheck);
        $row = $admindata->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
    
    public function update_info($adminname,$firstname, $lastname, $password, $image){
        $query = "UPDATE admin SET first_name='$firstname',last_name='$lastname', admin_pass='$password', admin_image='$image' WHERE user_name='$adminname'";
        $this->dbcon->query($query);
    }

}

?>