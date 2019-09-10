<?php
/**
 * Created by PhpStorm.
 * User: Fazlee Rabby
 * Date: 19-Jan-17
 * Time: 11:49 PM
 */
session_start();
require_once 'includes/connection.php';
require_once __DIR__ . "/includes/facebook/autoload.php";

$facebook = new \Facebook\Facebook([
    'app_id'    =>  '178768309269543',
    'app_secret'=>  '25abf16adcba209d385d41a5d348e2b8',
    'default_graph_version' => 'v2.8'
]);


$helper = $facebook->getRedirectLoginHelper();

if($access_token = $helper->getAccessToken()){
    $facebook->setDefaultAccessToken($access_token);
    $response = $facebook->get('/me?fields=id,first_name,last_name,email,link');
    $userNode = $response->getGraphUser();

    $result = $userNode->all();

    $query = "SELECT * FROM users WHERE oauth_uid=:uid";
    $statement = $dbcon->prepare($query);
    $statement->bindValue(":uid",$result['id']);
    $statement->execute();

    if($statement->rowCount() > 0){
        $_SESSION['user_id'] = $result['id'];
        header("Location: cart.php");
    }
    else{
        $first_name = $result['first_name'];
        $last_name = $result['last_name'];
        $id = $result['id'];
        $email = $result['email'];
        $picture = "https://graph.facebook.com/" . $result['id'] . "/picture?width=600&height=600";
        $link = $result['link'];

        $query = "INSERT INTO users(oauth_provider,oauth_uid,first_name,last_name,email,picture,link) VALUES (:provider,:uid,:firstname,:lastname,:email,:picture,:link)";
        $statement = $dbcon->prepare($query);
        $statement->bindValue(":uid",$id);
        $statement->bindValue(":provider","Facebook");
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