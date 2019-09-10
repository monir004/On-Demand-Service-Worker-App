<?php
	include "db.php";

    $sql = "SELECT category.cat_id,category.cat_name,
    				subcategory.subcat_id,subcategory.subcat_name,
    				services.srv_sl,services.srvice,services.srvPrice
			FROM category
			RIGHT JOIN subcategory ON category.cat_id=subcategory.category
			RIGHT JOIN services ON services.srvSubCategory=subcategory.subcat_id
			ORDER BY category.cat_id,subcategory.subcat_id";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $categoryArray = array();
      $categoryCounter = 0;
      
      //$categoryArray["categoryCounter"] = $categoryCounter;
    }


?>
<!DOCTYPE html>
<html>
<head>
	<link rel="icon" href="images/logo.png">
	<title>Services</title>
</head>
<body>
	<table align="center" border="1">
		<tr>
			<th>sl</th>
			<th>category</th>
			<th>subcategory</th>
			<th>service</th>
			<th>price</th>
		</tr>
		<?php
			$i = 0;
			$inactive = array();
			while($r = mysqli_fetch_assoc($result)) {
				if (!isset($r["cat_name"])) {
					array_push($inactive, $r);
					continue;
				}
				$i++;
		?>
		<tr>
			<td>
				<?php echo $i; ?>
			</td>
			<td> 
				<?php echo $r["cat_name"]; ?>
			</td>
			<td>
				<?php echo $r["subcat_name"]; ?>
			</td>
			<td>
				<a href="<?php echo "http://dhakasetup.com/single.php?id=".$r["srv_sl"]; ?>"> <?php echo $r["srvice"]; ?> </a>
			</td>
			<td>
				<?php echo $r["srvPrice"]; ?>
			</td>
		</tr>
		<?php
			}
		?>
	</table>

	<br>
	<p style="text-align: center;"> ▼ inactive services ▼</p>
	<table align="center" border="1">
		<tr>
			<th>sl</th>
			<th>category</th>
			<th>subcategory</th>
			<th>service</th>
			<th>price</th>
		</tr>
		<?php
			while($r = array_pop($inactive)) {
				$i++;
		?>
		<tr>
			<td>
				<?php echo $i; ?>
			</td>
			<td> 
				<?php echo $r["cat_name"]; ?>
			</td>
			<td>
				<?php echo $r["subcat_name"]; ?>
			</td>
			<td>
				<a href="<?php echo "http://dhakasetup.com/single.php?id=".$r["srv_sl"]; ?>"> <?php echo $r["srvice"]; ?> </a>
			</td>
			<td>
				<?php echo $r["srvPrice"]; ?>
			</td>
		</tr>
		<?php
			}
		?>
	</table>
</body>
</html>