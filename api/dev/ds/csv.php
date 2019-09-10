<?php 
require_once'includes/connection.php';
$output = '';
if(isset($_POST['ord_btn'])){
$sql = "SELECT order_id, srv_sl, srv_name, srv_qty, srv_price, srv_total, srv_discount, srv_amt_paid, srv_pymt_stat, sch_add, sch_date, sch_time, note, srv_state, vendor_name, vendor_mbl, srv_del_date FROM order_details";
$result = $dbcon->query($sql);
if(!empty($result) AND $result->rowCount() > 0){
   $output .= '
        <table class="table" bordered="1">
            <tr>
                <th>first_name</th>
                <th>last_name</th>
                <th>email</th>
                <th>user_mobile</th>
            </tr>
   ';
        while($row = $result->fetch(PDO::FETCH_ASSOC)){
                $output .= '
                    <tr>
                        <td>'.$row["order_id"].'</td>
                        <td>'.$row["srv_sl"].'</td>
                        <td>'.$row["srv_name"].'</td>
                        <td>'.$row["srv_qty"].'</td>
                        <td>'.$row["srv_price"].'</td>
                        <td>'.$row["srv_total"].'</td>
                        <td>'.$row["srv_discount"].'</td>
                        <td>'.$row["srv_amt_paid"].'</td>
                        <td>'.$row["srv_pymt_stat"].'</td>
                        <td>'.$row["sch_add"].'</td>
                        <td>'.$row["sch_date"].'</td>
                        <td>'.$row["sch_time"].'</td>
                        <td>'.$row["note"].'</td>
                        <td>'.$row["srv_state"].'</td>
                        <td>'.$row["vendor_name"].'</td>
                        <td>'.$row["vendor_mbl"].'</td>
                        <td>'.$row["srv_del_date"].'</td>
                    </tr>
                    
                ';

            }
        $output .= '</table>';
         $filename = "ds_data_" . date('Ymd') . ".xls";
         header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        echo $output;
    }
}

?>