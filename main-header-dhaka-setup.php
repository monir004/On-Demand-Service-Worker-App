<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$_SESSION['come_back'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

require_once 'includes/connection.php';
require_once __DIR__ . "/includes/facebook/autoload.php";
require_once __DIR__ . "/includes/google/autoload.php";
/*
$facebook = new \Facebook\Facebook([
    'app_id'    =>  '178768309269543',
    'app_secret'=>  '25abf16adcba209d385d41a5d348e2b8',
    'default_graph_version' => 'v2.8'
]);

$redirect = "http://dhakasetup.com/facebook_login.php";

$helper = $facebook->getRedirectLoginHelper();

$access_token = $helper->getAccessToken();

if(!isset($access_token)){
    $permission = ['email'];
    $loginUrl = $helper->getLoginUrl($redirect,$permission);
}
*/
$google = new Google_Client();
$google->setClientId('855485437907-ltrafs43v64eea4h0k60enigpkr7aglc.apps.googleusercontent.com');
$google->setClientSecret('vHOsJWcJPjcQs1Z9Z08jfquh');
$google->setRedirectUri('http://dhakasetup.com/social_login.php');
$google->setScopes('email');

if(!isset($_GET['code'])){
    $authURL = $google->createAuthUrl();
}


if(isset($_COOKIE['item_on_cart'])){
    $item_list = json_decode($_COOKIE['item_on_cart'],true);
    if(empty($item_list)){
        $item_available=false;
    }
    else{
        $item_available = true;
    }
}

else{
    $item_available=false;
}

if(isset($_SESSION['user_id'])){
    $user_id =  $_SESSION['user_id'];
    $user_loggedin = true;
}
else{
    $user_loggedin = false;
}

if(isset($_SESSION['order_created'])){
    echo '<script>alert("'.$_SESSION['order_created'].'")</script>';
    unset($_SESSION['order_created']);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:title" content="DhakaSetup - Service Provider Company" />
    <meta property="og:image" content="http://dhakasetup.com/images/logo.png" />
    <meta property="og:image:type" content="image/png" /> 
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <!-- Title goes here -->
    <title>DhakaSetup | Home</title>
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,600,700|Open+Sans:400,600,700|Raleway:400,500,600,700" rel="stylesheet">
    <!-- favicon -->
    <link rel="shortcut icon" href="images/logo.png">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datepicker.css">
    <!-- fontawesome css -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- owl carousel css -->
    <link rel="stylesheet" type="text/css" href="owl-carousel/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="owl-carousel/owl.theme.css">
    <link rel="stylesheet" type="text/css" href="owl-carousel/owl.transitions.css">
    <!-- main stylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body data-spy="scroll" data-target=".mega-menu-wrappper" data-offset="50">
<!-- Site Home Section -->
<header id="header">
    <!-- main navbar-->
    <div class="menu_section">
        <div class="container">
            <div class="row">
                <nav class="navbar navbar-default" id="main-nav">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#dhakasetup" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="index.php" class="brand-image"><img src="images/logo/logo.png" alt="" class="img-responsive"></a>
                    </div>
                    <div class="collapse navbar-collapse" id="dhakasetup">
                        <ul class="nav navbar-nav navbar-right">
                            <?php if(!$user_loggedin) : ?>
                                <li><a href="#" data-toggle="modal" data-target=".login">login</a></li>
                            <?php endif;?>
                            <?php if($user_loggedin) : ?>
                                <li><a href="order_history.php">Order History</a></li>
                                <li><a href="logout.php">logout</a></li>
                            <?php endif;?>
                            <li class="hidden-xs">
                                <!-- cart box -->
                                <div class="aa-cartbox">
                                    <a class="aa-cart-link" href="#">
                                        <span class="fa fa-shopping-basket"></span>
                                        <span class="aa-cart-notify"><?php if($item_available){echo count($item_list);} else{echo 0;} ?></span>
                                    </a>
                                    <div class="aa-cartbox-summary">
                                        <ul>
                                            <?php if($item_available){ ?>
                                            <?php foreach ($item_list as $item){
                                                $sql = "SELECT srv_sl,srvice,srvPrice,srvImage FROM services WHERE srv_sl=:sid";
                                                $query = $dbcon->prepare($sql);
                                                $query->bindValue(":sid", $item['id']);
                                                $query->execute();
                                                while($result = $query->fetch(PDO::FETCH_OBJ)) : ?>
                                                    <li class="cart-item" id="<?php echo $result->srv_sl?>">
                                                        <a class="aa-cartbox-img" href="#">
                                                            <img src="images/services/<?php echo $result->srvImage ?>" alt=""/>
                                                        </a>
                                                        <div class="aa-cartbox-info">
                                                            <h4><a href="#"><?php echo $result->srvice ?></a></h4>
                                                            <p>
                                                                <?php echo $item['quantity'] ?> x
                                                                <?php echo $result->srvPrice ?>
                                                            </p>
                                                        </div>
                                                        <a class="aa-remove-product" href="#" ref="<?php echo $result->srv_sl?>"><span class="fa fa-times"></span></a>
                                                    </li>
                                                <?php endwhile;
                                            }
                                            ?>
                                        </ul>
                                        <a class="aa-order-button aa-primary-btn <?php if(!$user_loggedin){ echo "loginmodal";}?>" href=<?php echo $user_loggedin==true ? "cart.php" : "#" ?>>Place Order Now</a>
                                        <?php }
                                        else{
                                        ?>
                        </ul>
                        <h4 id="empty">EMPTY CART</h4>
                        <a class="aa-order-button aa-primary-btn <?php if(!$user_loggedin){ echo "loginmodal";}?>" id="place_button" href=<?php echo $user_loggedin==true ? "cart.php" : "#" ?> style="display:none">Place Order Now</a>
                        <?php } ?>


                    </div>
                    </li>
                    </ul>
            </div>
        </div>
        </nav>
    </div>
    </div>
    </div>
    <!-- /menu section -->
    <!-- top search bar -->
    <div id="top-search-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-6">
                    <span class="search-heading">looking for : </span>
                            <span class="search-ticker">

                    <span class="search-ticker-words search-ticker-words-1">
                        <span>Electrician</span>
                            <span>Plumber</span>
                            <span>Pest Control</span>
                            <span>Interior Designer</span>
                            <span>Carpenter</span>
                            <span>Painter</span>
                            </span>
                            </span>
                </div>
                <div class="col-md-7 col-sm-6 col-xs-12">
                    <form class="search-form" method="post" action="search.php">
                        <div class="col-md-9 col-sm-7">
                            <div class="form-group">
                                <input type="text" class="form-control" name="search" placeholder="E.g. Electrician, Plumber">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-5">
                            <button type="submit" name="search_button" class="btn btn-default">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- / Site Home Section -->
<!-- login modal -->
<?php if(!$user_loggedin) : ?>
    <div id="login-modal">
        <div class="modal fade login" tabindex="-1" role="dialog" aria-labelledby="loginLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="loginLabel"><span class="fa fa-user"></span> user login</h4>
                    </div>
                    <div class="modal-body">
                        <p>login with</p>
                        <ul class="list-unstyled list-inline">
                            <li><a href="<?php echo $loginUrl?>"><span class="fa fa-facebook"></span> facebook</a></li>
                            <li><a href="<?php echo $authURL ?>"><span class="fa fa-google"></span> google</a></li>
                        </ul>
                        <span class="text-center">or</span>
                        <h5>Login Using Mobile (For Existing Users)</h5>
                        <div class="modal-form">
                            <div class="login-button">
                                <button class="btn" onclick="phone_btn_onclick();">Login</button>
                            </div>
                            <form action="mobile_login.php" method="post" id="mobile_login">
                                <input type="hidden" name="code" id="code">
                                <input type="hidden" name="csrf_nonce" id="csrf_nonce">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<!-- / login modal -->
<!-- mega menu section -->
<div class="mega-menu-wrappper" data-spy="affix" data-offset-top="197">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 hidden-xs">
                <ul class="list-unstyled list-inline" id="mega-menu">
                    <li><a href="index.php">All Services</a></li>
                    <li class="dropdown mega-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Domestic <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                        <ul class="dropdown-menu mega-dropdown-menu row">
                            <?php

                            $query = "SELECT * from category WHERE domestic=1 ORDER BY cat_id DESC LIMIT 4";
                            $query = $dbcon->prepare($query);
                            $query->execute();
                            while($catdata = $query->fetch(PDO::FETCH_OBJ)) :
                            ?>
                            <li class="col-sm-3">
                                <ul>
                                    <li class="dropdown-header"><a href="single-cat.php?id=<?php echo $catdata->cat_id?>"><?php echo $catdata->cat_name?></a></li>
                                    <?php
                                    $subcategories = "SELECT * FROM subcategory WHERE category='$catdata->cat_id' LIMIT 5";
                                    $subcategories = $dbcon->prepare($subcategories);
                                    $subcategories->execute();
                                    while($subcategory_data = $subcategories->fetch(PDO::FETCH_OBJ)) :
                                    ?>
                                    <li><a class="subcategory" href="view-all.php?subcat=<?php echo $subcategory_data->subcat_id ?>"><?php echo $subcategory_data->subcat_name ?></a></li>
                                    <?php endwhile;?>
                                    <li class="dropdown-header"><a href="single-cat.php?id=<?php echo $catdata->cat_id?>">See All</a></li>
                                </ul>
                            </li>
                            <?php endwhile;?>
                        </ul>
                    </li>
                    <li class="dropdown mega-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">commercial <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                        <ul class="dropdown-menu mega-dropdown-menu row">
                            <?php

                            $query = "SELECT * from category WHERE commercial=1 ORDER BY cat_id DESC LIMIT 4";
                            $query = $dbcon->prepare($query);
                            $query->execute();
                            while($catdata = $query->fetch(PDO::FETCH_OBJ)) :
                                ?>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header"><a href="single-cat.php?id=<?php echo $catdata->cat_id?>"><?php echo $catdata->cat_name?></a></li>
                                        <?php
                                        $subcategories = "SELECT * FROM subcategory WHERE category='$catdata->cat_id' LIMIT 5";
                                        $subcategories = $dbcon->prepare($subcategories);
                                        $subcategories->execute();
                                        while($subcategory_data = $subcategories->fetch(PDO::FETCH_OBJ)) :
                                            ?>
                                            <li><a class="subcategory" href="view-all.php?subcat=<?php echo $subcategory_data->subcat_id ?>"><?php echo $subcategory_data->subcat_name ?></a></li>
                                        <?php endwhile;?>
                                    <li class="dropdown-header"><a href="single-cat.php?id=<?php echo $catdata->cat_id?>">See All</a></li>
                                    </ul>
                                </li>
                            <?php endwhile;?>
                        </ul>
                    </li>
                    <li class="dropdown mega-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">industrial <span class="glyphicon glyphicon-chevron-down pull-right"></span></a>
                        <ul class="dropdown-menu mega-dropdown-menu row">
                            <?php

                            $query = "SELECT * from category WHERE industrial=1 ORDER BY cat_id DESC LIMIT 4";
                            $query = $dbcon->prepare($query);
                            $query->execute();
                            while($catdata = $query->fetch(PDO::FETCH_OBJ)) :
                                ?>
                                <li class="col-sm-3">
                                    <ul>
                                        <li class="dropdown-header"><a href="single-cat.php?id=<?php echo $catdata->cat_id?>"><?php echo $catdata->cat_name?></a></li>
                                        <?php
                                        $subcategories = "SELECT * FROM subcategory WHERE category='$catdata->cat_id' LIMIT 5";
                                        $subcategories = $dbcon->prepare($subcategories);
                                        $subcategories->execute();
                                        while($subcategory_data = $subcategories->fetch(PDO::FETCH_OBJ)) :
                                            ?>
                                            <li><a class="subcategory" href="view-all.php?subcat=<?php echo $subcategory_data->subcat_id ?>"><?php echo $subcategory_data->subcat_name ?></a></li>
                                        <?php endwhile;?>
                                        <li class="dropdown-header"><a href="single-cat.php?id=<?php echo $catdata->cat_id?>">See All</a></li>
                                    </ul>
                                </li>
                            <?php endwhile;?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
		<!-- versiontag -->
                <div class="version-tag">
                    <div class="tag-image"><img src="images/beta.png" alt="" class="img-responsive"></div>
                </div>