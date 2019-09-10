<?php
	include '../db2.php';
	$sql = "select * from app_order order by open_time desc";
	$res = mysqli_query($conn,$sql);
	
	function getMobile(&$oauth){
        include '../db2.php';
        $sql1 = "select user_mobile,first_name from users where oauth_uid = '".$oauth."'";
        $res1 = mysqli_query($conn,$sql1);
        if (mysqli_num_rows($res1) > 0) {
            $user = array();
            while($r1 = mysqli_fetch_assoc($res1)) {
                $user = $r1;
                $user['found'] = 1;
            }
        }
        else {
            $user = array('found'=>0);
        }
        return $user;
    }
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
                <th>order_sl</th>
                <th>oauth_uid</th>
                <th>user_mobile</th>
                <th>first_name</th>
                <th>order_id</th>
                <th>status</th>
                <th>d_address</th>
                <th>d_date</th>
                <th>d_timerange</th>
                <th>open_time</th>
                <th>close_time</th>
                <th>total_am</th>
                <th>disc_am</th>
                <th>net_am</th>
                <th>paid_am</th>
                <th>due_am</th>
                <th>details</th>
            </tr>
        </thead>
        <tbody>
        	<?php while($row = mysqli_fetch_assoc($res)){?>
    		
    		<?php 
                $id = $row['oauth_uid'];
                $user = array();
                $user['user_mobile'] = "---";
                $user['first_name'] = "---";
                if(!empty($id))
                    $user = getMobile($id);
            ?>
    		
    		<tr>
    			<td> <?php echo $row['order_sl'];?> </td>
    			<td> <?php echo $row['oauth_uid'];?> </td>
    			<td> <?php echo $user['user_mobile'];?> </td>
                <td> <?php echo $user['first_name'];?> </td>
    			<td> <?php echo $row['order_id'];?> </td>
    			<td> <?php echo $row['status'];?> </td>
    			<td> <?php echo $row['d_address'];?> </td>
    			<td> <?php echo $row['d_date'];?> </td>
    			<td> <?php echo $row['d_timerange'];?> </td>
    			<td> <?php echo $row['open_time'];?> </td>
    			<td> <?php echo $row['close_time'];?> </td>
    			<td> <?php echo $row['total_am'];?> </td>
    			<td> <?php echo $row['disc_am'];?> </td>
    			<td> <?php echo $row['net_am'];?> </td>
    			<td> <?php echo $row['paid_am'];?> </td>
    			<td> <?php echo $row['due_am'];?> </td>
                <?php $link = "orderdetails.php?sl=".$row['order_sl'];?>
                <td><a href="<?php echo $link?>">details</a></td>
    		</tr>  
    	<?php } ?>
        </tbody>
    </table>

</div>

</body>
</html> 




