<?php

        $orderID = isset($_GET['id']) ? $_GET['id'] : 0;

        // Get details of current order
        		$sqlAOrderDetails = "SELECT customer_order_info.sl, customer_order_info.order_id, customer_order_info.user_mobile, customer_order_info.ord_del_date, customer_order_info.created, customer_order_info.ord_stat, customer_order_info.pymt_mtod, customer_order_info.pymt_stat, customer_order_info.ord_cmpln, users.first_name, users.last_name, users.email  FROM customer_order_info, users WHERE customer_order_info.user_mobile = users.user_mobile AND customer_order_info.order_id = '$orderID' LIMIT 1";
                $runOrdDetailsQuery = $dbcon->prepare($sqlAOrderDetails);
                $runOrdDetailsQuery->execute();
                $oderDetails = $runOrdDetailsQuery->fetch(PDO::FETCH_ASSOC);

                $dsOrderID = $oderDetails['sl'] + 1000;
                $mobileNo = $oderDetails['user_mobile'];
                $orderStatus = $oderDetails['ord_stat'];
                $custName = $oderDetails['first_name'] . " " .$oderDetails['last_name'];
                
                // Get all order_id's of this customer
                $allOrderNosQuery= "SELECT `order_id` FROM `customer_order_info` WHERE `user_mobile` = '$mobileNo'";
                $allOrderNosQuery = $dbcon->prepare($allOrderNosQuery);
                $allOrderNosQuery->execute();
                $oderNos = $allOrderNosQuery->fetchAll(PDO::FETCH_ASSOC);
                
                // Get total number of orders except this order by this customer
                 $totOrderd = ($allOrderNosQuery->rowCount()) - 1;

                // Get number of orders by this customer that already completed
                    $orderCompletedQuery= "SELECT `ord_stat` FROM `customer_order_info` WHERE `user_mobile` = '$mobileNo' AND `ord_stat` = 'Close'";
                    $orderCompletedQuery = $dbcon->prepare($orderCompletedQuery);
                    $orderCompletedQuery->execute();
                    $orderCompleted = $orderCompletedQuery->rowCount();

                // Get all order value
                    $allOrderValue = 0;
                    foreach ($oderNos as $i => $values) {
                        $anOrder = $values['order_id'];
                        $anOrderQuery= "SELECT SUM(`srv_total`) FROM order_details WHERE `order_id` = '$anOrder'";
                        $anOrderQuery = $dbcon->prepare($anOrderQuery);
                        $anOrderQuery->execute();
                        $orderTotal = $anOrderQuery->fetch(PDO::FETCH_ASSOC);
                        $allOrderValue = $allOrderValue + $orderTotal['SUM(`srv_total`)'];
                        }

                // Get this order value
                    $lastOrderQuery= "SELECT SUM(`srv_total`) FROM order_details WHERE `order_id` = '$orderID'";
                    $lastOrderQuery = $dbcon->prepare($lastOrderQuery);
                    $lastOrderQuery->execute();
                    $lastOrderTotal = $lastOrderQuery->fetch(PDO::FETCH_ASSOC);
                    $lastOrderValue = $lastOrderTotal['SUM(`srv_total`)'];
                    
                // Get total value of orders except this order
                    $allWithoutLastOrd = $allOrderValue - $lastOrderValue;
                
                // Get total value received
                    $amtReceived = 0;
                    foreach ($oderNos as $i => $values) {
                        $anOrder = $values['order_id'];
                        $rcvdFrmAOrderQuery= "SELECT SUM(`srv_amt_paid`) FROM order_details WHERE `order_id` = '$anOrder'";
                        $rcvdFrmAOrderQuery = $dbcon->prepare($rcvdFrmAOrderQuery);
                        $rcvdFrmAOrderQuery->execute();
                        $recvdTotal = $rcvdFrmAOrderQuery->fetch(PDO::FETCH_ASSOC);
                        $amtReceived = $amtReceived + $recvdTotal['SUM(`srv_amt_paid`)'];
                        }

                // discount given this order (if any)
                    $thisOrderDiscountQuery= "SELECT SUM(`srv_discount`) FROM order_details WHERE `order_id` = '$orderID'";
                    $thisOrderDiscountQuery = $dbcon->prepare($thisOrderDiscountQuery);
                    $thisOrderDiscountQuery->execute();
                    $thisOrderDiscountTotal = $thisOrderDiscountQuery->fetch(PDO::FETCH_ASSOC);
                    $discountThisOrderValue = $thisOrderDiscountTotal['SUM(`srv_discount`)'];

                // amount received this order (if any)
                    $lastOrderPymntQuery= "SELECT SUM(`srv_amt_paid`) FROM order_details WHERE `order_id` = '$orderID'";
                    $lastOrderPymntQuery = $dbcon->prepare($lastOrderPymntQuery);
                    $lastOrderPymntQuery->execute();
                    $lastOrderPaidTotal = $lastOrderPymntQuery->fetch(PDO::FETCH_ASSOC);
                    $pymntLastOrderValue = $lastOrderPaidTotal['SUM(`srv_amt_paid`)'];

                // amount due this order
                    $amtDueThis = $lastOrderValue - $pymntLastOrderValue - $discountThisOrderValue;                        

                // amount received except this order
                    $totalReceivedAll = $amtReceived - $pymntLastOrderValue;

                // amount due except this order
                    $amtDueAll = $allWithoutLastOrd - $totalReceivedAll;

                // display values
                    $totalPaidThisOrder = ($pymntLastOrderValue != 0) ? $pymntLastOrderValue : " Nil";
                    $totalDueThisOrder = ($amtDueThis > 0) ? ("Tk. " . $amtDueThis . ".00") : " Nil";
                    $discountThisOrder = ($discountThisOrderValue != 0) ? ("Tk. " . $discountThisOrderValue . ".00") : " Nil";
                    
                // change order status
                    if ($totalDueThisOrder == " Nil") {
                    $updateOrdStateQuery= "UPDATE `customer_order_info` SET `ord_stat`='Close', `pymt_stat`='Paid' WHERE `order_id` = '$orderID' LIMIT 1";
                    $updateOrdState = $dbcon->prepare($updateOrdStateQuery);
                    $updateOrdState->execute();                 
                     } else {
                    $updateOrdStateQuery= "UPDATE `customer_order_info` SET `ord_stat`='Open', `pymt_stat`='Not Paid' WHERE `order_id` = '$orderID' LIMIT 1";
                    $updateOrdState = $dbcon->prepare($updateOrdStateQuery);
                    $updateOrdState->execute();
                     }
?>