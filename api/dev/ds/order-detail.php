<?php
        session_start();
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        
        $loggedin = (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
         if($loggedin != 'True'){
            echo "<script>window.location.href = \"login.php\"</script>";
        }
        else{
            $user_name = $_SESSION['user_name'];
        }
        // db Connection
        require_once 'includes/connection.php';

        // all sql's
        require_once 'includes/orderDetailsSQL.php';

        // header file
        require_once 'includes/dashboard-header.php';
?>



            <!-- /top navigation -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2 class="pull-left">ORDER HISTORY &amp; DETAILS</h2>
                                        <small class="pull-right"><a href="manage-order.php" style="cursor: pointer;"><i>Back to all orders</i></a></small>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <!-- Order Details and Info -->
                                        <div id="create-order-detail">
                                            <div class="create-order-order-info">
                                                <div class="col-sm-5 thumbnail">
                                                    <ul>
                                                        <li>
                                                            <p><strong>customer name :</strong> <?php echo $custName;?> </p>
                                                        </li>
                                                        <li>
                                                            <p><strong>mobile :</strong> <?php echo $oderDetails['user_mobile'];?> </p>
                                                        </li>
                                                        <li>
                                                            <p><strong>email :</strong> <?php echo $oderDetails['email'];?> </p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="create-order-user-info">
                                                <div class="col-sm-5 col-sm-offset-1 thumbnail">
                                                    <ul>
                                                        <li>
                                                            <p><strong>order placed before:</strong> <?php echo $totOrderd;?> </p>
                                                        </li>
                                                        <li>
                                                            <p><strong>order completed till now:</strong> <?php echo $orderCompleted;?> </p>
                                                        </li>
                                                        <li>
                                                            <p><strong>total order value Except this order:</strong> Tk. <?php echo $allWithoutLastOrd;?>.00 </p>
                                                        </li>
                                                        <li>
                                                            <p><strong>total paid Except this order:</strong>Tk. <?php echo $totalReceivedAll;?>.00 </p>
                                                        </li>
                                                        <li>
                                                            <p><strong>amount due Except this order: Tk.</strong> <?php echo $amtDueAll;?>.00 </p>
                                                        </li>
                                                        </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / Order Details and Info -->
                                        <!-- Order list table header -->
                                        <div class="order-detail-table-header">
                                            <div class="col-sm-12">
                                            <p><strong>Order id : <i><?php echo $dsOrderID . "<small>&nbsp;&nbsp;" . $orderStatus . "</small>"; ?></i></strong></p>
                                            </div>
                                            
                                        </div>
                                        <!-- / Order list table header -->
                                        <!-- Manage order list table -->

                                        <div class="order-detail-table">
                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>job id</th>
                                                        <th>service</th>
                                                        <th>qty</th>
                                                        <th>unit price</th>
                                                        <th>total price</th>
                                                        <th>Discount</th>
                                                        <th>Amount Paid</th>
                                                        <th>status</th>
                                                        <th>edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sqlOrderInDetails = "SELECT *  FROM order_details WHERE order_details.order_id ='$orderID'";
                                                    $runOrderInDetailsQuery = $dbcon->prepare($sqlOrderInDetails);
                                                    $runOrderInDetailsQuery->execute();
                                                    $OrderInDetails = $runOrderInDetailsQuery->fetchAll(PDO::FETCH_ASSOC);
                                                    $row_count = $runOrderInDetailsQuery->rowCount();
                                                    // echo "<pre>";
                                                    // print_r($OrderInDetails);
                                                    // echo "</pre>";
                                                    $grandTotal = 0;
                                    foreach ($OrderInDetails as $i => $values) {
                                        echo "<tr><td>Job" . $values['sl'] . "</td>";
                                        echo "<td><strong>" . $values['srv_name'] . "</strong></td>";
                                        echo "<td>" . $values['srv_qty'] . "</td>";
                                        echo "<td>" . $values['srv_price'] . "</td>";
                                        $srviceTotal = ($values['srv_total'] - $values['srv_discount']);
                                        echo "<td>" . $srviceTotal . "</td>";
                                        echo "<td>" . $values['srv_discount'] . "</td>";
                                        echo "<td>" . $values['srv_amt_paid'] . "</td>";
                                        echo "<td>" . $values['srv_state'] . "</td>";
                                        echo '<td style="text-align:center"><a  href="order-update.php?oid='.  $values['order_id'] . '&sid=' . $values['sl'] . '"><i class="fa fa-edit" aria-hidden="true"></i></a></td>';
                                        // echo "<td><a href='single.php?id=" . $values['sl'] . "' class='btn'>details</a></td></tr>";
                                        $grandTotal = $grandTotal + $values['srv_total'];
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <!-- Manage order list table -->
                                            <div class="order-detail-table-footer">
                                                <div class="order-footer-left">
                                                    <div class="col-sm-6">
                                                        <p>Total <i><?php echo $row_count; ?></i> job(s) under  this order.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / Manage order list table -->
                                        <!-- Manage order list table -->
                                        <div class="order-detail-price-table">
                                            <table id="datatable" class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th><strong>total price :</strong> Tk. <?php echo $grandTotal; ?>.00</th>
                                                        <th><strong>total paid : <?php echo $totalPaidThisOrder;?></strong></th>
                                                        <th><strong>discount : </strong> <?php echo $discountThisOrder;?></th>
                                                        <th><strong>Due : <?php echo $totalDueThisOrder;?></strong></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                        
                                         <!--Comment box-->
                                         <form action="order-detail.php" method="POST">
					  <div class="form-group">
					    <label for="comment_text">Comment:</label>
					    <textarea class="form-control" id="comment_text" name="comment_text" placeholder="Write your comment here...."></textarea> 
					    
					  </div>
					  
					  <input type="submit" value="Add Comment" class="btn btn-info" />
					 </form> 
					 
					 
					     
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <div class="update-btn pull-right" style="margin: 10px 0px;">
                                    <a href='order-update.php?id=<?php echo $orderID; ?>' class="btn btn-default">Update Order</a>
                                </div> -->
                                <div class="update-btn pull-right" style="margin: 10px 0px;">
                                    <a href='manage-order.php' class="btn btn-default">All Orders</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 

                    require_once 'includes/dashboard-footer.php';

                    ?>


</body>

</html>