<?php
	ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

	include "../db2.php";
    
    if(!isset($_POST["orderdata"]))
        return;

	$ord = json_decode($_POST["orderdata"],true);
	//echo print_r($ord);
	//echo "\n";
	$slen = count($ord['services']);
	for($i = 0; $i < $slen; $i++){
		//echo $i.$ord['services'][$i]["servicename"]."\n";
	}




    $order_sl = '';
    $oauth_uid = $ord['oauth_uid'];
    $order_id = "ORD" . date('dym',strtotime(date('Y-m-d H:i:s'))) . sprintf("%06d", mt_rand(1, 999999));
    $status = "On Going";

    $d_address = $ord['d_address'];
    $d_date = $ord['d_date'];
    $d_timerange = $ord['d_timerange'];

    $open_time = date('Y-m-d H:i:s');
    $close_time = null;

    $total_am = $ord['total_am'];
    $disc_am = $ord['disc_am'];
    $net_am = $ord['net_am'];
    $paid_am = $ord['paid_am'];
    $due_am = $ord['due_am'];




    // $sqlordcustinfo = "INSERT INTO app_order( order_id, user_mobile,user_id,ord_del_date, ord_stat, pymt_mtod, pymt_stat, ord_cmpln, created, created_by) VALUES ('$orderID','$mobile','$userId', '$ordDelivDate', '$ordstat', '$ordpmntmthd', '$ordpmntstat', '$ordcompln', '$created', '$createdBy')";

    $sqlordcustinfo = "INSERT INTO `app_order` (`order_sl`, `oauth_uid`, `order_id`, `status`, `d_address`, `d_date`, `d_timerange`, `open_time`, `close_time`, `total_am`, `disc_am`, `net_am`, `paid_am`, `due_am`) VALUES (NULL, '$oauth_uid', '$order_id', 'On Going', '$d_address', '$d_date', '$d_timerange', '$open_time', '$close_time', '$total_am', '$disc_am', '$net_am', '$paid_am', '$due_am')";

    mysqli_query($conn, $sqlordcustinfo);
    $last_id = mysqli_insert_id($conn);

    // inserting props >>>
    
    for($i=0; $i< count($ord['services']); $i++){


        $id = null;
        $order_sl = $last_id;
        $srv_sl = $ord['services'][$i]['serviceID'];
        $srvice = $ord['services'][$i]['servicename'];
        $srvImage = $ord['services'][$i]['srvImage'];
        $srvQty = $ord['services'][$i]['servicequantity'];
        $srvPrice = $ord['services'][$i]['serviceprice'];
        $srvTotal = $ord['services'][$i]['servicetotal'];
        $prop_id = null;
        $prop_name = null;
        $prop_qty = null;
        $prop_price = null;
        $prop_total = null;

        $sqlorderdetails = "INSERT INTO app_order_details( id,order_sl,srv_sl,srvice,srvImage,srvQty,srvPrice,prop_id,prop_name,prop_qty,prop_price ) 
        VALUES('$id','$order_sl','$srv_sl','$srvice','$srvImage','$srvQty','$srvPrice','$prop_id','$prop_name','$prop_qty','$prop_price')";
        

        mysqli_query($conn, $sqlorderdetails);
    }

    for($i=0; $i< count($ord['props']); $i++){


        $id = null;
        $srv_sl = $ord['props'][$i]['serviceID'];
        $srvice = $ord['props'][$i]['servicename'];
        $srvImage = $ord['props'][$i]['srvImage'];
        $srvQty = $ord['props'][$i]['servicequantity'];
        $srvPrice = $ord['props'][$i]['serviceprice'];
        $srvTotal = $ord['props'][$i]['servicetotal'];
        $prop_id = $ord['props'][$i]['prop_id'];
        $prop_name = $ord['props'][$i]['prop_name'];
        $prop_qty = $ord['props'][$i]['prop_qty'];
        $prop_price = $ord['props'][$i]['prop_price'];
        $prop_total = $ord['props'][$i]['prop_total'];

        $sqlorderdetails = "INSERT INTO app_order_details( id,order_sl,srv_sl,srvice,srvImage,srvQty,srvPrice, srvTotal,prop_id,prop_name,prop_qty,prop_price,prop_total ) 
        VALUES('$id','$order_sl','$srv_sl','$srvice','$srvImage','$srvQty','$srvPrice','$srvTotal','$prop_id','$prop_name','$prop_qty','$prop_price','$prop_total')";
        

        mysqli_query($conn, $sqlorderdetails);
    }
    
    
    echo $last_id+1000;
	
	mysqli_close($conn);

?>

