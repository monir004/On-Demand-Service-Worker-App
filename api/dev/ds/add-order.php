<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $created = date('Y-m-d H:i:s');
    $num_rand = sprintf("%06d", mt_rand(1, 999999));
    $orderID = "ORD" . date('dym',strtotime($created)) . $num_rand;
    $createdBy = "Admin";
    $oauth_provider = "mobile";
    // $num_rand = sprintf("%06d", mt_rand(1, 999999));
    // echo "$num_rand";
    include 'includes/connection.php';

$sqlUserStatus=0;
$sqlOrdDetailsStatus=0;

    if (isset($_POST["user-data"]) && isset($_POST["order-data"])) {
        $orders_info = json_decode($_POST["order-data"], true);
        $user_info = $_POST["user-data"];

        $userfname = $user_info["firstname"];
        $userlname = $user_info["lastname"];
        $mobile = $user_info["mobile"];
        $useremail = $user_info["email"];


        // static data
        $ordDelivDate = "---";
        $ordstat = "Open";
        $ordpmntmthd = "Cash";
        $ordpmntstat = "Not Paid";
        $ordcompln = "Nil";
        // $servvend = "DhakaSetup";
        // $servvendMobile = "+880 1000 000 000";

        if ($mobile=="") {
            echo 'Please enter your mobile number<i>!!!</i>';
        }

        $mobilechksql = "SELECT * FROM users WHERE user_mobile= '$mobile';";
                $mobilechkdata = $dbcon->query($mobilechksql);
                $row = $mobilechkdata->fetch(PDO::FETCH_ASSOC);
                $usermobile=$row['user_mobile'];

                if($usermobile ==""){
                    $sqladdnewuser = "INSERT INTO users( oauth_provider, oauth_uid, first_name, user_mobile, email, created) VALUES ('$oauth_provider', '$mobile', '$userfname', '$mobile', '$useremail', '$created')";
                    $dbcon->query($sqladdnewuser);
                    $userId = $mobile;
                }
        else{
            $userId = $row['oauth_uid'];
        }
        // echo "$sqladdnewuser ";
        $sqlordcustinfo = "INSERT INTO customer_order_info( order_id, user_mobile,user_id,ord_del_date, ord_stat, pymt_mtod, pymt_stat, ord_cmpln, created, created_by) VALUES ('$orderID','$mobile','$userId', '$ordDelivDate', '$ordstat', '$ordpmntmthd', '$ordpmntstat', '$ordcompln', '$created', '$createdBy')";
        if ($dbcon->query($sqlordcustinfo)) {
            $sqlUserStatus = 1;
        }
        
        for($i=1; $i< count($orders_info); $i++){
            $srv_sl = $orders_info[$i]["serviceID"];
            $vendorSQL = "SELECT vendor,vendor_mobile FROM services WHERE srv_sl = '$srv_sl'";
            $vendorSQL = $dbcon->query($vendorSQL);
            $vendorSQL = $vendorSQL->fetch(PDO::FETCH_OBJ);
            $vendor = $vendorSQL->vendor;
            $vendor_mobile = $vendorSQL->vendor_mobile;
            $servicname = $orders_info[$i]["servicename"];
            $serviceprice = $orders_info[$i]["serviceprice"];
            $servicequantity = $orders_info[$i]["servicequantity"];
            $servicetotal = $orders_info[$i]["servicetotal"];
            $schadd = $orders_info[$i]["schedule_address"];
            $schdate = $orders_info[$i]["schdule_date"];
            $schtime = $orders_info[$i]["schedule_time"];
            $userNote = $orders_info[$i]["note"];
            $servicestatus = "Open";
            $servicePymtstatus = "Not paid";
            
        $sqlorderdetails = "INSERT INTO order_details( order_id, srv_sl, srv_name, srv_qty, srv_price, srv_total, sch_add, sch_date, Sch_time, note, srv_state, srv_pymt_stat,vendor_name,vendor_mbl) VALUES ('$orderID','$srv_sl', '$servicname', '$servicequantity', '$serviceprice', '$servicetotal', '$schadd', '$schdate' ,'$schtime', '$userNote', '$servicestatus', '$servicePymtstatus','$vendor','$vendor_mobile')";

            if ($dbcon->query($sqlorderdetails)) {
                $sqlOrdDetailsStatus = 1;
             }
        }

         if ($sqlUserStatus == 1 && $sqlOrdDetailsStatus == 1) {
            echo 'Thanks!  Your order placed sucessfully.';
        } else {
            echo 'Sorry! Something went wrong. Please try again later';
        }
    
}
?>