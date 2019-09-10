<?php
/**
 * Created by PhpStorm.
 * User: Fazlee Rabby
 * Date: 20-Jan-17
 * Time: 6:48 PM
 */
session_start();
require_once 'includes/connection.php';

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
else{
    header("Location: index.php");
}

if(isset($_COOKIE['item_on_cart'])){
    $item_list = json_decode($_COOKIE['item_on_cart'],true);
    if(empty($item_list)){
        $item_available=false;
        header("Location: index.php");
    }
    else{
        $item_available = true;
    }
}

else{
    $item_available=false;
    header("Location: index.php");
}

if(isset($_POST['user_number'])){
    $user_number = $_POST['user_number'];

    $mobile_query = "SELECT * FROM users WHERE user_mobile = '$user_number'";
    $mobile_result = $dbcon->query($mobile_query);
    if($mobile_result->rowCount()){
        echo "<script>alert('MOBILE NUMBER ALREADY EXISTS TO ANOTHER USER!!!')</script>";
        echo "<script>location.href='cart.php'</script>";
    }
    else{
        $created = date('Y-m-d H:i:s');
        $num_rand = sprintf("%06d", mt_rand(1, 999999));
        $orderID = "ORD" . date('dym',strtotime($created)) . $num_rand;
        $oauth_provider = "mobile";


        $ordDelivDate = "---";
        $ordstat = "Open";
        $ordpmntmthd = "Cash";
        $ordpmntstat = "Due";
        $ordcompln = "Nil";
        $user_query = "UPDATE users SET user_mobile=:mobile WHERE oauth_uid=:id";
        $statement = $dbcon->prepare($user_query);
        $statement->bindValue(":mobile",$user_number);
        $statement->bindValue(":id",$_SESSION['user_id']);
        $statement->execute();

        $query = "INSERT INTO customer_order_info( order_id, user_mobile, user_id, ord_del_date, ord_stat, pymt_mtod, pymt_stat, created) VALUES (:o_id,:u_mobile,:u_id,:ord_del,:ord_stat,:pay_method,:pay_stat,:created)";
        $statement = $dbcon->prepare($query);

        $statement->bindValue(":o_id",$orderID);
        $statement->bindValue(":u_mobile",$user_number);
        $statement->bindValue(":u_id",$user_id);
        $statement->bindValue(":ord_del",$ordDelivDate);
        $statement->bindValue(":ord_stat",$ordstat);
        $statement->bindValue(":pay_method",$ordpmntmthd);
        $statement->bindValue(":pay_stat",$ordpmntstat);
        $statement->bindValue(":created",$created);

        $statement->execute();

        foreach($item_list as $item){
            $get_item = "SELECT * FROM services where srv_sl=:id";
            $statement = $dbcon->prepare($get_item);
            $statement->bindValue(":id",$item['id']);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_OBJ);

            $service_id = $result->srv_sl;
            $service_name = $result->srvice;
            $service_cat = $result->srvCategory;
            $service_subcat = $result->srvSubCategory;
            $vendor = $result->vendor;
            $vendor_mobile = $result->vendor_mobile;
            $service_qty = $item['quantity'];
            $scheduleAddress = $item['address'];
            $scheduleDate = $item['date'];
            $scheduleTime = $item['time'];
            $userNote = $item['note'];
            $service_price = $result->srvPrice;
            $service_total = $service_qty*$service_price;
            $service_state = "Open";

            $sqlorderdetails = "INSERT INTO order_details( order_id, srv_sl, srv_name, sch_add, sch_date, Sch_time, note, srv_qty, srv_price, srv_total, srv_state,vendor_name,vendor_mbl) VALUES (:ord_id,:ser_id,:ser_name,:address,:schedule_date,:schedule_time, :note, :ser_quantity,:ser_price,:ser_total,:ser_status,:vendor,:vendor_mobile)";
            $statement = $dbcon->prepare($sqlorderdetails);
            $statement->bindValue(":ord_id",$orderID);
            $statement->bindValue(":ser_id",$service_id);
            $statement->bindValue(":ser_name",$service_name);
            $statement->bindValue(":address",$scheduleAddress);
            $statement->bindValue(":schedule_date",$scheduleDate);
            $statement->bindValue(":schedule_time",$scheduleTime);
            $statement->bindValue(":note",$userNote);
            $statement->bindValue(":ser_quantity",$service_qty);
            $statement->bindValue(":ser_price",$service_price);
            $statement->bindValue(":ser_total",$service_total);
            $statement->bindValue(":ser_status",$service_state);
            $statement->bindValue(":vendor",$vendor);
            $statement->bindValue(":vendor_mobile",$vendor_mobile);

            $statement->execute();
        }
        $_SESSION['order_created'] = "Your Order Has Been Placed!!";
        setcookie('item_on_cart',json_encode($item_list),time()-604800);
        header("Location: index.php");
    }
}