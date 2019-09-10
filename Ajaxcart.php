<?php
/**
 * Created by PhpStorm.
 * User: Fazlee Rabby
 * Date: 11-Jan-17
 * Time: 11:14 PM
 */

require_once 'includes/connection.php';
session_start();


if(isset($_POST['id'])) {
    if (isset($_POST['quantity'])) {
        $quantity = $_POST['quantity'];
    } else {
        $quantity = 1;
    }

    $id = $_POST['id'];
    $schedule_address = $_POST['address'];
    $schedule_date = $_POST['date'];
    $schedule_time = $_POST['time'];
    $userNote = $_POST['note'];

    if (isset($_COOKIE['item_on_cart'])) {
        $item_list = json_decode($_COOKIE['item_on_cart'], true);
        foreach ($item_list as $item) {
            if (in_array($id, $item)) {
                setcookie("item_on_cart", json_encode($item_list), time() + 604800);
                exit();
            }
        }
        $new_item = array("id" => $id, "quantity" => $quantity, "address" => $schedule_address, "date" => $schedule_date, "time" => $schedule_time, "note" => $userNote);
        $item_list [] = $new_item;
        setcookie("item_on_cart", json_encode($item_list), time() + 604800);
        $sql = "SELECT srvice,srvPrice,srvImage FROM services WHERE srv_sl=:sid";
        $query = $dbcon->prepare($sql);
        $query->bindValue(":sid", $id);
        $query->execute();
        while ($result = $query->fetch(PDO::FETCH_OBJ)) : ?>
            <li class="cart-item" id="<?php echo $id?>">
                <a class="aa-cartbox-img" href="single.php?id=<?php echo $id?>">
                    <img src="images/services/<?php echo $result->srvImage ?>" alt=""/>
                </a>
                <div class="aa-cartbox-info">
                    <h4><a href="single.php?id=<?php echo $id?>"><?php echo $result->srvice ?></a></h4>
                    <p><?php echo $quantity ?> x <?php echo $result->srvPrice ?></p>
                </div>
                <a class="aa-remove-product" href="#" ref="<?php echo $id?>"><span class="fa fa-times"></span></a>
            </li>
        <?php endwhile;
    } 
    else {
        $new_item = array("id" => $id, "quantity" => $quantity, "address" => $schedule_address, "date" => $schedule_date, "time" => $schedule_time, "note" => $userNote);
        $item_list [] = $new_item;
        setcookie("item_on_cart", json_encode($item_list), time() + 604800);
        $sql = "SELECT srvice,srvPrice,srvImage FROM services WHERE srv_sl=:sid";
        $query = $dbcon->prepare($sql);
        $query->bindValue(":sid", $id);
        $query->execute();
        while ($result = $query->fetch(PDO::FETCH_OBJ)) : ?>
            <li class="cart-item" id="<?php echo $id?>">
                <a class="aa-cartbox-img" href="single.php?id=<?php echo $id?>">
                    <img src="images/service/<?php echo $result->srvImage ?>" alt=""/>
                </a>
                <div class="aa-cartbox-info">
                    <h4><a href="single.php?id=<?php echo $id?>"><?php echo $result->srvice ?></a></h4>
                    <p><?php echo $quantity ?> x <?php echo $result->srvPrice ?></p>
                </div>
                <a class="aa-remove-product" href="#" ref="<?php echo $id?>"><span class="fa fa-times"></span></a>
            </li>
        <?php endwhile;
    }
}


if(isset($_POST['remove_id'])){
    $id = $_POST['remove_id'];
    $item_list = json_decode($_COOKIE['item_on_cart'], true);
    foreach ($item_list as $key => $item){
        if(in_array($id,$item)){
            unset($item_list[$key]);
        }
    }
    setcookie("item_on_cart", json_encode($item_list), time() + 604800);
    if(empty($item_list)){
        echo "<h4>EMPTY CART</h4>";
    }
}

if(isset($_POST['update_id']) && isset($_POST['quantity'])){
    $id = $_POST['update_id'];
    $result['whole_total']=0;
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $item_list = json_decode($_COOKIE['item_on_cart'], true);
    foreach ($item_list as $key => $item){
        if(in_array($id,$item)){
            $item_list[$key]['quantity'] = $quantity;
        }
    }
    setcookie('item_on_cart',json_encode($item_list),time()+604800);
    $item_list = json_decode($_COOKIE['item_on_cart'], true);
    $result['total']= $price * $quantity;
    foreach ($item_list as $key => $item){
        if(in_array($id,$item)){
            $result['whole_total'] += $result['total'];
        }
        else{
            $query = "SELECT srvPrice FROM services WHERE srv_sl=:id";
            $query = $dbcon->prepare($query);
            $query->bindValue(":id",$item['id']);
            $query->execute();
            $item_price= $query->fetch(PDO::FETCH_OBJ);
            $result['whole_total'] += $item_price->srvPrice * $item['quantity'];
        }
    }
    echo json_encode($result);
}

if(isset($_POST['update_cart_id'])){
    $update_id = $_POST['update_cart_id'];
    $newAddress = $_POST['newAddress'];
    $newDate = $_POST['newDate'];
    $newTime = $_POST['newTime'];
    $newNote = $_POST['newNote'];

    $item_list = json_decode($_COOKIE['item_on_cart'], true);
    foreach ($item_list as $key => $item){
        if(in_array($update_id,$item)){
            $item_list[$key]['address'] = $newAddress;
            $item_list[$key]['date'] = $newDate;
            $item_list[$key]['time'] = $newTime;
            $item_list[$key]['note'] = $newNote;
        }
    }
    setcookie('item_on_cart',json_encode($item_list),time()+604800);
}


if(isset($_POST['final_order'])){
    $user_id = $_SESSION['user_id'];
    $query = "SELECT user_mobile FROM users WHERE oauth_uid=:uid";
    $statement = $dbcon->prepare($query);
    $statement->bindValue(":uid",$user_id);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_OBJ);
    if($result->user_mobile == ''){
        echo '<label for="mobile">Mobile Number</label>
	       			<div class="input-group" id="user_mobile">
	       			    <span class="input-group-addon">
	              			+88
	            		</span>
	           			 <input type="text" class="form-control" name="user_number" required/>
	        		</div>';
    }
    else{
        echo '<input type="hidden" class="form-control" name="user_number" value="'. $result->user_mobile.'"/>';
        echo '<h3>PLEASE CLICK SUBMIT BUTTON TO CONFIRM YOUR ORDER</h3>';
    }
}