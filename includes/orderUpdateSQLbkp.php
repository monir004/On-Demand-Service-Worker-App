<?php

    $orderID = isset($_GET['oid']) ? $_GET['oid'] : '';
    $serviceID = isset($_GET['sid']) ? $_GET['sid'] : '';

    
    // Get specific details of current order
    $sqlAOrderDetails = "SELECT * FROM order_details WHERE order_id = '$orderID' AND sl = '$serviceID'";
    $runOrdDetailsQuery = $dbcon->prepare($sqlAOrderDetails);
    $runOrdDetailsQuery->execute();
    $oderDetails = $runOrdDetailsQuery->fetch(PDO::FETCH_ASSOC);

    $sqlAOrderID = "SELECT sl FROM customer_order_info WHERE order_id = '$orderID'";
    $getOrdIDQuery = $dbcon->prepare($sqlAOrderID);
    $getOrdIDQuery->execute();
    $oderID = $getOrdIDQuery->fetch(PDO::FETCH_ASSOC);
    $dsOrderID = $oderID['sl'] + 1000;
    // echo "<pre>";
    // print_r($overallDetails);
    // print_r($oderDetails);
    // echo "</pre>";

    $serviceName = $oderDetails['srv_name'];
    $serviceDelDate = $oderDetails['srv_del_date'];
    if($serviceDelDate != ""){
    $serviceDelDate = DateTime::createFromFormat('Y-m-d',$serviceDelDate);
    $serviceDelDate = $serviceDelDate->format("m/d/Y");
    }


    $serviceStatus = $oderDetails['srv_state'];
    $servicePymtStatus = $oderDetails['srv_pymt_stat'];
    $serviceQty = $oderDetails['srv_qty'];
    $serviceTotal = $oderDetails['srv_total'];
    $servicePaid = $oderDetails['srv_amt_paid'];
    $serviceDiscount = $oderDetails['srv_discount'];
    $serviceVndrName = $oderDetails['vendor_name'];
    $serviceVndrMo = $oderDetails['vendor_mbl'];
// display payment status
    $serviceAmtDue = $serviceTotal - $servicePaid - $serviceDiscount;
    $servicePymtState = ($serviceAmtDue > 0) ? ("Not Paid <small>(due: <em>Tk. " . $serviceAmtDue . ".00</em>)</small>") : " Paid.";
// if form submitted
    if (isset($_POST['updateOrder'])) {
        // $paymentStatus = "";
        $upQntity = $_POST["up_qntity"];
        $upPrice = $_POST["up_price"];
        // $srvStat = $_POST["srv-stat"];
        $srvPaid = $_POST["srv-paid"];
        $srvPaid = ($srvPaid > 0) ? $srvPaid : 0;
        $srvDscnt = $_POST["srv-dscnt"];
        $srvDscnt = ($srvDscnt > 0) ? $srvDscnt : 0;
        $vendorName = $_POST["vendor-name"];
        $vendorTel = $_POST["vendor-tel"];

        $sqlOrdDetails = "UPDATE `order_details` SET `srv_qty`='$upQntity', `srv_total`='$upPrice', `srv_discount`='$srvDscnt', `srv_amt_paid`='$srvPaid', `vendor_name`='$vendorName', `vendor_mbl`='$vendorTel' WHERE `order_id` = '$orderID' AND `sl`= '$serviceID' LIMIT 1";
        // echo "$sqlOrdDetails";
        $updateOrdDetails = $dbcon->prepare($sqlOrdDetails);
        if ($updateOrdDetails->execute()) {
            echo '<script language="javascript">';
            echo 'alert("Thanks!  Order Updated sucessfully.");';
            echo 'window.location.href = "order-detail.php?id='. $orderID .'";';
            echo '</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Sorry! Order update failed. Please try again later");';
            echo 'window.location.href = "order-update.php?oid='.  $orderID . '&sid=' . $serviceID . '";';
            echo '</script>';
        }
    }    
?>