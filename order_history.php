<?php

require_once 'main-header-dhaka-setup.php';
require_once 'includes/connection.php';
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}
else{
    echo "<script>location.href='index.php'</script>";
}

$query = "SELECT user_mobile FROM users WHERE oauth_uid=:id";
$query = $dbcon->prepare($query);
$query->bindValue(":id",$user_id);
$query->execute();
$query = $query->fetch(PDO::FETCH_OBJ);
$user_mobile = $query->user_mobile;

$query = "SELECT customer_order_info.order_id,customer_order_info.created,order_details.srv_name, order_details.srv_pymt_stat, order_details.srv_total, order_details.sch_date, order_details.srv_state 
          FROM `customer_order_info`,order_details 
          WHERE customer_order_info.user_mobile = :mobile AND order_details.order_id=customer_order_info.order_id";

$query = $dbcon->prepare($query);
$query->bindValue(":mobile", $user_mobile);
$query->execute();

?>



    <!-- Order History -->
    <section class="order-table">
        <div class="container">
            <h2>Order History</h2>
            <table class="table table-hover">
                <tr>
                    <th>Order ID</th>
                    <th>Service Name</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Ordered Date</th>
                    <th>Scheduled Date</th>
                    <th>Status</th>
                </tr>

                <?php while($order = $query->fetch(PDO::FETCH_OBJ)) : ?>
                <tr>
                    <?php

                    $createdDate = date_create($order->created);
                    $scheduledDate = date_create($order->sch_date);
                    if($order->srv_state == "Open"){
                        $status = "Not Accepted";
                    }
                    else if($order->srv_state == "Accept"){
                        $status = "On Going";
                    }
                    else if($order->srv_state == "Served"){
                        $status = "Completed";
                    }
                    else if($order->srv_state == "Cancel"){
                        $status = "Cancelled";
                    }
                    else{
                    	$status = "";
                    }

                    ?>
                    <td><?php echo $order->order_id;?></td>
                    <td><?php echo $order->srv_name;?></td>
                    <td><?php echo $order->srv_total;?></td>
                    <td><?php echo $order->srv_pymt_stat;?></td>
                    <td><?php echo date_format($createdDate,'d M Y')?></td>
                    <td><?php echo date_format($scheduledDate,'d M Y')?></td>
                    <td><?php echo $status;?></td>
                </tr>

                <?php endwhile;?>

            </table>
        </div>
    </section>
    <!-- / Order History -->

<?php 

require_once'main-footer-dhaka-setup.php';

?>

</body>

</html>