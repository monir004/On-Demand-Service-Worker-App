<?php
	include '../db2.php';
	$sql = "select * from app_order_details where order_sl='".$_GET['sl']."'";
	$res = mysqli_query($conn,$sql);
?>


 <!DOCTYPE html>
<html lang="en">
<head>
  <title>App Orders</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
</head>
<body>

<div class="container">
  
        
  	<table border="1">
        <thead>
            <tr>

                <th>id</th>
                <th>order_sl</th>
                <th>srv_sl</th>
                <th>srvice</th>
                <th>srvImage</th>
                <th>srvQty</th>
                <th>srvPrice</th>
                <th>srvTotal</th>
                <th>prop_id</th>
                <th>prop_name</th>
                <th>prop_qty</th>
                <th>prop_price</th>
                <th>prop_total</th>
            </tr>
        </thead>
        <tbody>
        	<?php while($row = mysqli_fetch_assoc($res)){?>
    		<tr>
    			<td> <?php echo $row['id'];?> </td>
    			<td> <?php echo $row['order_sl'];?> </td>
    			<td> <?php echo $row['srv_sl'];?> </td>
    			<td> <?php echo $row['srvice'];?> </td>
    			<td> <?php echo $row['srvImage'];?> </td>
    			<td> <?php echo $row['srvQty'];?> </td>
    			<td> <?php echo $row['srvPrice'];?> </td>
    			<td> <?php echo $row['srvTotal'];?> </td>
    			<td> <?php echo $row['prop_id'];?> </td>
    			<td> <?php echo $row['prop_name'];?> </td>
    			<td> <?php echo $row['prop_qty'];?> </td>
    			<td> <?php echo $row['prop_price'];?> </td>
                <td> <?php echo $row['prop_total'];?> </td>
    		</tr>  
    	<?php } ?>
        </tbody>
    </table>

    <a href="orderview.php">back to all orders</a>

</div>

</body>
</html> 




