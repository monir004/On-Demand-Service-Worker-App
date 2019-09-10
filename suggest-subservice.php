<?php
    
    require_once 'includes/connection.php' ;

    if(isset($_POST['category'])){
  
        echo '<option>Select Subcategory</option>';
        $category = $_POST['category'];
        $query = "SELECT * FROM subcategory WHERE category_id = '$category'";
        $queryData = $dbcon->query($query);
        
        while($subcategory = $queryData->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="' . $subcategory['id'] . '">' . $subcategory['name'] . '</option>';
        }
    }

    if(isset($_POST['subcategory'])){
  
        echo '<option>Select Services</option>';
        $category = trim($_POST['categorized']);
        $subcategory = trim($_POST['subcategory']);
        $query = "SELECT name as srvice,id as srv_sl,price as srvPrice FROM service WHERE subcategory_id = '$subcategory' ORDER BY name ASC";
        $queryData = $dbcon->query($query);
        
        while($services = $queryData->fetch(PDO::FETCH_ASSOC)){
            echo '<option value="' . $services['srv_sl'] . '">' . $services['srvice'] . '</option>';
        }
    }


    if(isset($_POST['serviceID'])){
        $serviceID = trim($_POST['serviceID']);
        $query = "SELECT srvPrice FROM services WHERE srv_sl='$serviceID'";
        $queryData = $dbcon->query($query);
        $price = $queryData->fetch(PDO::FETCH_ASSOC);
        echo $price['srvPrice'];
    }

?>