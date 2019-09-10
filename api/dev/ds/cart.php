<?php
require_once "main-header-dhaka-setup.php";
require_once "includes/connection.php";

if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
}
else{
	echo "<script>location.href='index.php'</script>";
}

$user_query = "SELECT first_name,last_name,email,user_mobile FROM users WHERE oauth_uid= '$user_id'";
$user_query = $dbcon->query($user_query);
$user_data = $user_query->fetch(PDO::FETCH_OBJ);

?>
	
	<!-- Cart Page -->
	<div class="cart">
		<div class="container">
			<div class="row">
				<div class="header">
					<h2>Cart</h2>
				</div>

				<?php $total=0; if($item_available) : ?>

				<div class="cart-info">
					<form action="" method="">
						<table class="table table-bordered" id="cart-table">
							<tr>
								<th></th>
								<th>PRODUCTS</th>
								<th>Schedule Address</th>
								<th>Schedule Date</th>
								<th>Schedule Time</th>
								<th>PRICE</th>
								<th>QUANTITY</th>
								<th>TOTAL</th>
								<th>ACTION</th>
							</tr>
							<?php foreach ($item_list as $item) {
								$sql = "SELECT srv_sl,srvice,srvPrice,srvImage FROM services WHERE srv_sl=:sid";
								$query = $dbcon->prepare($sql);
								$query->bindValue(":sid", $item['id']);
								$query->execute();
								while ($result = $query->fetch(PDO::FETCH_OBJ)) : ?>
									<tr id="<?php echo $result->srv_sl ?>">
										<td><a href="single.php?id=<?php echo $result->srv_sl ?>"><img src="images/services/<?php echo $result->srvImage ?>"/></a>
										</td>
										<td class="product"><?php echo $result->srvice ?></td>
										<td id="address"><?php echo $item['address'] ?></td>
										<td id="date"><?php echo $item['date'] ?></td>
										<td id="time"><?php echo $item['time'] ?></td>
										<td id="price"><?php echo $result->srvPrice ?></td>
										<td><input type="number" id="<?php echo $result->srv_sl; ?>" class="quantity" min="1" value="<?php echo $item['quantity'] ?>"></td>
										<td id="totalCost"><?php echo $item['quantity'] * $result->srvPrice ?></td>
										<input type="hidden" id="note" value="<?php echo $item['note']?>">
										<td><a href="<?php echo $result->srv_sl ?>" class="remove"><i class="fa fa-times"></i></a>&nbsp;&nbsp;&nbsp;<a href="<?php echo $result->srv_sl ?>" class="update-button" data-toggle="modal" data-target="#editcartModal"><i class="fa fa-pencil"></i></a></td>
									</tr>
									<?php $total += $item['quantity'] * $result->srvPrice; ?>
								<?php endwhile;
							}
							?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><strong>TOTAL</strong></td>
								<td class="whole_total"> <?php echo $total?></td>
								<td></td>
							</tr>

						</table>

						<div class="col-md-3">
<!--							<input type="text" name="" placeholder="Coupon code" />-->
						</div>

						<div class="col-md-3">
							<a href="index.php" style="display: none" id="goback" class="btn">Back to The Services</a>
						</div>

						<div class="col-md-6">
							<div class="right-button pull-right">
								<button type="button" id="booknow" class="btn gray" data-toggle="modal" data-target="#cartModal">book now</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="cartModal" aria-hidden="true">
  		<div class="modal-dialog" role="document">
    		<div class="modal-content">
      			<div class="modal-header">
        			<h3>CART</h3>
        			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          				<span aria-hidden="true">&times;</span>
       				 </button>
      			</div>
      			<div class="modal-body">
					<form action="user_order.php" method="post">
					<div class="mobile_number"></div>
					<div class="user_info">
						<h4>Name: <?php echo $user_data->first_name . " " . $user_data->last_name?></h4>
						<h4>Email: <?php echo $user_data->email?></h4>
						<h4>Mobile Number: <?php echo $user_data->user_mobile?></h4>
					</div>
      			</div>
		        <div class="modal-footer">
		        	<button type="submit" class="btn">submit</button>
		        </div>
				</form>
    </div>
  </div>
</div>
<div class="overlay"></div>

<!-- cart modal -->
	<div id="cart-modal">
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cartModalLabel" id="editcartModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title" id="cartModalLabel"><span class="fa fa-shopping-cart"></span> Cart Information</h4>
					</div>
					<div class="modal-body">
						<form action="" method="post">
							<label for="sch-date">Schedule Date</label>
							<input type="text" placeholder="Please select a date" name="sch-date" required id="user-sch-date">
							<label for="sch-time">Schedule Time</label>
							<select name="schedule-time" id="users-sch-time" required>
								<option>Select your time</option>
								<option value="09:00am-11:00am">09:00am-11:00am</option>
								<option value="11:00am-01:00pm">11:00am-01:00pm</option>
								<option value="01:00pm-03:00pm">01:00pm-03:00pm</option>
								<option value="03:00pm-05:00pm">03:00pm-05:00pm</option>
								<option value="05:00pm-07:00pm">05:00pm-07:00pm</option>
								<option value="07:00pm-09:00pm">07:00pm-09:00pm</option>
							</select>
							<label for="sch-date">Schedule Address</label>
							<textarea placeholder="Please enter your address" name="sch-addrs" rows="5" required id="user-sch-addrs"></textarea>
							<label for="users-note">Short Note</label>
							<textarea style="border: 1px solid #ccc;border-radius: 0px" type="text" name="note" id="users-note" cols="30" rows="5" class="form-control col-md-7 col-xs-12"></textarea>
							<button class="btn btn-default col-md-offset-10 update-cart" value="" style="margin-top: 30px;">UPDATE</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php endif;?>

<?php if(!$item_available) : ?>
	<div class="empty" style="margin: 50px auto">
		<div class="container">
			<h2>YOUR CART IS EMPTY</h2>
			<a href="index.php" class="btn" >Back To The Service</a>
		</div>
	</div>
	</div>
	</div>
	</div>
<?php endif;?>


	<?php
	require_once "main-footer-dhaka-setup.php";
	?>
	<script type="text/javascript">
		$('#schedule').datepicker({});

    </script>