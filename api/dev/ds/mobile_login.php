<?php
require_once 'includes/connection.php';

if (isset($_POST["code"])) {
    session_start();
    $_SESSION["code"] = $_POST["code"];
    $_SESSION["csrf_nonce"] = $_POST["csrf_nonce"];
    $ch = curl_init();
    // Set url elements
    $fb_app_id = '771765302988032';
    $ak_secret = 'a2bd31f33b147fc1ee468f22c84dd6be';
    $token = 'AA|' . $fb_app_id . '|' . $ak_secret;
    // Get access token
    $url = 'https://graph.accountkit.com/v1.0/access_token?grant_type=authorization_code&code=' . $_POST["code"] . '&access_token=' . $token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    $info = json_decode($result);
    // Get account information
    $url = 'https://graph.accountkit.com/v1.0/me/?access_token=' . $info->access_token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($result);
    $national_number = "0" . $result->phone->national_number;
    $mobile_number = "SELECT * FROM users WHERE user_mobile = '$national_number'";
    $mobile_available = $dbcon->query($mobile_number);
    if($mobile_available->rowCount()){
        $mobile_available = $mobile_available->fetch(PDO::FETCH_OBJ);
        $_SESSION['user_id'] = $mobile_available->oauth_uid;
        header("Location: cart.php");
    }
    else{
        echo "<script>alert('THIS MOBILE NUMBER IS NOT REGISTERED !!!')</script>";
        echo "<script>location.href='index.php'</script>";
    }
}
?>

<head>
    <title>Account Kit PHP App</title>
</head>
<body>
<?php

?>
</body>
