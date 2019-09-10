<?php
/**
 * Created by PhpStorm.
 * User: Fazlee Rabby
 * Date: 19-Jan-17
 * Time: 8:53 PM
 */
session_start();
require_once 'includes/connection.php';
require_once __DIR__ . "/includes/google/autoload.php";

$google = new Google_Client();
$google->setClientId('855485437907-ltrafs43v64eea4h0k60enigpkr7aglc.apps.googleusercontent.com');
$google->setClientSecret('vHOsJWcJPjcQs1Z9Z08jfquh');
$google->setRedirectUri('http://dhakasetup.com/social_login.php');
$google->setScopes('email');
if(isset($_GET['code'])){
    try{
        $google->authenticate($_GET['code']);
        $google_token = $google->getAccessToken();
    }
    catch (Google_Auth_Exception $e){
        header('Location: index.php');
    }
    $google->setAccessToken($google_token);
    $gmail = new Google_Service_Oauth2($google);
    try{
        $results = $gmail->userinfo->get();
    }
    catch (Google_Exception $e){
        echo $e->getMessage();
    }
    //print_r($results);
//    echo $results['givenName']."</br>";
//    echo $results['familyName']."</br>";
//    echo $results['id'] . "</br>";
//    echo "<img src='". $results['picture'] . "' /></br>";
    $query = "SELECT * FROM users WHERE oauth_uid=:uid";
    $statement = $dbcon->prepare($query);
    $statement->bindValue(":uid",$results['id']);
    $statement->execute();

    if($statement->rowCount() > 0){
        $_SESSION['user_id'] = $results['id'];
        header("Location: cart.php");
    }
    else{
        $first_name = $results['givenName'];
        $last_name = $results['familyName'];
        $id = $results['id'];
        $email = $results['email'];
        $picture = $results['picture'];
        $link = $results['link'];

        $query = "INSERT INTO users(oauth_provider,oauth_uid,first_name,last_name,email,picture,link) VALUES (:provider,:uid,:firstname,:lastname,:email,:picture,:link)";
        $statement = $dbcon->prepare($query);
        $statement->bindValue(":uid",$id);
        $statement->bindValue(":provider","Google");
        $statement->bindValue(":firstname",$first_name);
        $statement->bindValue(":lastname",$last_name);
        $statement->bindValue(":email",$email);
        $statement->bindValue(":picture",$picture);
        $statement->bindValue(":link",$link);

        $statement->execute();
        $_SESSION['user_id'] = $id;
        header("Location: cart.php");
    }
}
else{
    header("Location: index.php");
}