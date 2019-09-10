<?php
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
        case 'GET':
            getOperation();
            break;
        default:
            print('{"result": "Requested http method not supported here."}');
}

function getOperation(){
	include "db2.php";

		$sql = "SELECT * FROM users where oauth_provider='kit'";
	    $result = mysqli_query($conn, $sql);
	    if (mysqli_num_rows($result) > 0) {
	    	$user = array();
	    	$i = 0;?>
	    	<table border='1'>
	    	    <th>oauth_uid</th>
	    	    <th>first_name</th>
	    	    <th>email</th>
	    	    <th>user_mobile</th>
	    	    <th>address</th>
	    	    <th>created</th>
	    	    <th>modified</th>
	    	    <?php
	    	while($r = mysqli_fetch_assoc($result)) {
	        	 $user[$i++] = $r;?>
	        	 <tr>
	        	    <td> <?php echo $r["oauth_uid"] ?> </td>
	        	    <td><?php echo $r["first_name"] ?></td>
	        	    <td><?php echo $r["email"] ?></td>
	        	    <td><?php echo $r["user_mobile"] ?></td>
	        	    <td><?php echo $r["address"] ?></td>
	        	    <td><?php echo $r["created"] ?></td>
	        	    <td><?php echo $r["modified"] ?></td>
	        	    
	        	 </tr>
	        	 <?php
	      	}?>
	      	</table>
	      	<?php
	      	//echo json_encode($user);
		}
		else {
		    echo "zero";
		}
	
}
?>