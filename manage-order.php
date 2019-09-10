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

    require_once 'includes/connection.php';
    require_once 'includes/dashboard-header.php';
?>
<style>
    .caret{
        cursor: pointer;
    }
    .dropUp{
        content: "";
        border-top: 0;
        border-bottom: 4px dashed;
        border-bottom: 4px solid\9;
    }
</style>

            <!-- Manage Order Form -->
            <div class="right_col" role="main">
                <div class="manage-order-heading">
                    <h4>manage order</h4>
                </div>
                <!-- Manage order list header -->
                <div class="order-list-header">
                    <div class="col-sm-6">
                        <div class="order-list-left">
                            <label for="show-order">show</label>
                            <select name="" id="show-order">
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="all" selected>All</option>
                            </select>
                            <label for="show-order">entries</label>
                        </div>
                    </div>
                    <div class="title_right">
                        <div class="col-sm-4 col-sm-offset-2 top_search">
                            <div class="input-group">
                                <input class="filter-box form-control" type="text" data-filter-options='{ "filterTarget":".order-table .dataRow td.dataToSrc", "filterHide":".order-table .dataRow", "highlightColor":"#1ABB9C" }' placeholder="Search Order No/ Name/ Mobile no."></input>
                                <span class="input-group-btn"><button class="btn btn-default" type="button" onClick="window.location.reload();">Clear!</button></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / Manage order list header -->
                <!-- Manage order list table -->
                <?php
                $sqlAllOrderCust = "SELECT sl, order_id, user_mobile, created, ord_stat, pymt_mtod, pymt_stat, created_by  FROM customer_order_info ORDER BY `sl` DESC;";
                $runAllOrdQuery = $dbcon->prepare($sqlAllOrderCust);
                $runAllOrdQuery->execute();
                $allOders = $runAllOrdQuery->fetchAll(PDO::FETCH_ASSOC);
                        // echo "<pre>";
                        // print_r($allOders);
                        // echo "</pre>";
                ?>
                <div class="order-table">
                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>order id&nbsp;<span class="caret"></span></th>
                                <th>customer</th>
                                <th>Mobile</th>
                                <th>created on</th>
                                <th>status</th>
                                <th>payment</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($allOders as $i => $values) {
                                    $userMobile = $values['user_mobile'];
                                    $createdBy = $values['created_by'];
                                    $dsOrderID = 1000 + $values['sl'];
                                    $sqlForCustName = "SELECT first_name, last_name FROM users WHERE user_mobile = '$userMobile'";
                                        $runForNameQuery = $dbcon->prepare($sqlForCustName);
                                        $runForNameQuery->execute();
                                        $custName = $runForNameQuery->fetch(PDO::FETCH_ASSOC);
                                    $custFullName = $custName['first_name'] . " " .$custName['last_name'];
                                    echo "<tr class='dataRow'><td class='dataToSrc'>" . $dsOrderID;
                                    // echo "<tr><td>" . $values['order_id'];
                                    if ($createdBy == "Admin"){
                                    echo "&nbsp;<i class='fa fa-star' aria-hidden='true' title='Admin Created' style='color:#1ABB9C;'></i>";
                                        }else {
                                    echo "&nbsp;<i class='fa fa-star' aria-hidden='true' style='color:transparent;'></i>";
                                        }
                                    echo "</td>";
                                    echo "<td class='dataToSrc'>" . $custFullName . "</td>";
                                    echo "<td class='dataToSrc'>" . $values['user_mobile'] . "</td>";
                                    echo "<td>" . $values['created'] . "</td>";
                                    echo "<td>" . $values['ord_stat'] . "</td>";
                                    echo "<td>" . $values['pymt_mtod'] .  "<br>" . $values['pymt_stat'] . "</td>";
                                    
                                    echo '<td style="text-align:center"><a  href="order-detail.php?id='.  $values['order_id'] . '"><i class="fa fa-eye" aria-hidden="true"></i></a></td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- / Manage order list table -->
                <?php

                require_once 'includes/dashboard-footer.php';

                ?>
    <script type="text/javascript" src="js/filterThis.js"></script>
    <script>
        $(document).ready(function () {
            $("input.filter-box").filterThis();
            $('#start-date').datepicker({});
            $('#end-date').datepicker({});
        });
        $('.caret').click(function() {
        $(this).toggleClass("dropUp");
        })
    </script>

</body>