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
        require_once 'includes/orderUpdateSQL.php';

        // header file
        require_once 'includes/dashboard-header.php';
?>
    <script src="js/jquery.min.js"></script>
    <style>
    .accept {
        color: green;
    }
    
    .decline {
        color: red;
    }
    
    .late {
        font-size: 14px;
        font-weight: bold;
        color: red;
        font-style: italic;
        animation-duration: 1s;
        animation-name: blink;
        animation-iteration-count: infinite;
        animation-direction: alternate;
        animation-timing-function: ease-in-out;
    }
    
    @keyframes blink {
        from {
            opacity: 1;
        }
        to {
            opacity: 0.3;
        }
    }
    </style>
    <!-- /top navigation -->
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <!-- <form class="form-horizontal" action="" method="POST"> -->
            <div class="form-horizontal">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>ORDER UPDATE&nbsp;<a href="order-detail.php?id=<?php echo $orderID;?>
                            "><small><em><?php echo $dsOrderID;?></em></small></a></h2>
                                <small class="pull-right"><a href="manage-order.php" style="cursor: pointer;"><i>Back to all orders</i></a></small>
                                <ul class="nav navbar-right panel_toolbox">
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <!-- Order Details and Info -->
                                <div id="create-order-detail" style="margin-top: 0px;">
                                    <div class="create-order-order-info">
                                        <div class="col-sm-12">
                                            <p style="font-size: 24px; margin-bottom: 40px; text-transform: capitalize;">
                                                <?php echo $serviceName;?>
                                            </p>
                                            <?php if ($serviceStatus == 'Open')
                                            {; ?>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order-status">Service Status <span class="required">*</span>
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <p style="font-size: 24px;">
                                                        <?php echo $serviceStatus;?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Action
                                                </label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <form action="order-update.php?oid=<?php echo $orderID . '&sid=' . $serviceID; ?>" method="POST">
                                                        <div class="input-group">
                                                            <input id="delivered-date" class="date-picker form-control col-md-7 col-xs-12" type="text" value="<?php echo $serviceDelDate; ?>" name="delDate" title="Delivery Date: mm/dd/yyyy">
                                                            <div class="input-group-btn">
                                                                <button class="btn btn-default" type="submit" name="btn_accept">Accept&nbsp;<i class="fa fa-check-circle accept" aria-hidden="true"></i></button>
                                                                <button class="btn btn-default" type="submit" name="btn_decline" onclick="window.location.reload(true);">Decline&nbsp;<i class="fa fa-times-circle decline" aria-hidden="true"></i></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <?php
                                                    if (isset($_POST['btn_accept'])) {
                                                        $servStatus = "Accepted";
                                                        $delvDate = $_POST["delDate"];
                                                        if($delvDate == ""){
                                                        echo "<p class=\"decline\">Please select the delevery date!</p>";
                                                        echo '<script language="javascript">';
                                                        echo '$("#delivered-date").focus();';
                                                        echo '</script>';
                                                        } else {
                                                        $delvDate = date("Y-m-d", strtotime($delvDate) );
                                                            $sqlOrdStatUpdate = "UPDATE `order_details` SET `srv_del_date`='$delvDate', `srv_state`='$servStatus' WHERE `order_id` = '$orderID' AND `sl`= '$serviceID' LIMIT 1";
                                                            // echo $sqlOrdStatUpdate;
                                                            $runOrdStatUpdateQuery = $dbcon->prepare($sqlOrdStatUpdate);
                                                            $runOrdStatUpdateQuery->execute();
                                                            echo '<script language="javascript">';
                                                            echo 'window.location.href = "order-update.php?oid='.  $orderID . '&sid=' . $serviceID . '";';
                                                            echo '</script>';
                                                            }

                                                     } else if (isset($_POST['btn_decline'])) {
                                                        $delvDate = date('Y-m-d');
                                                        $servStatus = "Declined";
                                                        $sqlOrdStatUpdate = "UPDATE `order_details` SET `srv_del_date`='$delvDate', `srv_state`='$servStatus' WHERE `order_id` = '$orderID' AND `sl`= '$serviceID' LIMIT 1";;
                                                            $runOrdStatUpdateQuery = $dbcon->prepare($sqlOrdStatUpdate);
                                                            $runOrdStatUpdateQuery->execute();
                                                        // echo $sqlOrdStatUpdate;
                                                            echo '<script language="javascript">';
                                                            echo 'window.location.href = "order-update.php?oid='.  $orderID . '&sid=' . $serviceID . '";';
                                                            echo '</script>';
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <?php
                                            };
                                            if ($serviceStatus == 'Accepted')
                                            {; 
                                        ?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order-status">Service Status
                                                    </label>
                                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                                        <p style="font-size: 24px; text-transform: capitalize;">
                                                            <?php echo $serviceStatus;
                                                $today = date("m/d/Y");
                                                // $today = new DateTime($today);
                                                // $serviceDelDate = new DateTime($serviceDelDate);
                                                if ($serviceDelDate < $today){
                                                echo "<span class=\"late\"> but LATE!</span></p>";

                                                }
                                                ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="order-status">Delivery date
                                                    </label>
                                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                                        <p style="font-size: 18px;">
                                                            <?php 
                                                            $serviceDelDate = date("d F, Y", strtotime($serviceDelDate) );
                                                            echo $serviceDelDate; 
                                                            ?>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Action
                                                    </label>
                                                    <div class="col-md-5 col-sm-6 col-xs-12">
                                                        <form action="order-update.php?oid=<?php echo $orderID . '&sid=' . $serviceID; ?>" method="POST">
                                                            <div class="input-group">
                                                                <div class="input-group-btn">
                                                                    <button class="btn btn-default" type="submit" name="btn_served">Serve&nbsp;<i class="fa fa-check-circle accept" aria-hidden="true"></i></button>
                                                                    <button class="btn btn-default" type="submit" name="btn_canceled">Cancel&nbsp;<i class="fa fa-times-circle decline" aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <?php
                                                    if (isset($_POST['btn_served'])) {
                                                        $servStatus = "Served";
                                                        $delvDate = date("Y-m-d");
                                                            $sqlOrdStatUpdate = "UPDATE `order_details` SET `srv_del_date`='$delvDate', `srv_state`='$servStatus' WHERE `order_id` = '$orderID' AND `sl`= '$serviceID' LIMIT 1";
                                                            // echo $sqlOrdStatUpdate;
                                                            $runOrdStatUpdateQuery = $dbcon->prepare($sqlOrdStatUpdate);
                                                            $runOrdStatUpdateQuery->execute();
                                                            echo '<script language="javascript">';
                                                            echo 'window.location.href = "order-update.php?oid='.  $orderID . '&sid=' . $serviceID . '";';
                                                            echo '</script>';
                                                     } else if (isset($_POST['btn_canceled'])) {
                                                        $delvDate = date('Y-m-d');
                                                        $servStatus = "Canceled";
                                                        $sqlOrdStatUpdate = "UPDATE `order_details` SET `srv_del_date`='$delvDate', `srv_state`='$servStatus' WHERE `order_id` = '$orderID' AND `sl`= '$serviceID' LIMIT 1";;
                                                            $runOrdStatUpdateQuery = $dbcon->prepare($sqlOrdStatUpdate);
                                                            $runOrdStatUpdateQuery->execute();
                                                        // echo $sqlOrdStatUpdate;
                                                            echo '<script language="javascript">';
                                                            echo 'window.location.href = "order-update.php?oid='.  $orderID . '&sid=' . $serviceID . '";';
                                                            echo '</script>';
                                                    }
                                                ?>
                                                    </div>
                                                </div>
                                                <?php
                                            };
                                            if ($serviceStatus == 'Served')
                                            {; 
                                        ?>
                                                    <div class="form-group">
                                                        <p style="font-size: 24px; text-align: center;">This service has already been <strong><u><?php 
                                                $serviceDelDate = date("d F, Y", strtotime($serviceDelDate));
                                                echo $serviceStatus . '</u></strong> on ' . $serviceDelDate; ?>.
                                                        </p>
                                                    </div>
                                                    <?php
                                            };
                                            if ($serviceStatus == 'Canceled' || $serviceStatus == 'Declined')
                                            {; 
                                        ?>
                                        <div class="form-group decline">
                                            <p style="font-size: 24px; text-align: center;">This service has already been <strong><u><?php 
                                                $serviceDelDate = date("d F, Y", strtotime($serviceDelDate));
                                                echo $serviceStatus . '</u></strong> on ' . $serviceDelDate; ?>.
                                            </p>
                                        </div>
                                        <?php
                                            };
                                        ?>
                                        </div>
                                        <form action="" method="POST" id="updateForm">
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment-status">Payment Status</label>
                                                <div class="col-md-5 col-sm-6 col-xs-12">
                                                    <!-- <select name="payment-status" class="form-control">
                                                        <option value="">Select Payment Status</option>
                                                        <option <?php //if ($servicePymtStatus=="Paid" ) echo 'selected' ; ?> value="Paid">Paid</option>
                                                        <option <?php //if ($servicePymtStatus=="Not Paid" ) echo 'selected' ; ?> value="Not Paid">Not Paid</option>
                                                    </select> -->
                                                    <p style="font-size: 18px;"><strong><?php echo $servicePymtState;?></strong></p>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Other Details</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <br />
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Quantity
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input class="form-control col-md-7 col-xs-12" type="number" name="up_qntity" min="1" value="<?php echo $serviceQty; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Price (Total)
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input class="form-control col-md-7 col-xs-12" type="text" name="up_price" value="<?php echo $serviceTotal; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="srv-paid">Amount Paid
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="srv-paid" class="form-control col-md-7 col-xs-12" placeholder="Amount already been received for this order" value="<?php echo $servicePaid; ?>" title="Amount already been received for this order">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="srv-dscnt">Discount
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="srv-dscnt" class="form-control col-md-7 col-xs-12 disabled" placeholder="Discount" value="<?php echo $serviceDiscount; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-name">Vendor Name
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <?php //$vendor_name = $values['vendor_name']; ?>
                                        <select name="vendor-name" class="form-control">
                                            <option <?php if ($serviceVndrName=="" ) echo 'selected' ; ?> value="" >Select Vendor</option>
                                            <option <?php if ($serviceVndrName=="Vendor-1" ) echo 'selected' ; ?> value="Vendor-1" >Vendor-1</option>
                                            <option <?php if ($serviceVndrName=="Vendor-2" ) echo 'selected' ; ?> value="Vendor-2" >Vendor-2</option>
                                            <option <?php if ($serviceVndrName=="Vendor-3" ) echo 'selected' ; ?> value="Vendor-3" >Vendor-3</option>
                                            <option <?php if ($serviceVndrName=="Vendor-4" ) echo 'selected' ; ?> value="Vendor-4" >Vendor-4</option>
                                            <option <?php if ($serviceVndrName=="Vendor-5" ) echo 'selected' ; ?> value="Vendor-5" >Vendor-5</option>
                                            <option <?php if ($serviceVndrName=="Vendor-6" ) echo 'selected' ; ?> value="Vendor-6" >Vendor-6</option>
                                            <option <?php if ($serviceVndrName=="Vendor-7" ) echo 'selected' ; ?> value="Vendor-7" >Vendor-7</option>
                                            <option <?php if ($serviceVndrName=="Vendor-8" ) echo 'selected' ; ?> value="Vendor-8" >Vendor-8</option>
                                            <option <?php if ($serviceVndrName=="Vendor-9" ) echo 'selected' ; ?> value="Vendor-9" >Vendor-9</option>
                                            <option <?php if ($serviceVndrName=="Vendor-10" ) echo 'selected' ; ?> value="Vendor-10" >Vendor-10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vendor-contact">Vendor Contact Number
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <?php //$vendor_mbl = $values['vendor_mbl']; ?>
                                        <select name="vendor-tel" class="form-control">
                                            <option <?php if ($serviceVndrMo=="" ) echo 'selected' ; ?> value="" >Select Vendor Mobile Number</option>
                                            <option <?php if ($serviceVndrMo=="01812345541" ) echo 'selected' ; ?> value="01812345541" >01812345541</option>
                                            <option <?php if ($serviceVndrMo=="01812345542" ) echo 'selected' ; ?> value="01812345542" >01812345542</option>
                                            <option <?php if ($serviceVndrMo=="01812345543" ) echo 'selected' ; ?> value="01812345543" >01812345543</option>
                                            <option <?php if ($serviceVndrMo=="01812345544" ) echo 'selected' ; ?> value="01812345544" >01812345544</option>
                                            <option <?php if ($serviceVndrMo=="01812345545" ) echo 'selected' ; ?> value="01812345545" >01812345545</option>
                                            <option <?php if ($serviceVndrMo=="01812345546" ) echo 'selected' ; ?> value="01812345546" >01812345546</option>
                                            <option <?php if ($serviceVndrMo=="01812345547" ) echo 'selected' ; ?> value="01812345547" >01812345547</option>
                                            <option <?php if ($serviceVndrMo=="01812345548" ) echo 'selected' ; ?> value="01812345548" >01812345548</option>
                                            <option <?php if ($serviceVndrMo=="01812345549" ) echo 'selected' ; ?> value="01812345549" >01812345549</option>
                                            <option <?php if ($serviceVndrMo=="01812345550" ) echo 'selected' ; ?> value="01812345550" >01812345550</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="update-btn pull-right">
                            <button class="btn btn-default" name="updateOrder" id="applyUpdate">Update Order</button>
                        </div>
                        <div class="update-btn pull-right">
                            <a href='order-detail.php?id=<?php echo $orderID; ?>' class="btn btn-default">Back to Order</a>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="<?php echo $i;?>" name="hiddenValue">
                <input type="hidden" value="<?php echo $serviceStatus;?>" id="hiddenState">
                </form>
            </div>
        </div>
    </div>
    <?php

    require_once 'includes/dashboard-footer.php';

    ?>
</div>
<script type="text/javascript">
        $(function() {
            $("#delivered-date").datepicker({
                minDate: 1,
            });
        });
        var srvState = $('#hiddenState').val();
        // console.log(srvState);
        if (srvState == "Declined" || srvState == "Canceled") {
            $('input[type="text"],input[type="number"], select, #applyUpdate').attr('disabled', "disabled" );
        }
</script>
        </body>

        </html>
